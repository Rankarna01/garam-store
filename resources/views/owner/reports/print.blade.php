<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan CV Merisa Jaya</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 40px; }
        .header { text-align: center; border-bottom: 3px solid #253b70; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #253b70; font-size: 26px; text-transform: uppercase;}
        .header p { margin: 5px 0 0; color: #666; font-size: 14px;}
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; color: #253b70; text-transform: uppercase; border-bottom: 2px solid #253b70;}
        .total-row { font-weight: bold; background-color: #e8f7fc; font-size: 15px;}
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* CSS khusus agar rapi saat dicetak ke PDF/Kertas */
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
            @page { margin: 2cm; }
        }
    </style>
</head>
<body onload="window.print()"> 

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #253b70; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN PENDAPATAN - CV MERISA JAYA</h1>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 20%;">Tanggal Transaksi</th>
                <th style="width: 20%;">Nomor Invoice</th>
                <th style="width: 25%;">Nama Pelanggan</th>
                <th class="text-center" style="width: 10%;">Status</th>
                <th class="text-right" style="width: 20%;">Total Transaksi</th>
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
                <td colspan="6" class="text-center">Belum ada data pendapatan.</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN BERSIH</td>
                <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right; width: 100%;">
        <div style="display: inline-block; text-align: center;">
            <p style="margin-bottom: 80px;">Mengetahui,</p>
            <p><strong>{{ auth()->user()->name ?? 'Pemilik / Owner' }}</strong><br>
            <span style="font-size: 12px; color: #666;">Pimpinan CV Merisa Jaya</span></p>
        </div>
    </div>

</body>
</html>