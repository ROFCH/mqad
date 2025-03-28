<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalType extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'translation_id' => 'integer',
    ];

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }
}
