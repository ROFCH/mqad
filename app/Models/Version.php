<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Version extends Model
{

    use HasFactory, LogsActivity;
    
    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'year' => 'integer',
        'quarter' => 'integer',
        'survey_id' => 'integer',
        'version' => 'integer',
        'created' => 'date',
        'user_id' => 'integer',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }

    
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
