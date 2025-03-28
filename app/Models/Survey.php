<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Survey extends Model
{
    use HasFactory, LogsActivity;

    protected $casts = [
        'id' => 'integer',
        'year' => 'integer',
        'quarter' => 'integer',
        'shipping' => 'datetime',
        'closing' => 'datetime',
        'replacementdate' => 'datetime',
        'end' => 'datetime',
        'status' => 'integer',
        'online_id' => 'integer',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }



    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function patientSmears(): HasMany
    {
        return $this->hasMany(PatientSmear::class);
    }


}
