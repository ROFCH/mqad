<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Note extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'note_user')->withTimestamps();
    }

}
