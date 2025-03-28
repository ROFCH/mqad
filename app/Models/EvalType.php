<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EvalType extends Model
{
    
    use LogsActivity;
    
    protected $casts = [
        'id' => 'integer',
        
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }


    public function substances(): HasMany
    {
        return $this->hasMany(Substance::class);
    }
}
