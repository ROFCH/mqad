<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SemiqntClasses extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'method_id' => 'integer',
        
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }
    
    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class);
    }
}
