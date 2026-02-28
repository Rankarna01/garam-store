<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;

class FrontController extends Controller
{
    // Menampilkan halaman utama (Landing Page)
    public function index()
    {
        // Ambil produk yang berstatus aktif, urutkan dari yang terbaru, batasi 6 produk
        $products = Product::where('is_active', true)->latest()->take(6)->get();
        $testimonials = \App\Models\Testimonial::where('is_active', true)->latest()->take(5)->get();
        
        return view('welcome', compact('products', 'testimonials'));
    }

    // Menampilkan halaman detail produk
    public function show($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        return view('product-detail', compact('product'));
    }

    // Menampilkan halaman riwayat & pelacakan pesanan
   public function trackOrder($invoice_number)
    {
        // Pastikan hanya pemilik invoice yang bisa melihat track-nya
        $order = auth()->user()->orders()->where('invoice_number', $invoice_number)->with('items')->firstOrFail();
        return view('order-track', compact('order'));
    }

   public function myOrders()
    {
        // Ambil pesanan milik user yang sedang login saja!
        $orders = auth()->user()->orders()->latest()->get();
        return view('my-orders', compact('orders'));
    }
}