<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Method extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'number' => 'integer',
        'substance_id' => 'integer',
        'instrument_id' => 'integer',
        'sort' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }

    public function substance(): BelongsTo
    {
        return $this->belongsTo(Substance::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function protocols(): HasMany
    {
        return $this->hasMany(Protocol::class);
    }


    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'method_profile')->withPivot(['unit_id'])->withTimestamps();
    }
}

