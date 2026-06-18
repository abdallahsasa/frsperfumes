<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_ar',
        'subtitle_en',
        'subtitle_ar',
        'image_path',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getTitleAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?: $this->title_en;
    }

    public function getSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->{"subtitle_{$locale}"} ?: $this->subtitle_en;
    }
}
