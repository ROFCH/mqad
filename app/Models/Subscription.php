<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Subscription extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'product_id' => 'integer',
        'sample_quantity' => 'integer',
        'inscription_date' => 'date',
        'start_year' => 'integer',
        'start_quarter' => 'integer',
        'termination_date' => 'date',
        'stop_year' => 'integer',
        'stop_quarter' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }


    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
