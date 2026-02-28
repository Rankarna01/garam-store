<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pendapatan (Hanya pesanan yang sudah dibayar/selesai)
        $totalRevenue = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->sum('total_price');

        // 2. Pesanan Baru (Status Pending)
        $newOrdersCount = Order::where('status', 'pending')->count();

        // 3. Total Produk Aktif
        $totalProducts = Product::count();

        // 4. Pelanggan Aktif (Role Customer)
        $activeCustomers = User::where('role', 'customer')->count();

        // 5. Pesanan Terbaru (5 Transaksi terakhir)
        $recentOrders = Order::latest()->take(5)->get();

        // 6. Data Grafik Penjualan (7 Hari Terakhir)
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $last7Days->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        $salesData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->whereIn('status', ['paid', 'processed', 'shipped', 'completed'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->pluck('total', 'date');

        // Gabungkan tanggal kosong dengan nilai 0 agar grafik tidak error
        $chartLabels = [];
        $chartTotals = [];
        foreach ($last7Days as $date) {
            $chartLabels[] = Carbon::parse($date)->translatedFormat('d M'); // Contoh: 27 Feb
            $chartTotals[] = $salesData->has($date) ? $salesData[$date] : 0;
        }

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'newOrdersCount', 
            'totalProducts', 
            'activeCustomers', 
            'recentOrders',
            'chartLabels',
            'chartTotals'
        ));
    }
}