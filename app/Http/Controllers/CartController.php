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
        $updated = false;
        
        foreach ($cart as $id => &$item) {
            $product = Product::find($id);
            if ($product && $product->is_active) {
                $item['stock'] = (int)$product->stock;
                // Jika kuantitas di keranjang melebihi stok yang ada di database saat ini
                if ($product->stock <= 0) {
                    unset($cart[$id]);
                    $updated = true;
                    continue;
                } elseif ($item['quantity'] > $product->stock) {
                    $item['quantity'] = $product->stock;
                    $updated = true;
                }
                $totalAmount += $item['price'] * $item['quantity'];
            } else {
                // Hapus jika produk dihapus atau dinonaktifkan
                unset($cart[$id]);
                $updated = true;
            }
        }
        unset($item);

        if ($updated) {
            session()->put('cart', $cart);
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
        
        if (!$product || !$product->is_active) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan atau sedang tidak aktif.'], 404);
        }

        if ($product->stock <= 0) {
            return response()->json(['success' => false, 'message' => 'Maaf, stok produk ini sedang habis.'], 422);
        }

        $addQuantity = max(1, (int)$request->input('quantity', 1));
        $cart = session()->get('cart', []);
        $currentQuantity = isset($cart[$product->id]) ? (int)$cart[$product->id]['quantity'] : 0;
        $newQuantity = $currentQuantity + $addQuantity;

        // Validasi jika jumlah total melebihi stok
        if ($newQuantity > $product->stock) {
            return response()->json([
                'success' => false, 
                'message' => "Jumlah melebihi stok yang tersedia (Tersisa: {$product->stock}, di keranjang: {$currentQuantity})"
            ], 422);
        }

        // Masukkan atau update item di keranjang
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => $newQuantity,
            "price" => $product->price,
            "image" => $product->image,
            "stock" => (int)$product->stock
        ];

        // SIMPAN KE SESSION
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true, 
            'message' => "{$product->name} berhasil ditambahkan ke keranjang!"
        ]);
    }

    // Mengubah jumlah item (+ atau -)
    public function update(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product || !$product->is_active) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
        }

        $quantity = (int)$request->quantity;
        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Jumlah minimal 1.'], 422);
        }

        if ($quantity > $product->stock) {
            return response()->json([
                'success' => false, 
                'message' => "Jumlah tidak boleh melebihi stok yang tersedia ({$product->stock})."
            ], 422);
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $quantity;
            $cart[$request->id]['stock'] = (int)$product->stock;
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