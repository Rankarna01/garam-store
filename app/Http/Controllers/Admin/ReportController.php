<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Fungsi untuk menampilkan halaman utama laporan (INI YANG BIKIN ERROR TADI KARENA KOSONG)
   public function index()
    {
        $salesData = \App\Models\Order::select(\Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'), \Illuminate\Support\Facades\DB::raw('SUM(total_price) as total'))
                    ->whereIn('status', ['paid', 'processed', 'shipped', 'completed'])
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->take(30)
                    ->get();

        $orders = \App\Models\Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->latest()->get();
        $totalRevenue = $orders->sum('total_price');

        return view('admin.reports.index', compact('salesData', 'orders', 'totalRevenue'));
    }

    // Fungsi Cetak Excel (Format CSV Native)
    public function exportExcel()
    {
        $orders = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed'])->latest()->get();
        $filename = "Laporan_Penjualan_" . date('Y-m-d') . ".csv";
        
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
            fputcsv($file, ['No', 'Tanggal', 'No. Invoice', 'Nama Pelanggan', 'Status', 'Total Pendapatan (Rp)']);
            
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
        
        return view('admin.reports.print', compact('orders', 'totalRevenue'));
    }
}