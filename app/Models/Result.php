<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Result extends Model
{
    
    use LogsActivity;
    
    
    protected $casts = [
        'id' => 'integer',
        'survey_id' => 'integer',
        'address_id' => 'integer',
        'method_id' => 'integer',
        'unit_id' => 'integer',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }


    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }


    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

}
