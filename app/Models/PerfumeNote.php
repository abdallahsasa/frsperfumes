<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PerfumeNote extends Pivot
{
    public $incrementing = true;

    protected $table = 'perfume_note';

    protected $fillable = [
        'perfume_id',
        'note_id',
        'type',
    ];

    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
