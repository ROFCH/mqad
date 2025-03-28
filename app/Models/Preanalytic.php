<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Preanalytic extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'survey_id' => 'integer',
        'translation_id' => 'integer',
        'method_id' => 'integer',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }
    
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function translation(): BelongsTo
    {
        return $this->belongsTo(Translation::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class);
    }

}
