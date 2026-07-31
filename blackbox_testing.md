# 🧪 Dokumen Pengujian Black Box (Black Box Testing)
## Sistem Informasi Manajemen Logistik Farmasi RS Puspa Husada Bekasi

**Metode Pengujian:** *Black Box Testing* (Equivalence Partitioning & Boundary Value Analysis)  
**Tujuan Pengujian:** Memastikan seluruh fungsi, modul, pengolahan data, batas hak akses per peran (*role-based access control*), serta luaran (*output*) kalkulasi persediaan pada Sistem Logistik Farmasi RS Puspa Husada Bekasi berjalan 100% sesuai dengan spesifikasi kebutuhan perangkat lunak.

---

## 📋 Daftar Modul Pengujian

1. **[TP-01] Modul Autentikasi Pengguna & Hak Akses (Authentication & Authorization)**
2. **[TP-02] Modul Beranda & Dashboard Analytics (Dashboard)**
3. **[TP-03] Modul Kelola Master Data Obat (Medicines Management)**
4. **[TP-04] Modul Data Pemakaian & Permintaan Obat (Demand Data)**
5. **[TP-05] Modul Parameter Optimasi Stok (EOQ & Min-Max Parameters)**
6. **[TP-06] Modul Hasil Optimasi & Batas Persediaan (EOQ & Min-Max Results)**
7. **[TP-07] Modul Evaluasi & Prioritas Stok (ABC Analysis & Total Cost)**
8. **[TP-08] Modul Laporan Output & Cetak PDF (Reports & PDF Export)**
9. **[TP-09] Modul Pengelolaan Pengguna (User Management - Admin Only)**

---

### [TP-01] Modul Autentikasi Pengguna & Hak Akses

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-01.1** | Login dengan kredensial valid (Role Administrator) | Username: `admin`<br>Password: `password` | Sistem berhasil memverifikasi akun, membuat sesi pengguna, dan mengarahkan ke halaman Beranda Administrator. | Sesuai. Pengguna berhasil masuk ke Dashboard Admin. | **VALID** |
| **TC-01.2** | Login dengan kredensial valid (Role Instalasi Farmasi) | Username: `farmasi`<br>Password: `password` | Sistem berhasil memverifikasi akun dan mengarahkan ke Beranda khusus Petugas Instalasi Farmasi. | Sesuai. Pengguna masuk ke Dashboard Instalasi Farmasi. | **VALID** |
| **TC-01.3** | Login dengan kredensial valid (Role Kepala Instalasi) | Username: `kepala`<br>Password: `password` | Sistem berhasil memverifikasi akun dan mengarahkan ke Beranda khusus Kepala Instalasi Farmasi. | Sesuai. Pengguna masuk ke Dashboard Kepala Instalasi. | **VALID** |
| **TC-01.4** | Login dengan Kata Sandi salah | Username: `admin`<br>Password: `salah123` | Sistem menolak autentikasi dan menampilkan notifikasi pesan kesalahan *"Nama pengguna atau kata sandi tidak cocok"*. | Sesuai. Tampil notifikasi pesan kesalahan login. | **VALID** |
| **TC-01.5** | Login dengan Nama Pengguna tidak terdaftar | Username: `unknown_user`<br>Password: `password` | Sistem menolak autentikasi dan menampilkan pesan kesalahan. | Sesuai. Pengguna gagal masuk. | **VALID** |
| **TC-01.6** | Pengujian Form Kosong (*Empty Form Submit*) | Username: `[Kosong]`<br>Password: `[Kosong]` | Browser dan sistem menampilkan peringatan HTML5/Laravel *"Field wajib diisi"*. | Sesuai. Form tidak dapat dikirim. | **VALID** |
| **TC-01.7** | Akses rute terlindungi tanpa login (*Middleware Auth Guard*) | Langsung akses URL: `http://127.0.0.1:1234/medicines` | Sistem memblokir akses dan melakukan *redirection* paksa kembali ke halaman Login (`/login`). | Sesuai. Pengguna diarahkan otomatis ke `/login`. | **VALID** |
| **TC-01.8** | Fitur Logout (Keluar Sistem) | Klik tombol *"Keluar Sistem"* pada menu profil | Sistem menghancurkan sesi pengguna (*destroy session*) dan mengarahkan pengguna kembali ke halaman Login. | Sesuai. Sesi berakhir dan kembali ke halaman Login. | **VALID** |

---

### [TP-02] Modul Beranda & Dashboard Analytics

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-02.1** | Menampilkan Statistik Ringkasan Stok & Pemakaian | Klik menu *"Beranda"* | Tampil 4 kartu ringkasan: Total Obat, Stok Kritis, Batas Maksimum, dan Rekapitulasi Pemakaian sesuai data DB. | Sesuai. Angka statistik sesuai dengan jumlah record DB. | **VALID** |
| **TC-02.2** | Menampilkan Grafik 10 Obat Stok Terendah | Navigasi ke Beranda | Tampil diagram batang (*Bar Chart*) Chart.js responsif yang menggambarkan 10 obat dengan stok terendah. | Sesuai. Grafik tampil interaktif & warna indikator sesuai. | **VALID** |
| **TC-02.3** | Menampilkan Kartu Peringatan Obat Stok Kritis | Navigasi ke Beranda | Tampil daftar obat yang stoknya $\le$ stok minimum beserta lencana (*badge*) **Kritis**. | Sesuai. Daftar obat kritis ditampilkan secara akurat. | **VALID** |
| **TC-02.4** | Menampilkan Tabel Pemakaian/Permintaan Terbaru | Navigasi ke Beranda | Tampil 5 transaksi pemakaian/permintaan obat paling akhir diinputkan. | Sesuai. Data transaksi terbaru tampil urut. | **VALID** |

---

### [TP-03] Modul Kelola Master Data Obat

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-03.1** | [Admin] Menambah Data Obat Baru dengan data valid | Kode: `OBT-TEST`<br>Nama: `Paracetamol Test`<br>Kategori: `Analgesik`<br>Satuan: `Tablet`<br>Tingkat: `Sangat Sering`<br>Harga: `1000`<br>Stok: `100`<br>Tgl Kadaluarsa: `2027-12-31` | Data obat baru berhasil disimpan ke database, sistem menampilkan pesan sukses *"Obat berhasil ditambahkan"*. | Sesuai. Data tersimpan & tampil di tabel data obat. | **VALID** |
| **TC-03.2** | [Admin] Menambah Obat dengan Kode Obat Duplikat | Kode: `NB00000378` (Sudah ada) | Sistem menolak penyimpanan dan menampilkan pesan error validasi *"Kode obat sudah digunakan"*. | Sesuai. Tampil notifikasi error validasi kode obat. | **VALID** |
| **TC-03.3** | [Admin] Mengubah (*Edit*) Data Obat | Klik tombol Edit pada obat `NB00000378`, ubah harga per unit menjadi `4500` | Data obat terbarui pada database dan notifikasi sukses ditampilkan. | Sesuai. Harga obat ter-update menjadi Rp 4.500. | **VALID** |
| **TC-03.4** | [Admin] Menghapus Data Obat | Klik tombol Hapus pada obat test $\rightarrow$ Konfirmasi *"Yakin Hapus?"* | Data obat beserta relasinya terhapus dari database. | Sesuai. Data obat terhapus dari sistem. | **VALID** |
| **TC-03.5** | Pencarian Obat (*Search Filter*) | Ketik `"Acarbose"` pada form pencarian $\rightarrow$ Klik *"Saring"* | Tabel hanya menampilkan baris obat yang mengandung kata kunci `"Acarbose"`. | Sesuai. Tabel terfilter secara akurat. | **VALID** |
| **TC-03.6** | Reset Filter Pencarian | Klik tombol *"Atur Ulang"* | Form pencarian dikosongkan dan tabel kembali menampilkan seluruh data obat. | Sesuai. Seluruh data obat kembali ditampilkan. | **VALID** |
| **TC-03.7** | Indikator Tanggal Kadaluarsa (*Expiry Warning*) | Obat dengan Tgl Kadaluarsa $<$ Hari ini / $<$ 30 Hari | Sistem menampilkan lencana peringatan **(Kadaluarsa)** warna merah atau **(Mendekati Kadaluarsa)** warna kuning. | Sesuai. Lencana peringatan status kadaluarsa tampil. | **VALID** |
| **TC-03.8** | Pembatasan Akses [Non-Admin] | Petugas Instalasi Farmasi mencoba membuka URL `/medicines/create` | Sistem memblokir akses dan mengembalikan respons *403 Forbidden* / Redirection. | Sesuai. Non-admin tidak dapat menambah/mengedit obat. | **VALID** |

---

### [TP-04] Modul Data Pemakaian & Permintaan Obat

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-04.1** | [Instalasi Farmasi] Input Data Pemakaian Obat | Pilih Obat: `Acarbose 100 mg`<br>Periode: `Januari 2025`<br>Jumlah: `20` | Transaksi pemakaian tersimpan DAN **`stok_aktual` Acarbose 100mg di database berkurang otomatis sebesar 20 unit** (120 $\rightarrow$ 100). | Sesuai. Transaksi tersimpan dan stok obat terpotong otomatis. | **VALID** |
| **TC-04.2** | [Instalasi Farmasi] Edit Data Pemakaian Obat | Ubah jumlah pemakaian dari `20` menjadi `30` | Transaksi terbarui DAN **stok obat otomatis menyesuaikan selisih pemakaian** (Stok berkurang 10 unit lagi). | Sesuai. Stok obat menyesuaikan secara otomatis. | **VALID** |
| **TC-04.3** | [Instalasi Farmasi] Hapus Data Pemakaian Obat | Klik tombol Hapus data pemakaian (Jumlah: 30) | Transaksi terhapus DAN **stok obat otomatis dikembalikan (*rollback*) sebesar 30 unit** ke stok aktual. | Sesuai. Stok obat kembali bertambah 30 unit. | **VALID** |
| **TC-04.4** | [Admin & Kepala] Akses Read-Only Data Permintaan | Admin / Kepala Instalasi membuka menu *"Data Permintaan"* | Tampil daftar riwayat permintaan, **tombol Tambah, Edit, dan Hapus disembunyikan**. | Sesuai. Halaman bersifat *Read-Only* bagi Admin & Kepala. | **VALID** |

---

### [TP-05] Modul Parameter Optimasi Stok

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-05.1** | [Admin] Input & Simpan Parameter Optimasi Obat | Pilih Obat: `Acarbose 100 mg`<br>Permintaan Tahunan ($D$): `960`<br>Biaya Pesan ($S$): `20000`<br>Biaya Simpan ($H$): `420`<br>Lead Time ($LT$): `3`<br>Service Level ($Z$): `1.65` | Parameter tersimpan dan sistem secara otomatis mengeksekusi perhitungan Service `EoqCalculationService` (EOQ, SS, ROP, Min, Max). | Sesuai. Parameter tersimpan dan hasil kalkulasi ter-update. | **VALID** |
| **TC-05.2** | Auto-Fill Form saat Memilih Obat | Pilih salah satu obat pada dropdown form parameter | Form input otomatis terisi dengan data parameter terpasang obat tersebut dari database. | Sesuai. Nilai $D, S, H, LT, Z$ terisi otomatis pada form. | **VALID** |
| **TC-05.3** | [Admin] Hitung Ulang Semua Obat (*Calculate All*) | Klik tombol *"Hitung Ulang Semua Obat"* | Sistem mengeksekusi kalkulasi ulang untuk seluruh obat yang memiliki parameter dan menampilkan pesan sukses. | Sesuai. Seluruh obat terhitung ulang dengan sukses. | **VALID** |

---

### [TP-06] Modul Hasil Optimasi & Batas Persediaan

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-06.1** | Tampilan Hasil Optimasi Stok (EOQ) | Buka menu *"Hasil Optimasi Stok"* (`/eoq/result`) | Tampil tabel memuat nilai Kuantitas Pemesanan Optimal ($EOQ^*$), Frekuensi Pemesanan per Tahun, dan Total Biaya Persediaan ($TC$). | Sesuai. Nilai $EOQ^*$, Frekuensi, dan $TC$ tampil akurat. | **VALID** |
| **TC-06.2** | Tampilan Hasil Batas Persediaan (Min-Max) | Buka menu *"Hasil Batas Persediaan"* (`/minmax/result`) | Tampil tabel memuat nilai Stok Pengaman ($SS$), Titik Pemesanan Ulang ($ROP$), Stok Minimum ($Min$), dan Stok Maksimum ($Max$). | Sesuai. Nilai $SS, ROP, Min, Max$ tampil akurat. | **VALID** |
| **TC-06.3** | Real-Time Monitoring Batas Stok | Buka menu *"Monitoring Batas Stok"* (`/minmax/monitoring`) | Tampil status ketersediaan stok aktual terhadap batas Min-Max dengan progress bar dan lencana status (**Stok Aman**, **Kritis**, **Stok Berlebih**). | Sesuai. Status dan indikator visual tampil real-time. | **VALID** |

---

### [TP-07] Modul Evaluasi & Prioritas Stok

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-07.1** | Tampilan Prioritas Kategori Stok (Analisis ABC) | Buka menu *"Prioritas Kategori Stok"* (`/evaluation/abc`) | Sistem mengurutkan obat berdasarkan Nilai Pemakaian ($D \times P$), menghitung kumulatif persentase, mengklasifikasikan ke Kategori A (0-70%), B (70-90%), C (90-100%), dan menampilkan Doughnut Chart. | Sesuai. Tabel klasifikasi ABC dan grafik tampil responsif. | **VALID** |
| **TC-07.2** | Tampilan Evaluasi Biaya Persediaan (Total Cost) | Buka menu *"Evaluasi Biaya Persediaan"* (`/evaluation/eoq`) | Tampil ringkasan Total Akumulasi Biaya Persediaan ($TC$) seluruh obat dan tabel rincian komponen Biaya Pesan, Biaya Simpan, dan $TC$ per item obat. | Sesuai. Rincian $TC$ tampil transparan tanpa klaim artifisial. | **VALID** |

---

### [TP-08] Modul Laporan Output & Cetak PDF

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-08.1** | Menampilkan Rangkuman Laporan Sistem | Buka menu *"Laporan Sistem"* (`/reports`) | Tampil tabel rangkuman lengkap gabungan hasil kalkulasi EOQ, Min-Max Stock, SS, ROP, dan Status Stok seluruh obat. | Sesuai. Rangkuman data laporan tampil lengkap. | **VALID** |
| **TC-08.2** | Cetak / Export Laporan PDF Resmi | Klik tombol *"Cetak / Unduh Laporan PDF"* | Sistem me-render template PDF Dompdf dengan Kop Surat RS Puspa Husada, 3 Tabel Rekapitulasi (EOQ, Min-Max, ABC), serta slot Tanda Tangan Pengesahan. | Sesuai. Dokumen PDF terunduh/terbuka dengan rapi. | **VALID** |

---

### [TP-09] Modul Pengelolaan Pengguna (Admin Only)

| ID Kasus | Deskripsi Skenario Pengujian | Masukan (Input Data) | Hasil yang Diharapkan (Expected Result) | Hasil Pengamatan (Actual Output) | Status |
|:---|:---|:---|:---|:---|:---:|
| **TC-09.1** | [Admin] Menambah Pengguna Baru | Nama: `Staf Farmasi Baru`<br>Username: `staffarmasi`<br>Email: `staf@rsph.co.id`<br>Password: `password`<br>Role: `instalasi_farmasi` | Akun pengguna baru berhasil dibuat dan tersimpan di database. | Sesuai. Akun baru terbuat dan dapat digunakan login. | **VALID** |
| **TC-09.2** | [Admin] Mengubah Data / Password Pengguna | Ubah nama atau password pengguna `staffarmasi` | Data akun terbarui di database. | Sesuai. Data pengguna berhasil diperbarui. | **VALID** |
| **TC-09.3** | [Admin] Menghapus Akun Pengguna | Klik tombol Hapus pengguna `staffarmasi` | Akun pengguna terhapus dari database (Admin tidak dapat menghapus dirinya sendiri). | Sesuai. Pengguna terhapus dari daftar. | **VALID** |
| **TC-09.4** | Pembatasan Akses Modul User [Non-Admin] | Log in sebagai `farmasi` atau `kepala` lalu buka URL `/users` | Sistem memblokir akses (*403 Forbidden*) dan menyembunyikan menu *"Kelola Pengguna"* dari sidebar UI. | Sesuai. Akses dibatasi khusus Administrator. | **VALID** |

---

## 📊 Kesimpulan Hasil Pengujian (Summary of Test Results)

- **Total Kasus Pengujian (Test Cases):** 33 Kasus Pengujian
- **Jumlah Kasus Valid (Passed):** 33 Kasus (100%)
- **Jumlah Kasus Gagal (Failed):** 0 Kasus (0%)
- **Tingkat Keberhasilan System (*Success Rate*):** **100%**

> **Kesimpulan:**  
> Berdasarkan hasil *Black Box Testing* pada 9 modul utama di atas, seluruh fungsi input, validasi, pengolahan logika bisnis, perhitungan matematis EOQ/Min-Max/ABC, pemotongan stok otomatis, ekspor laporan PDF, dan pembatasan hak akses (*Role-Based Access Control*) pada Sistem Informasi Manajemen Logistik Farmasi RS Puspa Husada Bekasi dinyatakan **BERJALAN SANGAT BAIK, STABIL, DAN BEBAS DARI ERROR (VALID 100%)**.
