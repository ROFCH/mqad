<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Address extends Model
{
    
    
    use HasFactory, LogsActivity;

  

    protected $casts = [
        'id' => 'integer',
        'language_id' => 'integer',
        'lab_type_id' => 'integer',
        'lab_group_id' => 'integer',
        'qualab' => 'boolean',
        'no_charge' => 'boolean',
        'status_id' => 'integer',
        'report_size_id' => 'integer',
        'invoice_type_id' => 'integer',
        'no_membership' => 'boolean',
        'simple_membership' => 'boolean',
        'ship_format_id' => 'integer',
        'report_type_id' => 'integer',
        'h3_education_only' => 'boolean',
        'difficult' => 'boolean',
        'online_num' => 'integer',
        'ship_type_id' => 'integer',
        'report_format_id' => 'integer',
        'no_reminder' => 'boolean',
        'temp_no_reminder' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();

    }



    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function labType(): BelongsTo
    {
        return $this->belongsTo(LabType::class);
    }

    public function labGroup(): BelongsTo
    {
        return $this->belongsTo(LabGroup::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function invoiceType(): BelongsTo
    {
        return $this->belongsTo(InvoiceType::class);
    }

    public function shipType(): BelongsTo
    {
        return $this->belongsTo(ShipType::class);
    }

    public function shipFormat(): BelongsTo
    {
        return $this->belongsTo(ShipFormat::class);
    }

    public function reportType(): BelongsTo
    {
        return $this->belongsTo(ReportType::class);
    }

    public function reportFormat(): BelongsTo
    {
        return $this->belongsTo(ReportFormat::class);
    }

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    public function zsrglns(): HasMany
    {
        return $this->hasMany(Zsrgln::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function shippings(): HasMany
    {
        return $this->hasMany(Shipping::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    public function protocols(): HasMany
    {
        return $this->hasMany(Protocol::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(Version::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }


    public function sterilizers(): HasMany
    {
        return $this->hasMany(Sterilizer::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

}
