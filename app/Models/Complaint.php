<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    use LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'adress_id' => 'integer',
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
