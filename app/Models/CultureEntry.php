<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CultureEntry extends Model
{
    protected $guarded = [];

    public function culture(): BelongsTo
    {
        return $this->belongsTo(Culture::class);
    }
}
