<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Menampilkan halaman khusus manajemen stok produk
    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('stock', 'asc')->get();

        $totalStock = $products->sum('stock');
        $totalProducts = $products->count();
        $lowStockCount = $products->where('stock', '>', 0)->where('stock', '<=', 50)->count();
        $outOfStockCount = $products->where('stock', '<=', 0)->count();

        return view('admin.stock.index', compact(
            'products',
            'totalStock',
            'totalProducts',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    // Memproses penambahan stok produk
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'additional_stock' => 'required|integer|min:1',
        ], [
            'product_id.required' => 'Pilih produk yang ingin ditambahkan stoknya.',
            'product_id.exists' => 'Produk tidak valid.',
            'additional_stock.required' => 'Jumlah stok tambahan wajib diisi.',
            'additional_stock.integer' => 'Jumlah stok harus berupa angka bulat.',
            'additional_stock.min' => 'Jumlah stok tambahan minimal 1.',
        ]);

        $product = Product::findOrFail($request->product_id);
        $added = (int)$request->additional_stock;

        $product->increment('stock', $added);

        return redirect()->route('admin.stock.index')->with('success', "Stok untuk produk '{$product->name}' berhasil ditambahkan sebanyak +{$added} (Total stok saat ini: {$product->stock}).");
    }
}
