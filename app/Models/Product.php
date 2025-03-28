<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    
    
    
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'sample' => 'integer',
        'sort' => 'integer',
        'delivery_note' => 'integer',
        'price'=>'decimal:2',
        'membership' => 'integer',
        'type' => 'integer',
        'sort2' => 'integer',
        'evaluation' => 'integer',
        'sort3' => 'integer',
        'size' => 'integer',
        'translation_id' => 'integer',
        'infectious' => 'boolean',
        'active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }


    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function translation(): BelongsTo
    {
        return $this->belongsTo(Translation::class);
    }
}
