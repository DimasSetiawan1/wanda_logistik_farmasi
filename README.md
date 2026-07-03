# Logistik Farmasi RS Puspa Husada Bekasi

Sistem Informasi Manajemen Logistik Farmasi menggunakan metode **Economic Order Quantity (EOQ)** dan **Min-Max Stock**.

## 📊 Breakdown Perhitungan dan Lokasi File

Semua logika perhitungan utama diletakkan pada layer Service, terpisah dari Controller, agar kode lebih rapi dan dapat digunakan ulang (reusable).

### 1. Perhitungan EOQ (Economic Order Quantity)
**Lokasi File:** `app/Services/EoqCalculationService.php` (pada method `calculate()`)

Perhitungan dilakukan untuk mencari kuantitas pemesanan yang paling optimal dengan biaya persediaan yang paling minimal.

**Variabel yang digunakan:**
- **$D$** = Permintaan per tahun (diambil dari `rata_rata_permintaan` di `EoqParameter`)
- **$S$** = Biaya pemesanan / Ordering cost per pesanan (diambil dari `biaya_pesan`)
- **$H$** = Biaya penyimpanan / Holding cost per unit per tahun (diambil dari `biaya_simpan`). *Catatan: Jika nilai H kosong, maka H dihitung dari $I \times P$ (Faktor biaya simpan $\times$ Harga per unit).*
- **$P$** = Harga beli per unit barang (`harga_per_unit` dari `Medicine`)

**Rumus yang Diimplementasikan:**
1. **EOQ (Kuantitas Pemesanan Optimal)**
   $$EOQ^* = \sqrt{\frac{2 \times D \times S}{H}}$$
   *(Baris kode: `$eoqValue = sqrt((2 * $D * $S) / $H);`)*

2. **Frekuensi Pemesanan (F)**
   $$F = \frac{D}{EOQ^*}$$
   *(Berapa kali pemesanan harus dilakukan dalam satu tahun)*

3. **Total Cost / Biaya Total Persediaan (TC)**
   $$TC = \left(\frac{D}{EOQ^*} \times S\right) + \left(\frac{EOQ^*}{2} \times H\right) + (D \times P)$$
   *(Total dari Biaya Pemesanan + Biaya Penyimpanan + Biaya Pembelian Barang)*

---

### 2. Perhitungan Min-Max Stock
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
   *(Buffer untuk mengantisipasi lonjakan permintaan atau keterlambatan pengiriman selama waktu tunggu)*

2. **Reorder Point (ROP) / Titik Pemesanan Ulang**
   $$ROP = (d \times LT) + SS$$
   *(Titik di mana sistem akan memberikan notifikasi bahwa stok sudah harus dipesan kembali)*

3. **Stok Minimum (Min)**
   $$Min = SS + (d \times LT)$$
   *(Batas paling bawah jumlah stok. Sistem akan menandai status "Perlu Pesan" jika stok aktual $\le$ Min)*

4. **Stok Maksimum (Max)**
   $$Max = Min + EOQ^*$$
   *(Batas paling atas jumlah stok. Sistem akan menandai status "Overstock" jika stok aktual $\ge$ Max)*

---

### 3. Analisis ABC (Evaluasi Persediaan)
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
   - **Kategori A**: Persentase kumulatif 0% s/d 70% (Item sangat penting, butuh kontrol ketat, pesanan EOQ dengan frekuensi lebih sering).
   - **Kategori B**: Persentase kumulatif >70% s/d 90% (Item moderat/sedang).
   - **Kategori C**: Persentase kumulatif >90% s/d 100% (Item kurang penting, volume banyak tapi nilai totalnya kecil).

---

## 📂 Struktur Folder Penting Lainnya

- **Models**: `app/Models/`
  - `Medicine.php`: Data Master Obat
  - `DemandData.php`: Data Historis Permintaan Obat
  - `EoqParameter.php`: Parameter (D, S, H, LT, Z) yang di-input pengguna
  - `EoqCalculation.php`: Menyimpan hasil perhitungan (EOQ*, SS, ROP, Min, Max)
  - `Order.php`: Data pemesanan
- **Controllers**: `app/Http/Controllers/`
  - Controller untuk mengatur alur dari route ke view, memanggil Service saat dibutuhkan perhitungan.
- **Views**: `resources/views/`
  - Menggunakan UI berbasis **Bootstrap 5**.
- **Migrations & Seeders**: `database/migrations/` dan `database/seeders/DatabaseSeeder.php`

---

## 🗄️ Detail Database Schema & Relasi (Untuk Class Diagram)

Berikut adalah rincian tabel, atribut, dan relasi antar tabel (models) pada sistem Logistik Farmasi ini. Struktur ini dapat digunakan sebagai acuan pembuatan Class Diagram atau ERD (Entity Relationship Diagram).

### 1. Tabel `users`
Menyimpan data pengguna aplikasi (Apoteker & Admin).
- **Atribut:**
  - `id` (PK, BigInt)
  - `name` (String)
  - `email` (String, Unique)
  - `password` (String)
  - `role` (Enum: 'admin', 'apoteker')
  - `created_at`, `updated_at` (Timestamp)
- **Relasi:** Tidak memiliki relasi langsung dengan tabel transaksi, murni untuk autentikasi dan otorisasi.

### 2. Tabel `medicines`
Menyimpan data master/katalog obat.
- **Atribut:**
  - `id` (PK, BigInt)
  - `kode_obat` (String, Unique)
  - `nama_obat` (String)
  - `satuan` (String) - *Contoh: Box, Botol, Strip*
  - `kategori` (String)
  - `harga_per_unit` (Decimal)
  - `stok_aktual` (Integer)
  - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
  - `hasMany` ke `demand_data` (Satu obat memiliki banyak data historis permintaan).
  - `hasMany` ke `eoq_parameters` (Satu obat bisa memiliki banyak riwayat input parameter EOQ).
  - `hasMany` ke `eoq_calculations` (Satu obat memiliki banyak riwayat perhitungan EOQ).
  - `hasMany` ke `orders` (Satu obat memiliki banyak riwayat pemesanan).

### 3. Tabel `demand_data`
Menyimpan data riwayat permintaan/pemakaian obat bulanan (digunakan untuk meramalkan/menghitung rata-rata permintaan).
- **Atribut:**
  - `id` (PK, BigInt)
  - `medicine_id` (FK, BigInt) - *Merujuk ke `medicines.id`*
  - `periode` (String) - *Contoh: '2023-01' atau 'Januari 2023'*
  - `jumlah_permintaan` (Integer)
  - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
  - `belongsTo` ke `medicines` (Data permintaan ini milik satu obat tertentu).

### 4. Tabel `eoq_parameters`
Menyimpan variabel/parameter masukan yang dibutuhkan untuk menghitung EOQ dan Min-Max Stock sebuah obat.
- **Atribut:**
  - `id` (PK, BigInt)
  - `medicine_id` (FK, BigInt) - *Merujuk ke `medicines.id`*
  - `rata_rata_permintaan` (Decimal) - *Nilai D (Demand)*
  - `biaya_pesan` (Decimal) - *Nilai S (Ordering Cost)*
  - `biaya_simpan` (Decimal) - *Nilai H (Holding Cost)*
  - `faktor_biaya_simpan` (Decimal) - *Nilai % jika H dihitung dari Harga * Faktor*
  - `lead_time` (Integer) - *Nilai LT (Waktu tunggu dalam hari)*
  - `service_level_z` (Decimal) - *Nilai Z (Contoh 1.65 untuk 95%)*
  - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
  - `belongsTo` ke `medicines`.
  - `hasMany` ke `eoq_calculations` (Satu parameter bisa menghasilkan satu/lebih riwayat kalkulasi).

### 5. Tabel `eoq_calculations`
Menyimpan hasil perhitungan sistem dari metode EOQ dan Min-Max.
- **Atribut:**
  - `id` (PK, BigInt)
  - `medicine_id` (FK, BigInt) - *Merujuk ke `medicines.id`*
  - `eoq_parameter_id` (FK, BigInt) - *Merujuk ke `eoq_parameters.id`*
  - `eoq_value` (Decimal) - *Hasil optimal pemesanan (EOQ)*
  - `frekuensi_pesan` (Decimal) - *Frekuensi pesan dalam setahun (F)*
  - `total_cost` (Decimal) - *Total Biaya Persediaan (TC)*
  - `safety_stock` (Decimal) - *Stok Pengaman (SS)*
  - `reorder_point` (Decimal) - *Titik pemesanan kembali (ROP)*
  - `stok_minimum` (Decimal) - *Batas bawah stok*
  - `stok_maksimum` (Decimal) - *Batas atas stok*
  - `status` (String) - *Indikator saat kalkulasi (Aman / Perlu Pesan / Overstock)*
  - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
  - `belongsTo` ke `medicines`.
  - `belongsTo` ke `eoq_parameters`.

### 6. Tabel `orders`
Menyimpan data riwayat pemesanan obat ke supplier (restock).
- **Atribut:**
  - `id` (PK, BigInt)
  - `medicine_id` (FK, BigInt) - *Merujuk ke `medicines.id`*
  - `tanggal_pesan` (Date)
  - `jumlah_pesan` (Integer)
  - `status` (String) - *Contoh: 'pending', 'selesai'*
  - `keterangan` (Text, Nullable)
  - `created_at`, `updated_at` (Timestamp)
- **Relasi:**
  - `belongsTo` ke `medicines`.
