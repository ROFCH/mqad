<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Activity
{

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id', 'id');
    }
    
}
