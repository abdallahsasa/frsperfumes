<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PerfumeAccord extends Pivot
{
    public $incrementing = true;

    protected $table = 'perfume_accord';

    protected $fillable = [
        'perfume_id',
        'accord_id',
        'intensity',
    ];

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }

    public function accord(): BelongsTo
    {
        return $this->belongsTo(Accord::class);
    }
}
