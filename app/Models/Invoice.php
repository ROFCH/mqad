<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Invoice extends Model
{
    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'product_id' => 'integer',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
        'amount' => 'decimal:2',
        'invoice_number' => 'integer',        
        'year' => 'integer',
        'quantity' => 'integer',
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
    }//
}
