<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PatientSmear extends Model
{
    
    
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'survey_id' => 'integer',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }
    
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
