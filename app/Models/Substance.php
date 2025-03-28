<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Substance extends Model
{


    use LogsActivity;
    
    protected $casts = [
        'id' => 'integer',

    ];
    
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }



    public function methods(): HasMany
    {
        return $this->hasMany(Method::class);
    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function evalType(): BelongsTo
    {
        return $this->belongsTo(EvalType::class);
    }

    public function unitSymbol(): BelongsTo
    {
        return $this->belongsTo(UnitSymbol::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function translation(): BelongsTo
    {
        return $this->belongsTo(Translation::class);
    }


}
