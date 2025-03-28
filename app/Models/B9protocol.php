<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class B9protocol extends Model
{
    use LogsActivity;

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
        return $this->BelongsTo(Survey::class);
    }
}
