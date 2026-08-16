<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Helper untuk memfilter data order berdasarkan periode (harian, mingguan, bulanan, custom)
    private function getFilteredData(Request $request)
    {
        $period = $request->get('period', 'all');
        $date = $request->get('date', date('Y-m-d'));
        $month = $request->get('month', date('Y-m'));
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Order::whereIn('status', ['paid', 'processed', 'shipped', 'completed']);
        $periodLabel = 'Semua Waktu';

        if ($period === 'today' || $period === 'daily') {
            $targetDate = $request->filled('date') ? $request->get('date') : date('Y-m-d');
            $query->whereDate('created_at', $targetDate);
            $periodLabel = 'Harian (' . Carbon::parse($targetDate)->translatedFormat('d F Y') . ')';
        } elseif ($period === 'weekly') {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start = Carbon::parse($request->get('start_date'))->startOfDay();
                $end = Carbon::parse($request->get('end_date'))->endOfDay();
            } else {
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
            }
            $query->whereBetween('created_at', [$start, $end]);
            $periodLabel = 'Mingguan (' . $start->translatedFormat('d M Y') . ' - ' . $end->translatedFormat('d M Y') . ')';
        } elseif ($period === 'monthly') {
            $targetMonth = $request->filled('month') ? $request->get('month') : date('Y-m');
            $parsedMonth = Carbon::parse($targetMonth . '-01');
            $query->whereYear('created_at', $parsedMonth->year)
                  ->whereMonth('created_at', $parsedMonth->month);
            $periodLabel = 'Bulanan (' . $parsedMonth->translatedFormat('F Y') . ')';
        } elseif ($period === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
            $periodLabel = 'Periode (' . $start->translatedFormat('d M Y') . ' - ' . $end->translatedFormat('d M Y') . ')';
        }

        $orders = (clone $query)->latest()->get();
        $totalRevenue = $orders->sum('total_price');
        $totalTransactions = $orders->count();
        $cashTransactions = $orders->where('order_type', 'offline')->count();
        $onlineTransactions = $orders->where('order_type', '!=', 'offline')->count();

        // Data untuk grafik
        $salesData = (clone $query)
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();

        return [
            'orders'             => $orders,
            'totalRevenue'       => $totalRevenue,
            'totalTransactions'  => $totalTransactions,
            'cashTransactions'   => $cashTransactions,
            'onlineTransactions' => $onlineTransactions,
            'salesData'          => $salesData,
            'period'             => $period,
            'periodLabel'        => $periodLabel,
            'date'               => $date,
            'month'              => $month,
            'startDate'          => $startDate,
            'endDate'            => $endDate,
        ];
    }

    // Menampilkan halaman utama laporan dengan filter
    public function index(Request $request)
    {
        $data = $this->getFilteredData($request);
        return view('admin.reports.index', $data);
    }

    // Fungsi Cetak Excel (Format CSV Native) sesuai filter yang aktif
    public function exportExcel(Request $request)
    {
        $data = $this->getFilteredData($request);
        $orders = $data['orders'];
        $periodLabel = $data['periodLabel'];
        $cleanLabel = preg_replace('/[^A-Za-z0-9_\-]/', '_', $periodLabel);
        $filename = "Laporan_Penjualan_" . $cleanLabel . "_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use($orders, $periodLabel) {
            $file = fopen('php://output', 'w');
            // Menulis Header Dokumen
            fputcsv($file, ['LAPORAN PENJUALAN - CV MERISA JAYA']);
            fputcsv($file, ['Periode Filter:', $periodLabel]);
            fputcsv($file, ['Tanggal Unduh:', date('d/m/Y H:i:s')]);
            fputcsv($file, []); // baris kosong
            
            // Header Kolom Tabel
            fputcsv($file, ['No', 'Tanggal', 'No. Invoice', 'Nama Pelanggan', 'Metode Bayar', 'Tipe Transaksi', 'Status', 'Total Pendapatan (Rp)']);
            
            $no = 1;
            foreach ($orders as $order) {
                fputcsv($file, [
                    $no++,
                    $order->created_at->format('Y-m-d H:i'), 
                    $order->invoice_number, 
                    $order->customer_name, 
                    strtoupper($order->payment_method ?? 'MIDTRANS'),
                    strtoupper($order->order_type ?? 'ONLINE'),
                    strtoupper($order->status), 
                    $order->total_price
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['', '', '', '', '', '', 'TOTAL PENDAPATAN', $orders->sum('total_price')]);
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    // Fungsi untuk halaman Print PDF sesuai filter yang aktif
    public function printPdf(Request $request)
    {
        $data = $this->getFilteredData($request);
        $orders = $data['orders'];
        $totalRevenue = $data['totalRevenue'];
        $periodLabel = $data['periodLabel'];
        
        return view('admin.reports.print', compact('orders', 'totalRevenue', 'periodLabel'));
    }
}