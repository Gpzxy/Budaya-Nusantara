# Deploy ke Alwaysdata Free

Panduan ini untuk project Laravel 12 ini. Paket Alwaysdata Free ditujukan untuk
kebutuhan personal dan memiliki batas 1 GB SSD, RAM 256 MB, dan 1/4 CPU.
Alamat gratis yang disediakan berbentuk `nama-akun.alwaysdata.net`.

## 1. Buat akun dan database

1. Daftar melalui [Alwaysdata Free](https://www.alwaysdata.com/en/register/?p=2012).
2. Buat akun hosting. Catat nama akun karena dipakai pada alamat situs dan
   informasi koneksi.
3. Di panel Alwaysdata, buka **Databases > MySQL** lalu buat database dan
   pengguna. Catat nama database, pengguna, kata sandi, dan host yang
   ditampilkan panel. Jangan menaruh kata sandi database di Git.
4. Di **Environment > PHP**, pilih PHP 8.2 atau yang lebih baru untuk CLI.

## 2. Upload source dan asset

Cara sederhana adalah mengunggah folder project ke akun melalui SFTP, misalnya
ke `/home/NAMA_AKUN/budaya-nusantara`. Folder project harus memuat `artisan`,
`composer.json`, `public/`, `resources/`, dan direktori Laravel lainnya.

- Jangan mengunggah `.env` lokal, `node_modules/`, atau `vendor/`.
- Pastikan semua gambar di `public/assets/images/` ikut terunggah.
- Folder `public/build/` diabaikan oleh Git, jadi buat asset lalu unggah folder
  hasil build itu secara terpisah:

  ```powershell
  npm install
  npm run build
  ```

Unggah isi `public/build/` hasil perintah tersebut ke
`/home/NAMA_AKUN/budaya-nusantara/public/build/`.

Koneksi SFTP Alwaysdata menggunakan host `ssh-NAMA_AKUN.alwaysdata.net`, port
`22`, dan nama pengguna akun (atau pengguna SSH yang dibuat di panel).

## 3. Pasang dependency PHP dan siapkan aplikasi

Masuk ke server menggunakan SSH, lalu jalankan:

```sh
cd ~/budaya-nusantara
composer install --no-dev --optimize-autoloader
cp .env.example .env
```

Edit `.env` di server. Atur nilai berikut; isi kredensial database sesuai panel:

```dotenv
APP_NAME="Budaya Nusantara"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://NAMA_AKUN.alwaysdata.net

DB_CONNECTION=mysql
DB_HOST=HOST_DARI_PANEL
DB_PORT=3306
DB_DATABASE=NAMA_DATABASE
DB_USERNAME=NAMA_PENGGUNA_DATABASE
DB_PASSWORD="KATA_SANDI_DATABASE"

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Simpan `.env` di root project, bukan di dalam `public/`. Buat kunci aplikasi
dan jalankan migrasi:

```sh
php artisan key:generate
php artisan migrate --force
```

Jika PHP CLI menunjukkan versi yang lebih lama dari 8.2, ubah versi default
PHP di **Environment > PHP** dan pastikan versi PHP situs juga minimal 8.2.

## 4. Isi data awal

Jalankan seeder satu kali setelah migrasi:

```sh
php artisan db:seed --class=CultureSeeder --force
```

Seeder ini menghapus lalu membuat ulang entri untuk setiap budaya yang
dimuatnya. Jangan jalankan ulang jika entri tersebut sudah diedit langsung di
database, kecuali memang ingin mengganti data dengan isi seeder.

## 5. Arahkan situs ke direktori `public`

1. Di panel buka **Web > Sites > Add a site**, pilih tipe **PHP** dan alamat
   `NAMA_AKUN.alwaysdata.net`.
2. Atur direktori situs ke
   `/home/NAMA_AKUN/budaya-nusantara/public` (bukan root project).
3. Jika panel meminta alamat subdomain ditambahkan di pengaturan situs,
   tambahkan alamat tersebut di sana juga.
4. Aktifkan **Force HTTPS** pada pengaturan SSL situs setelah situs tersedia.

Document root harus hanya direktori `public`; jangan arahkan situs ke root
project karena file konfigurasi dan `.env` berada di sana.

## 6. Cek deployment

Buka `https://NAMA_AKUN.alwaysdata.net`. Jika terjadi error, cek log di panel
Alwaysdata dan `storage/logs/laravel.log`. Pastikan direktori
`storage/` dan `bootstrap/cache/` dapat ditulis oleh akun situs.

### Referensi

- [Paket Alwaysdata](https://www.alwaysdata.com/en/offers/)
- [Konfigurasi PHP](https://help.alwaysdata.com/en/docs/web-hosting/languages/php/configuration/)
- [Instalasi Composer](https://help.alwaysdata.com/en/docs/web-hosting/languages/php/packages/)
- [Tambah situs](https://help.alwaysdata.com/en/docs/web-hosting/sites/add-a-site/)
- [Koneksi database MariaDB/MySQL](https://help.alwaysdata.com/en/docs/web-hosting/databases/mariadb/)
- [Koneksi SFTP](https://help.alwaysdata.com/en/docs/web-hosting/remote-access/sftp/)
