<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk / Invoice {{ $order->invoice_number }} - CV Merisa Jaya</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Courier New', Courier, monospace, sans-serif; font-size: 13px; color: #111; background: #f3f4f6; padding: 20px; }
        .invoice-card { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px dashed #bbb; padding-bottom: 15px; margin-bottom: 15px; }
        .header h1 { font-size: 20px; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; }
        .header p { font-size: 11px; color: #555; }
        .info-table { width: 100%; margin-bottom: 15px; font-size: 12px; }
        .info-table td { padding: 3px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 12px; }
        .items-table th { border-top: 1px dashed #bbb; border-bottom: 1px dashed #bbb; padding: 8px 4px; text-align: left; }
        .items-table td { padding: 8px 4px; border-bottom: 1px dotted #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-section { border-top: 2px dashed #bbb; padding-top: 10px; margin-bottom: 20px; }
        .total-row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 14px; font-weight: bold; }
        .footer { text-align: center; font-size: 11px; color: #666; border-top: 1px dashed #bbb; padding-top: 15px; margin-top: 15px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; background: #e5e7eb; }
        
        .no-print { text-align: center; margin-bottom: 20px; }
        .btn-print { background: #2face0; color: #fff; border: none; padding: 10px 24px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; }
        .btn-back { background: #6b7280; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; margin-right: 8px; display: inline-block; }

        @media print {
            body { background: #fff; padding: 0; }
            .invoice-card { box-shadow: none; padding: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-back">Kembali</a>
        <button onclick="window.print()" class="btn-print">🖨️ Cetak Struk / Invoice</button>
    </div>

    <div class="invoice-card">
        <div class="header">
            <h1>CV MERISA JAYA</h1>
            <p>Produsen & Distributor Garam Berkualitas</p>
            <p>Telp: 0838-7476-7450 | Lampung, Indonesia</p>
        </div>

        <table class="info-table">
            <tr>
                <td style="width: 50%;"><strong>No. Invoice:</strong> {{ $order->invoice_number }}</td>
                <td style="width: 50%; text-align: right;"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Pelanggan:</strong> {{ $order->customer_name }}</td>
                <td style="text-align: right;"><strong>Metode:</strong> {{ strtoupper($order->payment_method ?? 'CASH') }} ({{ strtoupper($order->order_type ?? 'OFFLINE') }})</td>
            </tr>
            @if($order->customer_phone && $order->customer_phone !== '-')
            <tr>
                <td><strong>No. HP:</strong> {{ $order->customer_phone }}</td>
                <td style="text-align: right;"><strong>Status:</strong> {{ strtoupper($order->status) }}</td>
            </tr>
            @endif
            @if($order->notes)
            <tr>
                <td colspan="2"><strong>Catatan:</strong> {{ $order->notes }}</td>
            </tr>
            @endif
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>TOTAL PEMBAYARAN:</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih atas kunjungan dan pembelian Anda!</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar kecuali ada perjanjian.</p>
        </div>
    </div>

</body>
</html>
