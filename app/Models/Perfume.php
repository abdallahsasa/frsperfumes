<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Perfume extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name_en',
        'name_ar',
        'slug',
        'gender',
        'concentration',
        'size_ml',
        'price',
        'old_price',
        'stock_status',
        'pre_order',
        'delivery_days',
        'short_description_en',
        'short_description_ar',
        'long_description_en',
        'long_description_ar',
        'year_launched',
        'perfumer',
        'longevity',
        'sillage',
        'season',
        'occasion',
        'source_url',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'season' => 'array',
        'occasion' => 'array',
        'pre_order' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PerfumeImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(PerfumeImage::class)->where('is_primary', true);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->firstWhere('is_primary', true) ?: $this->images->first();
        return $primary ? asset('uploads/' . $primary->image_path) : asset('images/placeholder-perfume.jpg');
    }

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'perfume_note')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function perfumeNotes(): HasMany
    {
        return $this->hasMany(PerfumeNote::class);
    }

    public function topNotes(): BelongsToMany
    {
        return $this->notes()->wherePivot('type', 'top');
    }

    public function middleNotes(): BelongsToMany
    {
        return $this->notes()->wherePivot('type', 'middle');
    }

    public function baseNotes(): BelongsToMany
    {
        return $this->notes()->wherePivot('type', 'base');
    }

    public function accords(): BelongsToMany
    {
        return $this->belongsToMany(Accord::class, 'perfume_accord')
            ->withPivot('intensity')
            ->withTimestamps()
            ->orderByPivot('intensity', 'desc');
    }

    public function perfumeAccords(): HasMany
    {
        return $this->hasMany(PerfumeAccord::class);
    }

    // Accessors for Translations
    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"name_{$locale}"} ?: $this->name_en;
    }

    public function getShortDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"short_description_{$locale}"} ?: $this->short_description_en;
    }

    public function getLongDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"long_description_{$locale}"} ?: $this->long_description_en;
    }
}
