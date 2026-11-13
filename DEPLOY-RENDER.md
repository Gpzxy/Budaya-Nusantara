# Deploy ke Render Free + Neon

Project ini menggunakan Laravel 12, Blade, Vite, dan database untuk merender
halaman budaya. Konfigurasi ini menjalankan Laravel sebagai Docker web service
di Render dan memakai PostgreSQL Free di Neon. Render menyediakan alamat
`*.onrender.com`; tidak perlu membeli domain untuk mulai mencoba.

## 1. Gunakan database Neon

Project `budaya-nusantara` sudah dibuat di organisasi Neon
`org-crimson-haze-49981644` dengan ID `royal-cell-76451582`, branch `main`,
dan region Singapore. Tidak perlu membuat project baru.

1. Buka project tersebut di [Neon](https://neon.tech/) dan salin pooled
   PostgreSQL connection string untuk branch `main`.
2. Simpan connection string sebagai rahasia. Jangan commit ke Git atau
   membagikannya di chat. Connection string Neon sudah mencantumkan parameter
   SSL yang diperlukan.

Neon CLI juga sudah menambahkan variabel koneksi ke `.env` lokal. File itu
diabaikan Git; jangan menyalin nilainya ke dokumentasi atau source code.

## 2. Push project ke GitHub

Push repository project ini ke GitHub. Jangan commit file `.env` atau
connection string Neon. File `.dockerignore` mengecualikan `.env`, dependency
lokal, build lokal, dan database SQLite dari Docker image.

## 3. Buat web service Render

1. Hubungkan repository GitHub ke [Render](https://dashboard.render.com/).
2. Pilih deployment dari **Blueprint** agar Render membaca `render.yaml`, lalu
   tinjau service `budaya-nusantara` dengan plan **Free**. Jika nama service
   sudah dipakai, ganti `name` di `render.yaml` sebelum membuat Blueprint.
3. Saat diminta, isi `DATABASE_URL` dengan connection string Neon. Jika deploy dari
   dashboard biasa, tambahkan environment variable yang tercantum di
   `render.yaml` pada service dan isi `APP_KEY` dengan hasil
   `php artisan key:generate --show` di komputer lokal.
4. Tunggu build Docker dan deploy selesai. Container akan menjalankan
   `php artisan migrate --force` sebelum Apache menerima request.
5. Setelah Render memberi alamat situs, atur `APP_URL` pada environment
   service, misalnya `https://nama-service.onrender.com`, lalu lakukan deploy
   ulang. Asset Laravel otomatis dibuat menggunakan HTTPS di production.

## 4. Masukkan data budaya awal

Seeder project menghapus dan membuat ulang entri untuk budaya yang dimuatnya.
Jalankan seeder **satu kali saja** dari PowerShell di komputer lokal, setelah
Render service dan database Neon tersedia. Dari root project:

```powershell
$env:DB_CONNECTION = "pgsql"
$env:DATABASE_URL = "ISI_DENGAN_CONNECTION_STRING_NEON"
try {
    php artisan migrate --seed --force
    if ($LASTEXITCODE -ne 0) {
        throw "Migration or seeding failed."
    }
}
finally {
    Remove-Item Env:DB_CONNECTION -ErrorAction SilentlyContinue
    Remove-Item Env:DATABASE_URL -ErrorAction SilentlyContinue
}
```

Perintah migrasi boleh dijalankan lagi karena tidak mengulang migrasi yang
sudah tercatat. Hindari mengulang `--seed` setelah konten budaya diedit di
database, karena `CultureSeeder` mengganti entri budaya yang ada.

## 5. Catatan paket gratis

- Render Free menghentikan web service setelah 15 menit tanpa trafik; request
  berikutnya dapat menunggu sekitar satu menit saat service aktif kembali.
- Filesystem Render bersifat sementara. Gambar situs disertakan dalam image
  deploy; jangan mengandalkan filesystem lokal untuk menyimpan upload pengguna.
- Database Neon Free berkapasitas 1 GB dan otomatis scale-to-zero setelah
  sekitar 5 menit tidak aktif. Request pertama setelah jeda mungkin perlu
  waktu untuk mengaktifkan database.
- Paket Free cocok untuk demo, belajar, atau project hobi; bukan jaminan
  layanan produksi.

### Referensi

- [Render: Laravel dengan Docker](https://render.com/docs/deploy-php-laravel-docker)
- [Render: deploy gratis dan batasannya](https://render.com/docs/free)
- [Render: Blueprint specification](https://render.com/docs/blueprint-spec)
- [Neon: paket dan batas gratis](https://neon.com/pricing)
