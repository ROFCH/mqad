<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class timeline extends Model
{

    use HasFactory, LogsActivity;


    protected $casts = [
        'id' => 'integer',
        'year' => 'integer',
        'quarter' => 'integer',
        'survey_id' => 'integer',
        'address_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }
    
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}    