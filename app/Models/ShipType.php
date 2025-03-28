<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class ShipType extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'translation_id' => 'integer',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function shippings(): HasMany
    {
        return $this->hasMany(Shipping::class);
    }


}
