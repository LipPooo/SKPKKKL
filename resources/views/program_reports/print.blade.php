<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Program - {{ $report->name_of_program }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; padding: 20px; }
        h1 { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .info-table th, .info-table td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .info-table th { background-color: #f9f9f9; width: 30%; }
        .image-container { margin-top: 30px; text-align: center; }
        .image-container img { max-width: 100%; height: auto; border: 1px solid #ddd; }
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

    <h1>Laporan Program: {{ $report->name_of_program }}</h1>

    <table class="info-table">
        <tr>
            <th>Disediakan Oleh</th>
            <td>{{ $report->user->name }} pada {{ $report->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Jenis Program</th>
            <td>{{ ucfirst($report->type) }}</td>
        </tr>
            <tr>
            <th>Person In Charge (PIC)</th>
            <td>
                @if($report->pic_user_id)
                    {{ $report->pic->name }} (No Pekerja: {{ $report->pic->employee_id ?? 'Tiada' }})
                @else
                    Tiada PIC Ditetapkan
                @endif
            </td>
        </tr>
        <tr>
            <th>Tarikh Program</th>
            <td>{{ $report->date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $report->location }}</td>
        </tr>
        <tr>
            <th>Penganjur</th>
            <td>{{ $report->organizer }}</td>
        </tr>
        <tr>
            <th>Bajet</th>
            <td>RM {{ number_format($report->budget, 2) }}</td>
        </tr>
        <tr>
            <th>Penyertaan</th>
            <td>
                Ahli: {{ $report->total_members_involved }}<br>
                Bukan Ahli: {{ $report->total_non_members ?? 0 }}<br>
                Jumlah: {{ $report->total_participation }}
            </td>
        </tr>
        <tr>
            <th>Kolaborasi</th>
            <td>{{ $report->collaboration ?? 'Tiada' }}</td>
        </tr>
        @if($report->vip_details)
        <tr>
            <th>Butiran VIP</th>
            <td>{{ $report->vip_details }}</td>
        </tr>
        @endif
        <tr>
            <th>Butiran (Charge Code/nPOS/Resit)</th>
            <td>{{ $report->payment_details ?? 'Tiada' }}</td>
        </tr>
        @if($report->recognition)
        <tr>
            <th>Pengiktirafan</th>
            <td>{{ $report->recognition }}</td>
        </tr>
        @endif
    </table>

    @if($report->image_proof_path)
    <div class="image-container">
        <h3>Bukti Memorendum Rasmi / Gambar / Agenda / Aturcara / Lampiran</h3>
        <img src="{{ asset('storage/' . $report->image_proof_path) }}" alt="Bukti Gambar">
    </div>
    @endif

    <div style="margin-top: 30px; font-size: 12px; text-align: right; color: #777;">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
