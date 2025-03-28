<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Schedule extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'schedule_type_id' => 'integer',
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

  
    public function schedule_type(): BelongsTo
    {
        return $this->belongsTo(ScheduleType::class);
    }


    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
