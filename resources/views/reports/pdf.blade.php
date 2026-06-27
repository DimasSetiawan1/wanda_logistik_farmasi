<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan EOQ & Min-Max — RS Puspa Husada Bekasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
        }

        body {
            padding: 15mm 10mm;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 14pt;
            margin-bottom: 2px;
        }

        .header h3 {
            font-size: 11pt;
            font-weight: normal;
            color: #444;
        }

        .header p {
            font-size: 8pt;
            color: #666;
        }

        .section-title {
            background: #2563eb;
            color: #fff;
            padding: 5px 10px;
            margin: 15px 0 8px;
            font-weight: bold;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
        }

        td {
            font-size: 8pt;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            color: #fff;
            font-size: 7pt;
            font-weight: bold;
        }

        .badge-a { background: #dc2626; }
        .badge-b { background: #d97706; }
        .badge-c { background: #059669; }
        .badge-normal { background: #059669; }
        .badge-perlu_pesan { background: #dc2626; }
        .badge-overstock { background: #d97706; }

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
            width: 33%;
            vertical-align: top;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            display: inline-block;
            width: 150px;
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
        <h3>Laporan Rekomendasi EOQ & Batas Min-Max Stock</h3>
        <p>Implementasi Economic Order Quantity dan Min-Max Stock dalam Manajemen Logistik Farmasi</p>
        <p>Dicetak: {{ $tanggalCetak }}</p>
    </div>

    <!-- Tabel 1: Hasil Perhitungan EOQ -->
    <div class="section-title">Tabel 1 — Hasil Perhitungan EOQ (Economic Order Quantity)</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Obat</th>
                <th class="text-center">Kat</th>
                <th class="text-right">D</th>
                <th class="text-right">S (Rp)</th>
                <th class="text-right">H (Rp)</th>
                <th class="text-right">EOQ*</th>
                <th class="text-right">F</th>
                <th class="text-right">TC (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculations as $i => $calc)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $calc->medicine->kode_obat }}</td>
                    <td>{{ $calc->medicine->nama_obat }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ strtolower($calc->medicine->kategori) }}">{{ $calc->medicine->kategori }}</span>
                    </td>
                    <td class="text-right">{{ number_format($calc->eoqParameter->rata_rata_permintaan, 0) }}</td>
                    <td class="text-right">{{ number_format($calc->eoqParameter->biaya_pesan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($calc->eoqParameter->biaya_simpan, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: bold;">{{ number_format($calc->eoq_value, 0) }}</td>
                    <td class="text-right">{{ number_format($calc->frekuensi_pesan, 1) }}</td>
                    <td class="text-right">{{ number_format($calc->total_cost, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel 2: Batas Min-Max -->
    <div class="section-title">Tabel 2 — Penetapan Batas Stok Min-Max</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th class="text-right">Stok Aktual</th>
                <th class="text-right">Safety Stock</th>
                <th class="text-right">ROP</th>
                <th class="text-right">Stok Min</th>
                <th class="text-right">Stok Max</th>
                <th class="text-center">Status</th>
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
                        <span class="badge badge-{{ $calc->status }}">
                            {{ $calc->status === 'perlu_pesan' ? 'Perlu Pesan' : ($calc->status === 'overstock' ? 'Overstock' : 'Normal') }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel 3: Analisis ABC -->
    @if($abcData->count() > 0)
    <div class="section-title">Tabel 3 — Analisis ABC</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th class="text-right">Total Permintaan</th>
                <th class="text-right">Harga/Unit</th>
                <th class="text-right">Nilai Pakai</th>
                <th class="text-right">%</th>
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
                    <td class="text-center">
                        <span class="badge badge-{{ strtolower($item['kategori_abc']) }}">{{ $item['kategori_abc'] }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 5px; font-size: 8pt; color: #666;">
        Kategori A: 0-70% (High Value) | Kategori B: 70-90% (Medium Value) | Kategori C: 90-100% (Low Value)
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
                    <strong>Penanggung Jawab</strong><br><br><br><br>
                    <div class="signature-line"></div><br>
                    NIP. ____________________
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
