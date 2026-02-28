<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;


class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        
        // HAPUS COMMENT INI JIKA SUDAH PAKAI KERANJANG SUNGGUHAN
        // if (empty($cartItems)) {
        //     return redirect('/#products')->with('error', 'Keranjang Anda kosong!');
        // }

        $totalAmount = 0;
        foreach($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Dummy data jika keranjang kosong (untuk testing)
        if(empty($cartItems)) { $totalAmount = 150000; } 

        return view('checkout', compact('cartItems', 'totalAmount'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $cartItems = session()->get('cart', []);
        
        $totalAmount = 0;
        foreach($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Dummy data total jika kosong
        if(empty($cartItems)) { $totalAmount = 150000; }

        // 1. Simpan ke database
        $order = Order::create([
            'user_id' => auth()->id(), // <== INI TAMBAHANNYA
            'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address,
            'total_price' => $totalAmount,
            'status' => 'pending',
        ]);

        // 2. Simpan Item (Jika ada)
        if(!empty($cartItems)){
            foreach($cartItems as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $details['name'],
                    'price' => $details['price'],
                    'quantity' => $details['quantity'],
                ]);
            }
        }

        // 3. SIMPAN INVOICE KE SESSION UNTUK RIWAYAT PESANAN (GUEST)
        $myOrders = session()->get('my_orders', []);
        if(!in_array($order->invoice_number, $myOrders)){
            session()->push('my_orders', $order->invoice_number);
        }

        // 3. Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // 4. Buat Payload untuk dikirim ke Midtrans
        $params = array(
            'transaction_details' => array(
                'order_id' => $order->invoice_number,
                'gross_amount' => $order->total_price,
            ),
            'customer_details' => array(
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
            ),
        );

        // 5. Dapatkan Snap Token
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();

            session()->forget('cart'); // Kosongkan keranjang

            // Arahkan ke halaman pembayaran
            return redirect()->route('checkout.payment', $order->invoice_number);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran dengan Midtrans. ' . $e->getMessage());
        }
    }

    // Menampilkan halaman tombol bayar Snap
    public function payment($invoice_number)
    {
        $order = Order::where('invoice_number', $invoice_number)->firstOrFail();
        
        // Jika sudah dibayar, lempar ke halaman sukses
        if($order->status == 'paid' || $order->status == 'processed' || $order->status == 'shipped' || $order->status == 'completed') {
            return redirect()->route('order.track', $order->invoice_number)->with('success', 'Pesanan ini sudah berhasil dibayar.');
        }

        return view('payment', compact('order'));
    }

    // Menangani Webhook/Notifikasi dari Midtrans (Berjalan di background)
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        // Midtrans mengirimkan signature_key untuk memvalidasi bahwa request ini asli dari server mereka
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if($hashed == $request->signature_key) {
            // Cari pesanan berdasarkan Invoice Number
            $order = Order::where('invoice_number', $request->order_id)->first();
            
            if($order) {
                // Jika pembayaran berhasil (sukses ditangkap atau di-settle oleh bank)
                if($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $order->update(['status' => 'paid']); // <-- Mengubah status ke Sudah Dibayar
                } 
                // Jika pembayaran kadaluarsa, gagal, atau dibatalkan
                else if ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
                    $order->update(['status' => 'cancelled']);
                }
                // Jika pembayaran masih pending (misal baru cetak kode VA tapi belum transfer)
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
        
        if($order && $order->status == 'pending') {
            // Ubah status menjadi paid
            $order->update(['status' => 'paid']);
            return response()->json(['success' => true, 'message' => 'Status berhasil diubah ke Paid']);
        }

        return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau sudah dibayar']);
    }
}