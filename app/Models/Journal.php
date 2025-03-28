<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'journal_type_id' => 'integer',
        'year' => 'integer',
        'quarter' => 'integer',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function journalType(): BelongsTo
    {
        return $this->belongsTo(JournalType::class);
    }
}
