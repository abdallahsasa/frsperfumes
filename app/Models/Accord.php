<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Accord extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'color_hex',
    ];

    public function perfumes(): BelongsToMany
    {
        return $this->belongsToMany(Perfume::class, 'perfume_accord')
            ->withPivot('intensity')
            ->withTimestamps();
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"name_{$locale}"} ?: $this->name_en;
    }
}
