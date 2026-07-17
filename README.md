# Smart Catalog

## Summary

Smart Catalog merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan data produk, persediaan barang, serta transaksi penjualan dan barang masuk. Sistem juga menyediakan dashboard analitik, laporan transaksi, dan rekomendasi berbasis data untuk membantu pengambilan keputusan dalam pengelolaan inventori.


## Technology Stack

### Backend
- PHP 8.3
- Laravel 13

### Frontend
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- jQuery
- Chart.js

### Database
- MySQL

### Additional Libraries
- Laravel Breeze (Authentication)
- Maatwebsite Laravel Excel (Export Excel)
- Spatie Laravel PDF (Export PDF)
- Browsershot (PDF Rendering)


## Main Features

- Authentication (Login)
- Dashboard
- Category Management
- Product Management
- Stock In Transaction
- Sales Transaction
- Product Report
- Sales Report
- Stock In Report
- Export Report (Excel & PDF)
- System Insight
- Recommendation by System


## Application Flow

1. User melakukan login ke dalam sistem.
2. User mengelola data kategori sebagai dasar pengelompokan produk.
3. User menambahkan dan mengelola data produk beserta informasi harga, stok, minimum stok, maksimum stok, dan satuan.
4. User melakukan transaksi **Stock In** untuk menambah persediaan barang.
5. User melakukan transaksi **Sales** untuk mencatat penjualan dan mengurangi stok secara otomatis.
6. Sistem memperbarui stok produk berdasarkan setiap transaksi yang terjadi.
7. Dashboard menampilkan ringkasan data, grafik, informasi produk terlaris, kondisi stok kritis, serta rekomendasi berdasarkan hasil analisis sistem.
8. User dapat melihat laporan Product, Sales, dan Stock In, kemudian mengekspor laporan ke dalam format Excel maupun PDF.


## System Insight

Dashboard menyediakan informasi analitis yang membantu pengguna dalam memantau kondisi inventori, antara lain:

- Top Selling Product
- Critical Stock


## Recommendation by System

Sistem menghasilkan rekomendasi berdasarkan hasil analisis data transaksi, meliputi:

- Increase Stock Recommendation
- Restock Recommendation


## Technical Information

- Arsitektur menggunakan pola MVC (Model-View-Controller).
- Eloquent ORM digunakan sebagai media interaksi dengan database.
- Sistem menggunakan Middleware Authentication untuk membatasi akses pengguna.
- Export laporan mendukung format Microsoft Excel (.xlsx) dan PDF.
- Dashboard memanfaatkan Chart.js untuk visualisasi data.


## Non-Technical Information

Aplikasi Smart Catalog dikembangkan sebagai sistem pendukung pengelolaan inventori yang bertujuan membantu pengguna dalam memonitor stok barang, mencatat transaksi, serta memperoleh informasi dan rekomendasi berbasis data. Dengan adanya dashboard dan fitur pelaporan, proses pengambilan keputusan dapat dilakukan secara lebih cepat, terstruktur, dan efisien.