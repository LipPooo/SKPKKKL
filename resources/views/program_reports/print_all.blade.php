<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Ringkasan Laporan Program - SKPKKKL</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; padding: 20px; }
        h1 { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .summary-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .summary-table th, .summary-table td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .summary-table th { background-color: #f9f9f9; font-size: 14px; }
        .summary-table td { font-size: 13px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <h1>Ringkasan Laporan Program</h1>

    <table class="summary-table">
        <thead>
            <tr>
                <th>Bil.</th>
                <th>Nama Program</th>
                <th>PIC</th>
                <th>Tarikh</th>
                <th>Lokasi</th>
                <th>Jenis</th>
                <th>Bajet (RM)</th>
                <th>Butiran Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $report->name_of_program }}</td>
                <td>
                    @if($report->pic_user_id)
                        {{ $report->pic->name }}<br><small>({{ $report->pic->employee_id ?? 'Tiada No' }})</small>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $report->date->format('d/m/Y') }}</td>
                <td>{{ $report->location }}</td>
                <td>{{ ucfirst($report->type) }}</td>
                <td>{{ number_format($report->budget, 2) }}</td>
                
                <td>{{ $report->payment_details ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 12px; text-align: right; color: #777;">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
