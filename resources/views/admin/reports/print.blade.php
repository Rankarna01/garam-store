<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Merisa Jaya</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 40px; }
        .header { text-align: center; border-bottom: 2px solid #2face0; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #253b70; font-size: 24px;}
        .header p { margin: 5px 0 0; color: #666; font-size: 14px;}
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f3f4f6; color: #253b70; text-transform: uppercase;}
        .total-row { font-weight: bold; background-color: #e8f7fc; font-size: 14px;}
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* CSS khusus saat dicetak/di-save ke PDF */
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()"> 

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2face0; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            Simpan PDF / Cetak
        </button>
    </div>

    <div class="header">
        <h1>Merisa Jaya - LAPORAN PENJUALAN</h1>
        <p>Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal Transaksi</th>
                <th>Nomor Invoice</th>
                <th>Nama Pelanggan</th>
                <th class="text-center">Status</th>
                <th class="text-right">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->invoice_number }}</td>
                <td>{{ $order->customer_name }}</td>
                <td class="text-center">{{ strtoupper($order->status) }}</td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data penjualan yang sukses.</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN BERSIH</td>
                <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Admin Merisa Jaya</strong></p>
    </div>

</body>
</html>