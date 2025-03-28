<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{

    use HasFactory, LogsActivity;


    protected $casts = [
        'id' => 'integer',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }



    public function substance(): BelongsTo
    {
        return $this->belongsTo(Substance::class);


    }

    public function unitSymbol(): BelongsTo
    {
        return $this->belongsTo(UnitSymbol::class);
    }

    public function protocols(): HasMany
    {
        return $this->hasMany(Protocol::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }


    
 }
