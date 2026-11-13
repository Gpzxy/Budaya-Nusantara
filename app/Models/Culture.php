<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Culture extends Model
{
    protected $guarded = [];

    protected $casts = [
        'readings'     => 'array',
        'is_published' => 'boolean',
    ];

    public function entries(): HasMany
    {
        return $this->hasMany(CultureEntry::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /** URL lengkap sebuah gambar yang disimpan relatif ke public/assets/images/ */
    public static function imageUrl(?string $path): string
    {
        return asset('assets/images/' . ltrim((string) $path, '/'));
    }

    /** Pecah teks "baris 1|baris 2" jadi array baris. */
    public static function lines(?string $text): array
    {
        return array_values(array_filter(array_map('trim', explode('|', (string) $text)), 'strlen'));
    }
}
