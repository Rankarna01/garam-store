<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Menambah produk ke keranjang
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true, 
            'message' => 'Produk ditambahkan!',
            'cartCount' => collect($cart)->sum('quantity'),
            'cartData' => $cart
        ]);
    }

    // Mengupdate jumlah (Qqty)
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }
    }

    // Menghapus produk dari keranjang
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
    }

    // Mengambil data keranjang (untuk update UI Drawer)
    public function getCart()
    {
        return response()->json([
            'cartData' => session()->get('cart', []),
            'totalAmount' => $this->calculateTotal()
        ]);
    }

    private function calculateTotal()
    {
        $total = 0;
        foreach(session('cart', []) as $details){
            $total += $details['price'] * $details['quantity'];
        }
        return $total;
    }
}