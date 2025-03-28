<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Target extends Model
{

    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'survey_id' => 'integer',
        'method_id' => 'integer',
        'statustarget_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }

    public function statustarget(): BelongsTo
    {
        return $this->belongsTo(Statustarget::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class);
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

}
