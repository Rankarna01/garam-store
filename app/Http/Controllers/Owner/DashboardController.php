<?php

namespace App\Http\Controllers\Owner;

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
        // 1. Total Pendapatan (Hanya yang sudah dibayar/selesai)
        $totalRevenue = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->sum('total_price');

        // 2. Total Transaksi Berhasil
        $totalOrders = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->count();

        // 3. Total Pelanggan
        $totalCustomers = User::where('role', 'customer')->count();

        // 4. Total Produk Aktif
        $totalProducts = Product::where('is_active', true)->count();

        // 5. 5 Transaksi Terakhir (Hanya yang sudah sukses bayar)
        $recentOrders = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])
                             ->latest()
                             ->take(5)
                             ->get();

        // 6. Data Grafik Pendapatan (7 Hari Terakhir)
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $last7Days->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        $salesData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->whereIn('status', ['paid', 'processed', 'shipped', 'completed'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->pluck('total', 'date');

        // Mapping data agar hari yang kosong (Rp 0) tetap masuk ke grafik
        $chartLabels = [];
        $chartTotals = [];
        foreach ($last7Days as $date) {
            $chartLabels[] = Carbon::parse($date)->translatedFormat('d M'); // Format: 28 Apr
            $chartTotals[] = $salesData->has($date) ? $salesData[$date] : 0;
        }

        return view('owner.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalCustomers', 'totalProducts',
            'recentOrders', 'chartLabels', 'chartTotals'
        ));
    }
}