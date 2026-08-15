<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Fitur Tambah Stok Produk
    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'additional_stock' => 'required|integer|min:1',
        ], [
            'additional_stock.required' => 'Jumlah stok wajib diisi.',
            'additional_stock.integer' => 'Jumlah stok harus berupa angka bulat.',
            'additional_stock.min' => 'Jumlah stok minimal 1.',
        ]);

        $added = (int)$request->additional_stock;
        $product->increment('stock', $added);

        return redirect()->route('admin.products.index')->with('success', "Stok untuk '{$product->name}' berhasil ditambah sebanyak +{$added}. (Total stok sekarang: {$product->stock})");
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}