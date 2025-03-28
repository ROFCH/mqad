<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Zsrgln extends Model
{

    use HasFactory, LogsActivity;


    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'from_year' => 'integer',
        'till_year' => 'integer',
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
