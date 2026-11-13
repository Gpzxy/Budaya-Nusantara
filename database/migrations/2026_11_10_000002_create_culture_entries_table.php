<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('culture_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('culture_id')->constrained()->cascadeOnDelete();
            $table->string('image');                       // relatif ke public/assets/images/
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('group_label')->nullable();     // label kecil di atas judul
            $table->string('title');
            $table->string('lead')->nullable();
            $table->text('body');
            $table->string('meta')->nullable();
            $table->string('alt');
            $table->unsignedTinyInteger('float_slot')->nullable(); // 1-3: tampil sebagai foto melayang di layar kedua
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('culture_entries');
    }
};
