<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan model Product dipanggil

class CartController extends Controller
{
    // Mengambil semua isi keranjang untuk ditampilkan di Drawer
    public function getCart()
    {
        $cart = session()->get('cart', []);
        $totalAmount = 0;
        
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'cartData' => $cart,
            'totalAmount' => $totalAmount
        ]);
    }

    // Menambah produk ke keranjang
    public function add(Request $request)
    {
        $product = Product::find($request->product_id);
        
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan']);
        }

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambah jumlahnya
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // Jika belum ada, masukkan sebagai item baru
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image // Pastikan nama kolom gambar di database adalah 'image'
            ];
        }

        // SIMPAN KE SESSION
        session()->put('cart', $cart);
        
        return response()->json(['success' => true, 'message' => 'Berhasil masuk keranjang!']);
    }

    // Mengubah jumlah item (+ atau -)
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart); // Simpan perubahan
        }
        
        return response()->json(['success' => true]);
    }

    // Menghapus item dari keranjang (Tombol X)
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]); // Hapus dari array
            session()->put('cart', $cart); // Simpan perubahan
        }
        
        return response()->json(['success' => true]);
    }
}