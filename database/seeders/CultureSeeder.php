<?php

namespace Database\Seeders;

use App\Models\Culture;
use Illuminate\Database\Seeder;

/*
 * ISI AWAL WEBSITE. Aman dijalankan berulang (data dengan slug yang sama akan diperbarui).
 *
 * MENAMBAH BUDAYA BARU: salin satu blok [ ... ] di dalam cultures() di bawah, ganti isinya,
 * taruh fotonya di public/assets/images/cultures/<slug>/, lalu jalankan:
 *     php artisan db:seed --class=CultureSeeder
 * Foto di database ditulis relatif ke public/assets/images/, contoh: 'cultures/bali/pura-01.jpg'.
 */
class CultureSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->cultures() as $i => $data) {
            $entries = $data['entries'];
            unset($data['entries']);

            $culture = Culture::updateOrCreate(
                ['slug' => $data['slug']],
                $data + ['sort_order' => $i + 1]
            );

            $culture->entries()->delete();
            foreach ($entries as $n => $entry) {
                $culture->entries()->create($entry + ['sort_order' => $n + 1]);
            }
        }
    }

    private function cultures(): array
    {
        return [
            // ───────────────────────── JAMBI ─────────────────────────
            [
                'slug'      => 'jambi',
                'name'      => 'Jambi',
                'province'  => 'Provinsi Jambi',
                'tagline'   => 'Tujuh lembar naskah akta Kesultanan Jambi, 1886–1887, dibaca lembar demi lembar.',
                'card_image' => 'cultures/jambi/hero-danau.jpg',

                'hero_title'      => 'Jejak Jambi dalam lembar naskah.',
                'hero_intro'      => 'Dokumenter budaya Jambi lewat foto dan penjelasannya. Bagian pertama: tujuh lembar naskah akta Kesultanan Jambi dari tahun 1886–1887.',
                'hero_cta_label'  => 'Baca naskahnya',
                'hero_image_wide' => 'cultures/jambi/hero-danau.jpg',
                'hero_image_room' => 'cultures/jambi/hero-ruang.jpg',
                'readings'        => [
                    ['Naskah', '7 halaman'],
                    ['Bahasa', 'Belanda · Melayu'],
                    ['Tahun', '1886–1887'],
                ],

                'intro_heading'    => 'Sejarah tertulis|dalam dua bahasa,|dua aksara',
                'intro_text'       => 'Tujuh lembar salinan akta dari akhir abad ke-19 ini menyimpan satu peristiwa penting Kesultanan Jambi: pengakuan dan pengesahan seorang sultan oleh pemerintah Hindia Belanda. Di setiap halaman, tulisan Belanda berjalan berdampingan dengan tulisan Arab-Melayu (Jawi). Dokumentasi ini mengajak membacanya lembar demi lembar.',
                'intro_link_label' => 'Mulai dari halaman pertama',

                'gallery_label' => 'Naskah',
                'gallery_title' => 'Tujuh lembar,|dua akta',
                'gallery_intro' => 'Gulir untuk membaca. Foto di samping berganti mengikuti penjelasan; klik foto untuk membukanya dalam ukuran penuh.',
                'gallery_note'  => 'Catatan: nama, gelar, dan tanggal dibaca dari tulisan tangan dan masih perlu diverifikasi oleh ahli.',
                'photo_side'    => 'right', // 'right' = foto di kanan, 'left' = foto di kiri

                'about'   => 'Dokumentasi foto dan penjelasan budaya Jambi. Seri pertama membahas naskah akta Kesultanan Jambi, 1886–1887.',
                'sources' => null, // isi nama pemilik arsip / tim dokumentasi / instansi

                'entries' => array (
              0 => 
              array (
                'image' => 'cultures/jambi/naskah-01.jpg',
                'width' => 1204,
                'height' => 1600,
                'group_label' => 'Akta I · Pengakuan dan pengesahan',
                'title' => 'Pembuka akta',
                'lead' => 'Dua bahasa, dua aksara, satu halaman.',
                'body' => 'Halaman pertama memuat judul akta berbahasa Belanda: pengakuan dan pengesahan seorang Pangeran Ratu sebagai Sultan Jambi beserta daerah takluknya. Kolom kanan berisi teks Belanda bertulisan sambung, kolom kiri padanannya dalam aksara Arab-Melayu (Jawi). Teks juga merujuk pada kontrak antara Pemerintah Hindia Belanda dan Kesultanan Jambi yang dibuat pada 1882.',
                'meta' => 'Belanda + Jawi · rujukan 1882',
                'alt' => 'Halaman pertama akta: teks Belanda di kolom kanan, teks Arab-Melayu di kolom kiri',
                'float_slot' => 1,
              ),
              1 => 
              array (
                'image' => 'cultures/jambi/naskah-02.jpg',
                'width' => 1204,
                'height' => 1600,
                'group_label' => 'Akta I · Pengakuan dan pengesahan',
                'title' => 'Sumpah di hadapan Residen',
                'lead' => 'Pengakuan diikrarkan di depan pejabat kolonial.',
                'body' => 'Halaman kedua mencatat bahwa Pangeran Ratu Tjakra Negara bersumpah di hadapan Residen Palembang (tertulis: Gerauld Johannes du Cloux) dan menandatangani ikatan tertulis yang dilampirkan pada akta. Pengakuannya diberikan dengan persetujuan Gubernur Jenderal Hindia Belanda. Tarikh dalam aksara Jawi menyebut bulan Muharram 1304 H.',
                'meta' => 'Oktober 1886 · Muharram 1304 H',
                'alt' => 'Halaman kedua akta berisi sumpah di hadapan Residen Palembang',
                'float_slot' => 2,
              ),
              2 => 
              array (
                'image' => 'cultures/jambi/naskah-03.jpg',
                'width' => 1600,
                'height' => 1204,
                'group_label' => 'Akta I · Pengakuan dan pengesahan',
                'title' => 'Ikrar kesetiaan',
                'lead' => 'Janji menaati perjanjian yang sudah ada.',
                'body' => 'Lembar ini memuat bagian ikrar: janji untuk menaati ketentuan dan perjanjian yang telah dibuat antara Pemerintah Hindia Belanda dan Kesultanan Jambi, serta kesepakatan-kesepakatan yang menyusul. Seperti halaman lain, teks Belanda diikuti padanannya dalam Jawi.',
                'meta' => 'Belanda + Jawi · lanjutan Akta I',
                'alt' => 'Halaman ketiga akta berisi ikrar kesetiaan',
                'float_slot' => NULL,
              ),
              3 => 
              array (
                'image' => 'cultures/jambi/naskah-04.jpg',
                'width' => 1600,
                'height' => 1204,
                'group_label' => 'Akta II · Akta ikatan (verband)',
                'title' => 'Akta ikatan',
                'lead' => 'Akta kedua dimulai di sini.',
                'body' => 'Halaman ini membuka akta kedua, "Acte van verband". Pangeran Ratu Tjakra Negara, dengan nama Sultan Ratu Achmad Dzainoedin bin Sultan Mohamad Fachroedin, bertindak sebagai Sultan Jambi dan daerah takluknya, lalu berjanji setia kepada Raja Belanda dan Gubernur Jenderal Hindia Belanda.',
                'meta' => 'Belanda + Jawi · janji setia',
                'alt' => 'Halaman pembuka akta ikatan (Acte van verband)',
                'float_slot' => NULL,
              ),
              4 => 
              array (
                'image' => 'cultures/jambi/naskah-05.jpg',
                'width' => 1600,
                'height' => 1204,
                'group_label' => 'Akta II · Akta ikatan (verband)',
                'title' => 'Pernyataan dan para saksi',
                'lead' => 'Daftar pembesar yang ikut menyaksikan.',
                'body' => 'Pernyataan ditutup dengan penegasan bahwa akta dibuat di hadapan Residen Palembang dan para pembesar Jambi. Di bagian bawah tertulis deretan nama pangeran kesultanan, sebagian besar bergelar Kesuma, lengkap dengan padanan Jawi di sisi kirinya.',
                'meta' => 'Belanda + Jawi · daftar saksi',
                'alt' => 'Halaman berisi penutup pernyataan dan daftar nama pangeran',
                'float_slot' => NULL,
              ),
              5 => 
              array (
                'image' => 'cultures/jambi/naskah-06.jpg',
                'width' => 1600,
                'height' => 1204,
                'group_label' => 'Akta II · Akta ikatan (verband)',
                'title' => 'Tanda tangan dan cap',
                'lead' => 'Cap Residen berdampingan dengan cap berkaligrafi Arab.',
                'body' => 'Halaman ini bertanggal Djambi, Oktober 1886, dan memuat tanda tangan Residen Palembang beserta cap "Resident van Palembang". Di sisi lain terlihat tanda tangan para pembesar dalam aksara Jawi dan sebuah cap bundar berkaligrafi Arab dengan angka tahun 1304 H, yang diduga cap kesultanan.',
                'meta' => 'Oktober 1886 · 1304 H',
                'alt' => 'Halaman tanda tangan dengan cap Residen Palembang dan cap bundar berkaligrafi Arab',
                'float_slot' => NULL,
              ),
              6 => 
              array (
                'image' => 'cultures/jambi/naskah-07.jpg',
                'width' => 1204,
                'height' => 1600,
                'group_label' => 'Akta II · Akta ikatan (verband)',
                'title' => 'Pengesahan Gubernur Jenderal',
                'lead' => 'Tiga bulan kemudian, akta resmi disahkan.',
                'body' => 'Halaman terakhir menyebut nama dan gelar Sultan Ratu Achmad Dzainoedin bin Sultan Mohamad Fachroedin, dengan keterangan dibuat di Djambi pada 7 Oktober 1886 oleh Residen Palembang. Di bagian bawah, Gubernur Jenderal Hindia Belanda menyatakan kedua akta disetujui dan disahkan pada 13 Januari 1887, ditandatangani Sekretaris Umum atas perintahnya.',
                'meta' => '13 Januari 1887',
                'alt' => 'Halaman penutup: tanda tangan Residen Palembang dan pengesahan Gubernur Jenderal',
                'float_slot' => 3,
              ),
            ),
            ],

            // Tambah budaya lain di sini (salin blok Jambi di atas, lalu ganti isinya).
        ];
    }
}
