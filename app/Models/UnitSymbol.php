<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitSymbol extends Model
{

    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }


    public function substance(): HasMany
    {
        return $this->hasMany(Substance::class);
    }
}
