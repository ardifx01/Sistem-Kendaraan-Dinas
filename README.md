# Sistem Kendaraan Dinas — Panduan Setup & Menjalankan Lokal

Panduan ini menjelaskan cara membuat dan menjalankan proyek Laravel ini dari awal (clone, instal dependensi, konfigurasi environment, migrasi, seed, build aset, dan menjalankan server) pada mesin pengembangan (Windows PowerShell contoh).

## Prasyarat

-   PHP >= 8.0 (disarankan 8.1+), extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD/imagick (untuk image ops)
-   Composer (https://getcomposer.org)
-   Node.js (16+) dan npm/yarn
-   SQLite (opsional) atau MySQL/Postgres
-   Git

Jika menggunakan Windows, jalankan perintah di PowerShell. Contoh perintah ada di bawah dengan sintaks PowerShell.

---

## 1) Membuat proyek dari awal (opsional)

Jika Anda ingin membuat proyek baru Laravel dari awal (tidak perlu jika sudah meng-clone repositori):

```powershell
composer create-project laravel/laravel nama-proyek
cd nama-proyek
```

Jika Anda sudah meng-clone repo ini, lompat ke bagian berikutnya.

---

## 2) Clone repository

```powershell
git clone <repo-url> kendaraan-dinas-app
cd kendaraan-dinas-app
```

---

## 3) Install dependensi PHP (Composer)

```powershell
composer install --no-interaction --prefer-dist
```

Jika Anda memakai Windows dan menemui masalah ekstensi, pastikan PHP CLI yang dipakai sesuai (php -v).

---

## 4) Salin file environment dan generate app key

```powershell
copy .env.example .env
php artisan key:generate
```

Edit file `.env` sesuai kebutuhan (database, mail, storage, dsb). Contoh pengaturan database:

-   Untuk SQLite (cepat untuk development):

1. Buat file database:

```powershell
mkdir database; type nul > database\database.sqlite
```

2. Di `.env` set:

```env
DB_CONNECTION=sqlite
DB_DATABASE=${PWD}\\database\\database.sqlite
```

-   Untuk MySQL, ubah di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=secret
```

Setelah mengubah `.env`, jalankan `php artisan config:clear` bila perlu.

---

## 5) Install dependensi front-end (Node / npm)

```powershell
npm install
# atau menggunakan yarn
# yarn install
```

Proyek ini menggunakan Vite untuk build frontend. Untuk development jalankan:

```powershell
npm run dev
```

Untuk build produksi:

```powershell
npm run build
```

---

## 6) Migrasi database & seeder

Jalankan migrasi dan seeder untuk membuat tabel dan data contoh (jika tersedia):

```powershell
php artisan migrate
php artisan db:seed
```

Jika Anda ingin menjalankan migrasi fresh (menghapus semua tabel lalu migrate + seed):

```powershell
php artisan migrate:fresh --seed
```

---

## 7) Storage link

Jika aplikasi menyimpan file (upload foto, file publik), jalankan:

```powershell
php artisan storage:link
```

---

## 8) Menjalankan server development

Untuk menjalankan server lokal (untuk testing cepat):

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Buka browser pada http://127.0.0.1:8000

Jika Anda sedang menjalankan `npm run dev` (Vite), biasanya URL akan meng-serve aset dari Vite HMR; pastikan kedua proses berjalan (Vite & Artisan) di dua terminal terpisah.

---

## 9) Perintah berguna lainnya

-   Clear cache config/view/routes: `php artisan config:clear; php artisan cache:clear; php artisan view:clear;`
-   Queue worker: `php artisan queue:work`
-   Menjalankan test: `php artisan test` atau `vendor/bin/phpunit`

---

## 10) Troubleshooting singkat

-   Jika composer install bermasalah: pastikan ekstensi PHP terinstall dan versi PHP CLI cocok.
-   Jika node/npm error: update Node ke versi LTS (16+) atau gunakan nvm untuk mengelola versi.
-   Permission/storage: pada Windows jangan lupa jalankan terminal dengan hak akses yang sesuai jika perlu.

---

## Dependensi utama (ringkasan)

Berikut paket utama yang digunakan proyek ini (diambil dari `composer.json` dan `package.json`).

-   PHP / Composer (production)

    -   `laravel/framework` ^12.0
    -   `barryvdh/laravel-dompdf` ^3.1 (DomPDF wrapper untuk generate PDF)
    -   `laravel/tinker`

-   PHP / Composer (development)

    -   `fakerphp/faker`, `laravel/pail`, `laravel/pint`, `laravel/sail`, `mockery/mockery`, `nunomaduro/collision`, `phpunit/phpunit`

-   JavaScript / frontend (devDependencies)
    -   `vite`, `laravel-vite-plugin`
    -   `tailwindcss`, `@tailwindcss/forms`, `@tailwindcss/typography`
    -   `postcss`, `autoprefixer`
    -   `axios`
    -   `concurrently`

Jika Anda ingin daftar lengkap versi, buka `composer.json` dan `package.json` di root repo.

---

## Menggunakan DomPDF di proyek ini

Proyek ini sudah menggunakan paket `barryvdh/laravel-dompdf` untuk menghasilkan file PDF. Paket ini biasanya auto-discovered oleh Laravel. Jika Anda perlu menginstall atau memperbaruinya, jalankan:

```powershell
composer require barryvdh/laravel-dompdf:^3.1
```

Contoh pola penggunaan di sebuah controller (contoh file: `app/Http/Controllers/Operator/ServiceController.php`):

```php
<?php
namespace App\Http\Controllers\Operator;

use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ServiceController
{
		public function download(Service $service)
		{
				$data = ['service' => $service];
				$pdf = Pdf::loadView('operator.services.pdf', $data);
				return $pdf->download("service-{$service->id}.pdf");
		}
}
```

Catatan:

-   View yang dipakai untuk layout PDF di repositori ini berada di `resources/views/operator/services/pdf.blade.php`.
-   Anda bisa menggunakan `stream()` jika ingin menampilkan PDF di browser alih-alih mendownload: `$pdf->stream('nama.pdf');`.

---

Jika Anda mau, saya bisa juga:

-   tambahkan potongan contoh lengkap yang menampilkan koleksi (history) vs single item PDF, atau
-   tambahkan langkah troubleshooting DomPDF (font, gambar, locale) di README.

---

Terakhir, catatan: beberapa langkah (mis. konfigurasi mail, third-party services) tergantung lingkungan Anda — sesuaikan `.env` sesuai kebutuhan.

Happy coding!
