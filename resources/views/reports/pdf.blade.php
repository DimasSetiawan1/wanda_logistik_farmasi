<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Logistik Farmasi — RS Puspa Husada Bekasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            color: #000;
        }

        body {
            padding: 15mm 10mm;
            background: #fff;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 14pt;
            margin-bottom: 2px;
            font-weight: bold;
        }

        .header h3 {
            font-size: 11pt;
            font-weight: normal;
            color: #222;
        }

        .header p {
            font-size: 8.5pt;
            color: #333;
        }

        .section-title {
            background: transparent;
            color: #000;
            padding: 4px 0;
            margin: 18px 0 8px;
            font-weight: bold;
            font-size: 10pt;
            border-bottom: 1.5px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #666;
            padding: 5px 6px;
            text-align: left;
            background: #fff;
            color: #000;
        }

        th {
            background: #fff;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
            color: #000;
        }

        td {
            font-size: 8pt;
            color: #000;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border: none;
            margin-top: 20px;
        }

        .signature-table td {
            border: none;
            text-align: center;
            padding-top: 60px;
            width: 50%;
            vertical-align: top;
            background: transparent;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 160px;
            margin-bottom: 5px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h2>RS PUSPA HUSADA BEKASI</h2>
        <h3>Laporan Rekomendasi Kuantitas & Batas Stok Persediaan</h3>
        <p>Hasil Perhitungan Pemesanan Optimal dan Kategori Prioritas Persediaan Logistik Farmasi</p>
        <p>Dicetak: {{ $tanggalCetak }}</p>
    </div>

    <!-- Tabel 1: Kuantitas Pemesanan Optimal -->
    <div class="section-title">Tabel 1 — Hasil Perhitungan Kuantitas Pemesanan Optimal</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Obat</th>
                <th class="text-center">Kat</th>
                <th class="text-right">Permintaan</th>
                <th class="text-right">Biaya Pesan (Rp)</th>
                <th class="text-right">Biaya Simpan (Rp)</th>
                <th class="text-right">Kuantitas Optimal</th>
                <th class="text-right">Frekuensi Pesan</th>
                <th class="text-right">Total Biaya (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculations as $i => $calc)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $calc->medicine->kode_obat }}</td>
                    <td>{{ $calc->medicine->nama_obat }}</td>
                    <td class="text-center">{{ $calc->medicine->kategori }}</td>
                    <td class="text-right">{{ number_format($calc->eoqParameter->rata_rata_permintaan, 0) }}</td>
                    <td class="text-right">{{ number_format($calc->eoqParameter->biaya_pesan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($calc->eoqParameter->biaya_simpan, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: bold;">{{ number_format($calc->eoq_value, 0) }}</td>
                    <td class="text-right">{{ number_format($calc->frekuensi_pesan, 1) }}×</td>
                    <td class="text-right">{{ number_format($calc->total_cost, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel 2: Batas Min-Max -->
    <div class="section-title">Tabel 2 — Penetapan Batas Stok Minimum & Maksimum</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th class="text-right">Stok Saat Ini</th>
                <th class="text-right">Stok Pengaman</th>
                <th class="text-right">Titik Pesan Ulang</th>
                <th class="text-right">Stok Min</th>
                <th class="text-right">Stok Max</th>
                <th class="text-center">Status Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculations as $i => $calc)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $calc->medicine->nama_obat }}</td>
                    <td class="text-right">{{ number_format($calc->medicine->stok_aktual) }}</td>
                    <td class="text-right">{{ number_format($calc->safety_stock, 0) }}</td>
                    <td class="text-right">{{ number_format($calc->reorder_point, 0) }}</td>
                    <td class="text-right">{{ number_format($calc->stok_minimum, 0) }}</td>
                    <td class="text-right">{{ number_format($calc->stok_maksimum, 0) }}</td>
                    <td class="text-center">
                        {{ $calc->status === 'perlu_pesan' ? 'Stok Kritis' : ($calc->status === 'overstock' ? 'Stok Berlebih' : 'Stok Aman') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel 3: Prioritas Kategori -->
    @if($abcData->count() > 0)
    <div class="section-title">Tabel 3 — Klasifikasi Prioritas Stok</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th class="text-right">Total Permintaan</th>
                <th class="text-right">Harga/Unit</th>
                <th class="text-right">Nilai Pemakaian</th>
                <th class="text-right">% Kontribusi</th>
                <th class="text-right">Kumulatif</th>
                <th class="text-center">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($abcData as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item['medicine']->nama_obat }}</td>
                    <td class="text-right">{{ number_format($item['total_permintaan']) }}</td>
                    <td class="text-right">{{ number_format($item['harga_per_unit'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item['nilai_pakai'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item['persentase'] }}%</td>
                    <td class="text-right">{{ $item['kumulatif'] }}%</td>
                    <td class="text-center">{{ $item['kategori_abc'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 5px; font-size: 8pt; color: #444;">
        Kategori A: 0-70% (Prioritas Utama) | Kategori B: 70-90% (Prioritas Sedang) | Kategori C: 90-100% (Prioritas Pendukung)
    </p>
    @endif

    <!-- Tanda Tangan -->
    <div class="footer">
        <table class="signature-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    <strong>Kepala Instalasi Farmasi</strong><br><br><br><br>
                    <div class="signature-line"></div><br>
                    NIP. ____________________
                </td>
                <td>
                    Bekasi, {{ $tanggalCetak }}<br>
                    <strong>Penanggung Jawab Logistik</strong><br><br><br><br>
                    <div class="signature-line"></div><br>
                    NIP. ____________________
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
