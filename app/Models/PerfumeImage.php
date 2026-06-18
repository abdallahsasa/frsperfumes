<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerfumeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'perfume_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }
}
