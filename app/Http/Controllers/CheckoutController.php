<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect('/#products')->with('error', 'Keranjang Anda kosong! Silakan pilih produk terlebih dahulu.');
        }

        $totalAmount = 0;
        $cartModified = false;
        $warningMessages = [];

        foreach($cartItems as $id => &$item) {
            $product = Product::find($id);
            if (!$product || !$product->is_active || $product->stock <= 0) {
                unset($cartItems[$id]);
                $cartModified = true;
                $warningMessages[] = "Produk '" . ($item['name'] ?? 'Pilihan') . "' telah dihapus dari keranjang karena stok habis.";
                continue;
            }

            if ($item['quantity'] > $product->stock) {
                $item['quantity'] = $product->stock;
                $cartModified = true;
                $warningMessages[] = "Jumlah produk '{$product->name}' disesuaikan menjadi {$product->stock} sesuai sisa stok.";
            }

            $item['stock'] = $product->stock;
            $totalAmount += $item['price'] * $item['quantity'];
        }
        unset($item);

        if ($cartModified) {
            session()->put('cart', $cartItems);
            if (empty($cartItems)) {
                return redirect('/#products')->with('error', 'Semua item di keranjang Anda habis atau tidak tersedia.');
            }
        }

        return view('checkout', compact('cartItems', 'totalAmount'))->with('warningMessages', $warningMessages);
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'required|string',
        ]);

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect('/#products')->with('error', 'Keranjang Anda kosong!');
        }

        try {
            $order = DB::transaction(function () use ($request, $cartItems) {
                $totalAmount = 0;
                $lockedProducts = [];

                // 1. Validasi & Kunci Stok Setiap Produk
                foreach ($cartItems as $id => $details) {
                    $product = Product::lockForUpdate()->find($id);

                    if (!$product || !$product->is_active) {
                        throw new \Exception("Produk '{$details['name']}' sudah tidak aktif atau tidak ditemukan.");
                    }

                    $requestedQty = (int)$details['quantity'];
                    if ($requestedQty < 1) {
                        throw new \Exception("Jumlah pesanan untuk '{$product->name}' tidak valid.");
                    }

                    if ($product->stock < $requestedQty) {
                        throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi. Tersedia: {$product->stock}, diminta: {$requestedQty}.");
                    }

                    $itemTotal = $product->price * $requestedQty;
                    $totalAmount += $itemTotal;

                    $lockedProducts[] = [
                        'product' => $product,
                        'quantity' => $requestedQty,
                        'price' => $product->price,
                        'name' => $product->name,
                    ];
                }

                // 2. Simpan Pesanan ke Database
                $newOrder = Order::create([
                    'user_id' => auth()->id(),
                    'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
                    'customer_name' => $request->name,
                    'customer_email' => $request->email,
                    'customer_phone' => $request->phone,
                    'customer_address' => $request->address,
                    'total_price' => $totalAmount,
                    'status' => 'pending',
                    'payment_method' => 'midtrans',
                    'order_type' => 'online',
                ]);

                // 3. Simpan Item Pesanan & Kurangi Stok Produk
                foreach ($lockedProducts as $item) {
                    OrderItem::create([
                        'order_id' => $newOrder->id,
                        'product_id' => $item['product']->id,
                        'product_name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                    ]);

                    // POTONG STOK PRODUK
                    $item['product']->decrement('stock', $item['quantity']);
                }

                // 4. Konfigurasi Midtrans & Request Snap Token
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $newOrder->invoice_number,
                        'gross_amount' => (int)$newOrder->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => $newOrder->customer_name,
                        'email' => $newOrder->customer_email,
                        'phone' => $newOrder->customer_phone,
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $newOrder->snap_token = $snapToken;
                $newOrder->save();

                return $newOrder;
            });

            // Simpan invoice ke session untuk riwayat pesanan (Guest/Auth)
            $myOrders = session()->get('my_orders', []);
            if (!in_array($order->invoice_number, $myOrders)) {
                session()->push('my_orders', $order->invoice_number);
            }

            session()->forget('cart'); // Kosongkan keranjang setelah checkout sukses

            return redirect()->route('checkout.payment', $order->invoice_number);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses checkout: ' . $e->getMessage());
        }
    }

    // Menampilkan halaman tombol bayar Snap
    public function payment($invoice_number)
    {
        $order = Order::where('invoice_number', $invoice_number)->firstOrFail();
        
        // Jika sudah dibayar, lempar ke halaman sukses
        if(in_array($order->status, ['paid', 'processed', 'shipped', 'completed'])) {
            return redirect()->route('order.track', $order->invoice_number)->with('success', 'Pesanan ini sudah berhasil dibayar.');
        }

        return view('payment', compact('order'));
    }

    // Menangani Webhook/Notifikasi dari Midtrans (Berjalan di background)
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $order = Order::where('invoice_number', $request->order_id)->with('items')->first();
            
            if ($order) {
                // Jika pembayaran berhasil
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $order->update(['status' => 'paid']);
                } 
                // Jika pembayaran kadaluarsa, gagal, atau dibatalkan
                else if (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                    // Jika sebelumnya belum cancelled, kembalikan stok produk
                    if ($order->status !== 'cancelled') {
                        $order->update(['status' => 'cancelled']);
                        foreach ($order->items as $item) {
                            if ($item->product_id) {
                                $prod = Product::find($item->product_id);
                                if ($prod) {
                                    $prod->increment('stock', $item->quantity);
                                }
                            }
                        }
                    }
                }
                // Jika pembayaran masih pending
                else if ($request->transaction_status == 'pending') {
                    $order->update(['status' => 'pending']);
                }
            }
        }
        
        return response()->json(['message' => 'Callback received']);
    }

    // Fungsi Workaround untuk update status via Frontend (Khusus Localhost/Testing)
    public function successLocal($invoice_number)
    {
        $order = Order::where('invoice_number', $invoice_number)->first();
        
        if ($order && $order->status == 'pending') {
            $order->update(['status' => 'paid']);
            return response()->json(['success' => true, 'message' => 'Status berhasil diubah ke Paid']);
        }

        return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau sudah dibayar']);
    }
}