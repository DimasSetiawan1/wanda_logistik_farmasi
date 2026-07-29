# Logistik Farmasi RS Puspa Husada Bekasi

Sistem Informasi Manajemen Logistik Farmasi RS Puspa Husada Bekasi untuk pengamanan dan optimasi persediaan obat berbasis metode **Economic Order Quantity (EOQ)** dan **Min-Max Stock**.

---

## 🔄 Alur Operasional Logistik Farmasi (Instalasi Farmasi hingga Kepala Instalasi)

Alur proses bisnis berfokus pada **Pencatatan Pemakaian Obat oleh Instalasi Farmasi**, **Kalkulasi Optimasi Persediaan (EOQ, Min-Max, ABC) oleh Admin Logistik**, dan **Peninjauan & Persetujuan Laporan Resmi oleh Kepala Instalasi Farmasi**.

### 1. Diagram Sequence Alur Operasional

```mermaid
sequenceDiagram
    autonumber
    actor IF as Petugas Instalasi Farmasi
    participant SYS as Sistem Logistik Farmasi
    actor ADM as Admin Logistik
    actor KIF as Kepala Instalasi Farmasi

    rect rgb(240, 250, 251)
    note over IF, SYS: Tahap 1: Pencatatan Pemakaian Obat (Instalasi Farmasi)
    IF->>SYS: Input Data Pemakaian Obat (demand_data: Obat, Periode, Jumlah)
    SYS->>SYS: Otomatis Pengurangan Stok (stok_aktual = stok_aktual - Qty)
    SYS-->>IF: Konfirmasi Pemakaian Tersimpan & Stok Berkurang
    end

    rect rgb(248, 250, 252)
    note over ADM, SYS: Tahap 2: Pengelolaan Obat & Kalkulasi Optimasi (Admin)
    ADM->>SYS: Kelola Master Obat & Input Tanggal Kadaluarsa (Expired Date)
    SYS->>SYS: Evaluasi Stok Otomatis (stok_aktual <= stok_minimum ?)
    alt Stok <= Stok Minimum
        SYS->>SYS: Indikator Status Obat = Kritis (Perlu Pesan)
    end
    ADM->>SYS: Input/Update Parameter Optimasi (D, S, H, Lead Time, Service Level)
    SYS->>SYS: Hitung EOQ, Safety Stock, ROP, Min, Max & Klasifikasi ABC
    SYS-->>ADM: Tampilkan Hasil Optimasi & Visualisasi Batas Persediaan
    end

    rect rgb(240, 253, 250)
    note over KIF, SYS: Tahap 3: Peninjauan & Approval Laporan (Kepala Instalasi)
    KIF->>SYS: Akses Monitoring Stok Kritis & Evaluasi Efisiensi
    KIF->>SYS: Peninjauan Prioritas Kategori Persediaan (ABC)
    KIF->>SYS: Cetak / Pengesahan Laporan PDF Logistik Farmasi
    SYS-->>KIF: Laporan Terverifikasi & Disetujui (Rujukan Resmi Pengadaan)
    end
```

---

### 2. Diagram Alir Proses Bisnis (Flowchart Operasional)

```mermaid
graph TD
    A[Start: Login Sistem] --> B{Pilih Role User}

    %% Role Instalasi Farmasi
    B -->|Instalasi Farmasi| C[Akses Menu Data Pemakaian]
    C --> D[Input Transaksi Pemakaian Obat]
    D --> E[Sistem Potong Stok Aktual Otomatis]
    E --> F[Lihat Rekapitulasi Pemakaian]

    %% Role Admin Logistik
    B -->|Admin Logistik| G[Kelola Master Obat & Expired Date]
    G --> H[Input Parameter Optimasi D, S, H, LT, Z]
    H --> I[Sistem Hitung EOQ, SS, ROP, Min, Max & ABC]
    I --> J[Memantau Monitoring Batas Stok Kritis]
    J --> K[Lihat Read-Only Data Permintaan]

    %% Role Kepala Instalasi
    B -->|Kepala Instalasi| L[Akses Dashboard & Monitoring Stok]
    L --> M[Tinjau Evaluasi Efisiensi & Kategori ABC]
    M --> N[Buka Menu Laporan Sistem]
    N --> O[Cetak & Pengesahan Laporan PDF]
    O --> P[End: Pengadaan Obat Disetujui]
```

---

### 3. Rincian Tahapan Alur & Hak Akses Per Role:

#### 🟢 Tahap 1: Pencatatan Pemakaian Obat (`instalasi_farmasi`)

- Petugas **Instalasi Farmasi** masuk ke menu **Data Pemakaian** (`demand-data`).
- Petugas menginputkan transaksi pemakaian obat harian/bulanan (Nama Obat, Periode, dan Jumlah Pemakaian).
- Setiap pemakaian yang disimpan **secara otomatis mengurangi `stok_aktual` obat** pada database.
- Instalasi Farmasi memiliki akses _Read-Only_ pada Katalog Data Obat (tidak bisa menambah, mengedit, atau menghapus master obat).

#### 🔵 Tahap 2: Pengelolaan Obat & Kalkulasi Optimasi (`admin`)

- **Admin Logistik** mengelola data master obat pada menu **Data Obat** (`medicines`), termasuk menginputkan **Tanggal Kadaluarsa (Expired Date)**.
- Admin memasukkan variabel operasional ($D, S, H, Lead Time, Service Level$) pada menu **Parameter Optimasi Stok** (`eoq.index`).
- Sistem secara otomatis menghitung:
    - **Kuantitas Pemesanan Optimal ($EOQ^*$)**
    - **Stok Pengaman ($SS$)**
    - **Titik Pemesanan Ulang ($ROP$)**
    - **Stok Minimum ($Min$) & Stok Maksimum ($Max$)**
    - **Klasifikasi Prioritas Stok ($ABC$)**
- Admin memantau kondisi persediaan pada menu **Monitoring Batas Stok** (`minmax.monitoring`). Apabila `stok_aktual` $\le$ `stok_minimum`, sistem memberikan indikator **Stok Kritis**.
- Admin memiliki akses _Read-Only_ pada menu **Data Permintaan Obat** (tidak bisa menambah, mengedit, atau menghapus data pemakaian).

#### 🟣 Tahap 3: Peninjauan, Evaluasi & Pengesahan Laporan (`kepala_instalasi`)

- **Kepala Instalasi Farmasi** masuk ke sistem untuk meninjau status ketersediaan obat dan daftar item berstatus **Stok Kritis**.
- Kepala Instalasi memeriksa halaman **Evaluasi Efisiensi Stok** (`evaluation.eoq`) dan **Prioritas Kategori Stok** (`evaluation.abc`) untuk memverifikasi penyerapan anggaran persediaan.
- Kepala Instalasi membuka menu **Laporan Sistem** (`reports.index`) dan mengunduh / mencetak **Laporan PDF Output Logistik Farmasi** (`reports.pdf`).
- Kepala Instalasi memberikan **Persetujuan Resmi (Approval)** berupa penandatanganan dokumen Laporan Logistik Farmasi sebagai rujukan pengadaan obat rumah sakit.

---

## 📊 Breakdown Perhitungan dan Lokasi File

Semua logika perhitungan utama diletakkan pada layer Service, terpisah dari Controller, agar kode lebih rapi dan dapat digunakan ulang (reusable).

### 1. Perhitungan Kuantitas Pemesanan Optimal (EOQ)

**Lokasi File:** `app/Services/EoqCalculationService.php` (pada method `calculate()`)

Perhitungan dilakukan untuk mencari kuantitas pemesanan yang paling optimal dengan biaya persediaan yang paling minimal.

**Variabel yang digunakan:**

- **$D$** = Permintaan per tahun (diambil dari `rata_rata_permintaan` di `EoqParameter`)
- **$S$** = Biaya pemesanan / Ordering cost per pesanan (diambil dari `biaya_pesan`)
- **$H$** = Biaya penyimpanan / Holding cost per unit per tahun (diambil dari `biaya_simpan`). _Catatan: Jika nilai H kosong, maka H dihitung dari $I \times P$ (Faktor biaya simpan $\times$ Harga per unit)._
- **$P$** = Harga beli per unit barang (`harga_per_unit` dari `Medicine`)

**Rumus yang Diimplementasikan:**

1. **Kuantitas Pemesanan Optimal**
   $$EOQ^* = \sqrt{\frac{2 \times D \times S}{H}}$$
   _(Baris kode: `$eoqValue = sqrt((2 * $D * $S) / $H);`)_

2. **Frekuensi Pemesanan (F)**
   $$F = \frac{D}{EOQ^*}$$
   _(Berapa kali pemesanan harus dilakukan dalam satu tahun)_

3. **Total Cost / Biaya Total Persediaan (TC)**
   $$TC = \left(\frac{D}{EOQ^*} \times S\right) + \left(\frac{EOQ^*}{2} \times H\right) + (D \times P)$$
   _(Total dari Biaya Pemesanan + Biaya Penyimpanan + Biaya Pembelian Barang)_

---

### 2. Perhitungan Batas Persediaan (Min-Max Stock)

**Lokasi File:** `app/Services/EoqCalculationService.php` (pada method `calculate()`)

Digunakan untuk menentukan batas stok aman, titik pemesanan kembali (Reorder Point), serta batas bawah dan atas stok.

**Variabel tambahan yang digunakan:**

- Hari Kerja = 300 hari per tahun (konstanta `WORKING_DAYS_PER_YEAR`)
- **$d$** = Permintaan rata-rata harian ($d = \frac{D}{300}$)
- **$LT$** = Waktu tunggu / Lead Time dalam hari (diambil dari `lead_time`)
- **$Z$** = Service Level / Tingkat pelayanan (contoh: 1.65 untuk tingkat pelayanan 95%)

**Rumus yang Diimplementasikan:**

1. **Safety Stock (SS) / Stok Pengaman**
   $$SS = Z \times d \times \sqrt{LT}$$
   _(Buffer untuk mengantisipasi lonjakan permintaan atau keterlambatan pengiriman selama waktu tunggu)_

2. **Reorder Point (ROP) / Titik Pemesanan Ulang**
   $$ROP = (d \times LT) + SS$$
   _(Titik di mana sistem akan memberikan notifikasi bahwa stok sudah harus dipesan kembali)_

3. **Stok Minimum (Min)**
   $$Min = SS + (d \times LT)$$
   _(Batas paling bawah jumlah stok. Sistem akan menandai status "Kritis" jika stok aktual $\le$ Min)_

4. **Stok Maksimum (Max)**
   $$Max = Min + EOQ^*$$
   _(Batas paling atas jumlah stok. Sistem akan menandai status "Overstock" jika stok aktual $\ge$ Max)_

---

### 3. Klasifikasi Prioritas Stok (Analisis ABC)

**Lokasi File:** `app/Services/AbcAnalysisService.php` (pada method `analyze()`)

Metode klasifikasi persediaan berdasarkan nilai penyerapan modal atau nilai pemakaian (volume pemakaian $\times$ harga satuan).

**Langkah Perhitungan yang Diimplementasikan:**

1. **Hitung Nilai Pakai per Obat:**
   $$\text{Nilai Pakai} = \text{Total Permintaan Tahunan} \times \text{Harga per Unit}$$
2. **Urutkan (Sorting):** Obat diurutkan secara menurun (descending) berdasarkan Nilai Pakai tertinggi hingga terendah.
3. **Hitung Persentase Kumulatif:**
   $$\text{Persentase} = \left(\frac{\text{Nilai Pakai Obat}}{\text{Total Seluruh Nilai Pakai}}\right) \times 100\%$$
   Kemudian hitung kumulatif atau jumlah beruntun dari persentase tersebut.
4. **Klasifikasi ke dalam Kategori A, B, atau C:**
    - **Kategori A**: Persentase kumulatif 0% s/d 70% (Item sangat penting, butuh kontrol ketat).
    - **Kategori B**: Persentase kumulatif >70% s/d 90% (Item moderat/sedang).
    - **Kategori C**: Persentase kumulatif >90% s/d 100% (Item pendukung).

---

## 📂 Struktur Folder Penting

- **Models**: `app/Models/`
    - `Medicine.php`: Data Master Obat & Tanggal Kadaluarsa
    - `DemandData.php`: Data Historis Pemakaian / Permintaan Obat
    - `EoqParameter.php`: Parameter ($D, S, H, LT, Z$)
    - `EoqCalculation.php`: Menyimpan hasil perhitungan (Kuantitas Optimal, SS, ROP, Min, Max, Status)
    - `User.php`: Pengguna Aplikasi (`admin`, `instalasi_farmasi`, `kepala_instalasi`)
- **Controllers**: `app/Http/Controllers/`
    - Controller mengatur aliran data dari route ke view serta memanggil Service kalkulasi.
- **Views**: `resources/views/`
    - Menggunakan antarmuka responsif modern berbasis **Tailwind CSS**.

---

## 🗄️ Detail Database Schema & Relasi (Strict 5 Tabel Core)

Struktur tabel, atribut, dan relasi pada sistem Logistik Farmasi RS Puspa Husada:

### 1. Tabel `users`

Menyimpan data pengguna aplikasi dengan 3 role terpisah.

- **Atribut:**
    - `id` (PK, BigInt)
    - `name` (String)
    - `username` (String, Unique)
    - `password` (String)
    - `role` (Enum: `'admin'`, `'instalasi_farmasi'`, `'kepala_instalasi'`)
    - `created_at`, `updated_at` (Timestamp)

### 2. Tabel `medicines`

Menyimpan data master/katalog obat.

- **Atribut:**
    - `id` (PK, BigInt)
    - `kode_obat` (String, Unique)
    - `nama_obat` (String)
    - `kategori_obat` (String)
    - `satuan` (String) - _Contoh: Tablet, Botol, Strip, Box_
    - `tingkat_pemakaian` (Enum: `'Sangat Sering'`, `'Sering'`, `'Jarang'`)
    - `harga_per_unit` (Decimal)
    - `stok_aktual` (Integer)
    - `tanggal_kadaluarsa` (Date, Nullable) - _Tanggal kadaluarsa obat (Expired Date)_
    - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
    - `hasMany` ke `demand_data` (Satu obat memiliki banyak riwayat pemakaian/permintaan).
    - `hasMany` ke `eoq_parameters` (Satu obat memiliki riwayat input parameter persediaan).
    - `hasMany` ke `eoq_calculations` (Satu obat memiliki riwayat perhitungan persediaan).

### 3. Tabel `demand_data`

Menyimpan data riwayat pemakaian/permintaan obat bulanan dari Instalasi Farmasi.

- **Atribut:**
    - `id` (PK, BigInt)
    - `medicine_id` (FK, BigInt) - _Merujuk ke `medicines.id`_
    - `periode` (String) - _Contoh: 'Januari 2025'_
    - `jumlah_permintaan` (Integer)
    - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
    - `belongsTo` ke `medicines`.

### 4. Tabel `eoq_parameters`

Menyimpan variabel/parameter masukan yang dibutuhkan untuk menghitung Kuantitas Pemesanan Optimal dan Batas Persediaan.

- **Atribut:**
    - `id` (PK, BigInt)
    - `medicine_id` (FK, BigInt) - _Merujuk ke `medicines.id`_
    - `rata_rata_permintaan` (Decimal) - _Nilai D (Demand)_
    - `biaya_pesan` (Decimal) - _Nilai S (Ordering Cost)_
    - `biaya_simpan` (Decimal) - _Nilai H (Holding Cost)_
    - `faktor_biaya_simpan` (Decimal) - _Nilai % jika H dihitung dari Harga \* Faktor_
    - `lead_time` (Integer) - _Nilai LT (Waktu tunggu dalam hari)_
    - `service_level_z` (Decimal) - _Nilai Z (Contoh 1.65 untuk 95%)_
    - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
    - `belongsTo` ke `medicines`.
    - `hasMany` ke `eoq_calculations`.

### 5. Tabel `eoq_calculations`

Menyimpan hasil perhitungan sistem dari kuantitas optimal dan batas persediaan.

- **Atribut:**
    - `id` (PK, BigInt)
    - `medicine_id` (FK, BigInt) - _Merujuk ke `medicines.id`_
    - `eoq_parameter_id` (FK, BigInt) - _Merujuk ke `eoq_parameters.id`_
    - `eoq_value` (Decimal) - _Hasil optimal pemesanan_
    - `frekuensi_pesan` (Decimal) - _Frekuensi pesan dalam setahun (F)_
    - `total_cost` (Decimal) - _Total Biaya Persediaan (TC)_
    - `safety_stock` (Decimal) - _Stok Pengaman (SS)_
    - `reorder_point` (Decimal) - _Titik pemesanan kembali (ROP)_
    - `stok_minimum` (Decimal) - _Batas bawah stok_
    - `stok_maksimum` (Decimal) - _Batas atas stok_
    - `status` (String) - _Indikator status persediaan (Aman / Kritis / Overstock)_
    - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
    - `belongsTo` ke `medicines`.
    - `belongsTo` ke `eoq_parameters`.
