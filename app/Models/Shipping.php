<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Shipping extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'ship_format_id' => 'integer',
        'language_id' => 'integer',
        'priority' => 'integer',
        'amount' => 'integer',
        'weight' => 'decimal:2',
        'grp' => 'integer',
        'lot' => 'integer',
        'packing' => 'integer',
        'year' => 'integer',
        'quarter' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }


    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function ship_format(): BelongsTo
    {
        return $this->belongsTo(ShipFormat::class);
    }


    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function schedule_type(): BelongsTo
    {
        return $this->belongsTo(ScheduleType::class);
    }


}
