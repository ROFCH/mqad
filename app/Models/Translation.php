<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Translation extends Model
{

    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
