<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    
    // Menampilkan daftar semua pesanan
    public function index() {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail spesifik satu pesanan
    public function show(Order $order) {
        $order->load('items'); // Load relasi items
        return view('admin.orders.show', compact('order'));
    }

    // Memperbarui status pesanan & resi
    public function update(Request $request, Order $order) {
        $request->validate([
            'status' => 'required|in:pending,paid,processed,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255'
        ]);

        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}