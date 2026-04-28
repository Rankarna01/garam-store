<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Menampilkan halaman utama laporan
    public function index()
    {
        $salesData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
                    ->whereIn('status', ['paid', 'processed', 'shipped', 'completed'])
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->take(30)
                    ->get();

        $orders = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->latest()->get();
        $totalRevenue = $orders->sum('total_price');

        return view('owner.reports.index', compact('salesData', 'orders', 'totalRevenue'));
    }

    // Fungsi Cetak Excel (Format CSV)
    public function exportExcel()
    {
        $orders = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->latest()->get();
        $filename = "Laporan_Keuangan_Merisa_Jaya_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use($orders) {
            $file = fopen('php://output', 'w');
            // Header Kolom di Excel
            fputcsv($file, ['No', 'Tanggal Transaksi', 'No. Invoice', 'Nama Pelanggan', 'Status', 'Total Pendapatan (Rp)']);
            
            $no = 1;
            foreach ($orders as $order) {
                fputcsv($file, [
                    $no++,
                    $order->created_at->format('Y-m-d H:i'), 
                    $order->invoice_number, 
                    $order->customer_name, 
                    strtoupper($order->status), 
                    $order->total_price
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    // Fungsi untuk halaman Print PDF
    public function printPdf()
    {
        $orders = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->latest()->get();
        $totalRevenue = $orders->sum('total_price');
        
        return view('owner.reports.print', compact('orders', 'totalRevenue'));
    }
}