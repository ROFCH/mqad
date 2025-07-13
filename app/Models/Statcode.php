<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statcode extends Model
{
    use LogsActivity;

    protected $casts = [
        'id' => 'integer',
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function code(): BelongsTo
    {
        return $this->belongsTo(Code::class, 'code_code', 'code');
    }


    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }
}
