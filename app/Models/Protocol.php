<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Protocol extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'method_id' => 'integer',
        'unit_id' => 'integer',
        'device_id' => 'integer',
        'department' => 'integer',
        'start_date' => 'datetime',
        'start_year' => 'integer',
        'start_quarter' => 'integer',
        'stop_date' => 'datetime',
        'stop_year' => 'integer',
        'stop_quarter' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }




    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
