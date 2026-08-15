<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller {
    
    // Menampilkan daftar semua pesanan
    public function index() {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Form input transaksi langsung / manual (Cash) oleh Admin
    public function create() {
        $products = Product::where('is_active', true)->orderBy('name', 'asc')->get();
        return view('admin.orders.create', compact('products'));
    }

    // Menyimpan transaksi manual langsung / cash
    public function storeManual(Request $request) {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:500',
            'payment_method' => 'nullable|in:cash',
            'order_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'nullable|numeric|min:0',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'items.required' => 'Minimal harus memilih 1 produk yang dibeli.',
            'items.min' => 'Minimal harus memilih 1 produk yang dibeli.',
            'items.*.quantity.min' => 'Jumlah kuantitas item minimal 1.',
        ]);

        try {
            $order = DB::transaction(function () use ($request) {
                $totalAmount = 0;
                $processedItems = [];

                // 1. Validasi Stok & Lock Produk
                foreach ($request->items as $itemData) {
                    $productId = $itemData['product_id'];
                    $qty = (int)$itemData['quantity'];

                    $product = Product::lockForUpdate()->find($productId);

                    if (!$product || !$product->is_active) {
                        throw new \Exception("Produk pilihan tidak aktif atau tidak ditemukan.");
                    }

                    if ($product->stock < $qty) {
                        throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi! (Tersedia: {$product->stock}, Diminta: {$qty}).");
                    }

                    // Gunakan harga custom jika diisi admin, atau default harga produk
                    $price = isset($itemData['price']) && is_numeric($itemData['price']) ? (float)$itemData['price'] : (float)$product->price;
                    $itemSubtotal = $price * $qty;
                    $totalAmount += $itemSubtotal;

                    $processedItems[] = [
                        'product' => $product,
                        'name' => $product->name,
                        'price' => $price,
                        'quantity' => $qty,
                    ];
                }

                // 2. Buat Record Order
                $orderDate = $request->order_date ? Carbon::parse($request->order_date) : Carbon::now();
                $invoiceNumber = 'INV-CASH-' . $orderDate->format('Ymd') . '-' . strtoupper(Str::random(5));

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'invoice_number' => $invoiceNumber,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email ?? 'offline@merisajaya.com',
                    'customer_phone' => $request->customer_phone ?? '-',
                    'customer_address' => $request->customer_address ?? 'Pembelian Langsung di Toko (Offline/Cash)',
                    'total_price' => $totalAmount,
                    'status' => 'completed', // Langsung selesai karena bayar di tempat
                    'payment_method' => $request->payment_method ?? 'cash',
                    'order_type' => 'offline',
                    'notes' => $request->notes,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);

                // 3. Buat Record OrderItem & Kurangi Stok Produk
                foreach ($processedItems as $pItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $pItem['product']->id,
                        'product_name' => $pItem['name'],
                        'quantity' => $pItem['quantity'],
                        'price' => $pItem['price'],
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);

                    // Potong stok produk langsung
                    $pItem['product']->decrement('stock', $pItem['quantity']);
                }

                return $order;
            });

            return redirect()->route('admin.orders.index')->with('success', "Transaksi langsung/cash berhasil dicatat (No. Invoice: {$order->invoice_number}). Stok telah otomatis terpotong dan masuk ke laporan penjualan!");

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mencatat transaksi manual: ' . $e->getMessage());
        }
    }

    // Menampilkan detail spesifik satu pesanan
    public function show(Order $order) {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    // Cetak Struk / Invoice Pembelian
    public function invoice(Order $order) {
        $order->load(['items.product', 'user']);
        return view('admin.orders.invoice', compact('order'));
    }

    // Memperbarui status pesanan & resi
    public function update(Request $request, Order $order) {
        $request->validate([
            'status' => 'required|in:pending,paid,processed,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Logika Pengembalian / Pengurangan Stok saat perubahan status
        if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
            // Kembalikan stok
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $prod = Product::find($item->product_id);
                    if ($prod) {
                        $prod->increment('stock', $item->quantity);
                    }
                }
            }
        } elseif ($oldStatus === 'cancelled' && in_array($newStatus, ['pending', 'paid', 'processed', 'shipped', 'completed'])) {
            // Cek ketersediaan stok sebelum re-aktifasi pesanan
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $prod = Product::find($item->product_id);
                    if ($prod && $prod->stock < $item->quantity) {
                        return redirect()->back()->with('error', "Gagal mengubah status: Stok produk '{$prod->name}' tidak mencukupi untuk re-aktivasi pesanan (Tersedia: {$prod->stock}, Butuh: {$item->quantity}).");
                    }
                }
            }
            // Kurangi stok kembali
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    $prod = Product::find($item->product_id);
                    if ($prod) {
                        $prod->decrement('stock', $item->quantity);
                    }
                }
            }
        }

        $order->update([
            'status' => $newStatus,
            'tracking_number' => $request->tracking_number,
            'notes' => $request->notes ?? $order->notes
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}