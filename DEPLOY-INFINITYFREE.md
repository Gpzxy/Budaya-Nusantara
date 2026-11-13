# Deploy ke InfinityFree Free

Panduan ini memakai PHP dan MySQL bawaan InfinityFree, tanpa kartu dan tanpa
biaya hosting. Situs ini dapat berjalan dengan Laravel, tetapi deploy dilakukan
manual lewat FTP—bukan otomatis dari GitHub. InfinityFree juga tidak bisa
mengakses database Neon dari luar, jadi database aplikasi harus dipindahkan ke
MySQL yang dibuat di InfinityFree.

InfinityFree menyediakan PHP 8.4, MySQL, SSL, dan subdomain gratis. Laravel 12
membutuhkan PHP 8.2 atau yang lebih baru.

## 1. Buat hosting dan database

1. Daftar melalui [InfinityFree](https://dash.infinityfree.com/register) dan
   buat website dengan subdomain gratis.
2. Dari panel hosting, buat database MySQL. Catat hostname, nama database,
   username, dan password yang ditampilkan.
3. Aktifkan PHP 8.4 jika pilihan versi PHP tersedia.

Jangan gunakan `DATABASE_URL` Neon pada hosting ini. Port database eksternal
diblokir oleh paket gratis; database MySQL InfinityFree hanya dapat dipakai
oleh aplikasi yang berjalan di hosting tersebut.

## 2. Siapkan database dan file aplikasi di komputer

InfinityFree tidak menyediakan SSH, Composer, atau perintah `php artisan` di
server. Siapkan dependency, asset, dan database dari komputer lokal.

1. Siapkan MySQL lokal (misalnya melalui XAMPP) dan buat database
   `budaya_export`.
2. Dari root project, isi sementara environment PowerShell berikut dengan
   koneksi MySQL lokal, lalu jalankan migrasi dan seeder:

   ```powershell
   $env:DB_CONNECTION = "mysql"
   $env:DB_HOST = "127.0.0.1"
   $env:DB_PORT = "3306"
   $env:DB_DATABASE = "budaya_export"
   $env:DB_USERNAME = "root"
   $env:DB_PASSWORD = ""
   try {
       php artisan migrate:fresh --seed --force
       if ($LASTEXITCODE -ne 0) {
           throw "Migration or seeding failed."
       }
   }
   finally {
       foreach ($name in @("DB_CONNECTION", "DB_HOST", "DB_PORT", "DB_DATABASE", "DB_USERNAME", "DB_PASSWORD")) {
           Remove-Item "Env:$name" -ErrorAction SilentlyContinue
       }
   }
   ```

3. Export database lokal melalui phpMyAdmin sebagai file SQL, lalu simpan file
   tersebut untuk diimpor ke phpMyAdmin InfinityFree pada langkah berikutnya.
4. Siapkan file production:

   ```powershell
   composer install --no-dev --no-interaction --prefer-dist
   composer dump-autoload --no-dev --optimize=false
   npm ci
   npm run build
   php artisan optimize:clear
   ```

   Pembuatan autoloader tanpa optimasi membantu menghindari file PHP besar yang
   dapat ditolak oleh hosting gratis.

## 3. Upload ke hosting

1. Hubungkan aplikasi FTP (misalnya FileZilla) memakai host dan kredensial FTP
   dari panel InfinityFree.
2. Upload source Laravel, folder `vendor`, folder `public` termasuk
   `public/build`, dan folder `storage` ke `htdocs`. Jangan upload `.git`,
   `node_modules`, atau file `.env` lokal.
3. Buat `.env` baru langsung di `htdocs` menggunakan kredensial database
   InfinityFree. Contoh:

   ```dotenv
   APP_NAME="Budaya Nusantara"
   APP_ENV=production
   APP_KEY=ISI_DENGAN_HASIL_KEY_GENERATE_SHOW
   APP_DEBUG=false
   APP_URL=https://SUBDOMAIN_KAMU

   DB_CONNECTION=mysql
   DB_HOST=HOST_MYSQL_DARI_PANEL
   DB_PORT=3306
   DB_DATABASE=NAMA_DATABASE
   DB_USERNAME=USERNAME_DATABASE
   DB_PASSWORD="PASSWORD_DATABASE"

   SESSION_DRIVER=file
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
   ```

   Buat nilai `APP_KEY` di komputer lokal dengan `php artisan key:generate
   --show`. Jangan commit atau mengirim `.env` maupun nilai kredensial ke chat.
4. Buat file `.htaccess` di `htdocs` agar request diarahkan ke folder `public`:

   ```apache
   RewriteEngine On
   RewriteCond %{REQUEST_URI} !^/public/
   RewriteRule ^(.*)$ /public/$1 [L]
   ```

   Pertahankan file `public/.htaccess` bawaan Laravel. Sebelum situs dibuka
   untuk umum, pastikan URL `https://SUBDOMAIN_KAMU/.env` menampilkan 404 dan
   tidak menampilkan isi file.
5. Buka phpMyAdmin InfinityFree, pilih database yang dibuat, lalu import file
   SQL dari langkah 2.
6. Pastikan `storage` dan `bootstrap/cache` dapat ditulis oleh PHP. Aktifkan SSL
   untuk subdomain, kemudian tes halaman utama dan `/budaya/jambi`.

## Batasan paket gratis

- Tidak ada deploy otomatis dari GitHub; perubahan aplikasi perlu diunggah
  ulang lewat FTP.
- Perubahan schema/data perlu disiapkan di MySQL lokal, diekspor, lalu diimpor
  melalui phpMyAdmin. Perintah Artisan tidak tersedia di server.
- Paket gratis tidak menyediakan queue worker atau scheduled task.
- Gunakan database MySQL lokal milik InfinityFree, bukan Neon; koneksi database
  keluar ke port PostgreSQL Neon diblokir.

### Referensi

- [InfinityFree Free Hosting](https://www.infinityfree.com/)
- [Panduan resmi Laravel di InfinityFree](https://forum.infinityfree.com/docs?topic=118578)
- [Batas koneksi keluar InfinityFree](https://forum.infinityfree.com/docs?topic=49348)
- [Koneksi database eksternal InfinityFree](https://forum.infinityfree.com/docs?topic=49339)
