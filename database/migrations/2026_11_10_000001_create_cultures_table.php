<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cultures', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();            // alamat halaman: /budaya/jambi
            $table->string('name');                       // Jambi
            $table->string('province');                   // Provinsi Jambi
            $table->string('tagline', 300);               // kalimat singkat untuk kartu & slide beranda
            $table->string('card_image');                 // foto kartu/slide beranda (relatif ke public/assets/images/)

            // Layar pertama halaman budaya
            $table->string('hero_title');
            $table->text('hero_intro');
            $table->string('hero_cta_label')->default('Mulai membaca');
            $table->string('hero_image_wide');            // foto latar layar 1
            $table->string('hero_image_room');            // foto latar layar 2
            $table->json('readings')->nullable();         // [["Naskah","7 halaman"], ...] maks 3

            // Layar kedua (pengantar). Pisahkan baris judul dengan tanda |
            $table->string('intro_heading');
            $table->text('intro_text');
            $table->string('intro_link_label')->default('Mulai dari awal');

            // Bagian galeri (foto + penjelasan)
            $table->string('gallery_label')->default('Galeri');   // juga dipakai di menu
            $table->string('gallery_title');                      // pisahkan 2 baris dengan |
            $table->text('gallery_intro');
            $table->text('gallery_note')->nullable();
            $table->string('photo_side', 5)->default('right');    // 'right' atau 'left'

            // Footer
            $table->text('about')->nullable();
            $table->text('sources')->nullable();

            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cultures');
    }
};
