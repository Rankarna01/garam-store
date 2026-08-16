<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller {
    
    // Menampilkan daftar semua pesanan dengan pencarian & filter
    public function index(Request $request) {
        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('type') && in_array($request->type, ['online', 'offline'])) {
            $query->where('order_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Urutkan berdasarkan tanggal transaksi (created_at DESC) dan id terbaru
        $orders = $query->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    // Form input transaksi langsung / manual (Cash) oleh Admin
    public function create() {
        $products = Product::where('is_active', true)->orderBy('name', 'asc')->get();
        return view('admin.orders.create', compact('products'));
    }

    // Menyimpan transaksi manual langsung / cash
    public function storeManual(Request $request) {
        Log::info('Memulai proses input transaksi manual oleh Admin', [
            'admin_id' => auth()->id(),
            'payload' => $request->except(['_token']),
        ]);

        // Filter item yang kosong jika ada baris yang belum dipilih produknya
        if ($request->has('items') && is_array($request->items)) {
            $filteredItems = array_values(array_filter($request->items, function ($item) {
                return !empty($item['product_id']);
            }));
            $request->merge(['items' => $filteredItems]);
        }

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
            'items.*.product_id.required' => 'Pilih produk garam pada setiap baris item.',
            'items.*.product_id.exists' => 'Produk pilihan tidak valid.',
            'items.*.quantity.min' => 'Jumlah kuantitas item minimal 1.',
        ]);

        try {
            $order = DB::transaction(function () use ($request) {
                $totalAmount = 0;
                $processedItems = [];

                // 1. Validasi Stok & Lock Produk
                foreach ($request->items as $index => $itemData) {
                    $productId = $itemData['product_id'];
                    $qty = (int)$itemData['quantity'];

                    $product = Product::lockForUpdate()->find($productId);

                    if (!$product || !$product->is_active) {
                        throw new \Exception("Produk pada baris #" . ($index + 1) . " tidak ditemukan atau tidak aktif.");
                    }

                    if ($product->stock < $qty) {
                        throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi! (Sisa Stok: {$product->stock}, Diminta: {$qty}).");
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

                // 2. Buat Record Order dengan Tanggal yang Dipilih
                $orderDate = $request->filled('order_date') ? Carbon::parse($request->order_date) : Carbon::now();
                $invoiceNumber = 'INV-CASH-' . $orderDate->format('Ymd') . '-' . strtoupper(Str::random(5));

                $order = new Order();
                $order->user_id = auth()->id();
                $order->invoice_number = $invoiceNumber;
                $order->customer_name = $request->customer_name;
                $order->customer_email = $request->customer_email ?? 'offline@merisajaya.com';
                $order->customer_phone = $request->customer_phone ?? '-';
                $order->customer_address = $request->customer_address ?? 'Pembelian Langsung di Toko (Offline/Cash)';
                $order->total_price = $totalAmount;
                $order->status = 'completed'; // Langsung selesai karena bayar di tempat
                $order->payment_method = $request->payment_method ?? 'cash';
                $order->order_type = 'offline';
                $order->notes = $request->notes;
                $order->created_at = $orderDate;
                $order->updated_at = $orderDate;
                $order->save();

                // 3. Buat Record OrderItem & Kurangi Stok Produk
                foreach ($processedItems as $pItem) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $pItem['product']->id;
                    $orderItem->product_name = $pItem['name'];
                    $orderItem->quantity = $pItem['quantity'];
                    $orderItem->price = $pItem['price'];
                    $orderItem->created_at = $orderDate;
                    $orderItem->updated_at = $orderDate;
                    $orderItem->save();

                    // Potong stok produk langsung
                    $pItem['product']->decrement('stock', $pItem['quantity']);
                }

                Log::info('Transaksi manual berhasil dibuat', [
                    'order_id' => $order->id,
                    'invoice' => $order->invoice_number,
                    'total' => $order->total_price,
                    'created_at' => $order->created_at->toDateTimeString(),
                ]);

                return $order;
            });

            return redirect()->route('admin.orders.index')->with('success', "Transaksi langsung/cash berhasil dicatat (No. Invoice: {$order->invoice_number}). Tanggal tercatat: {$order->created_at->format('d/m/Y H:i')}. Stok terpotong dan masuk laporan penjualan!");

        } catch (\Exception $e) {
            Log::error('Gagal mencatat transaksi manual: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'request_payload' => $request->all(),
            ]);

            return back()->withInput()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage());
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