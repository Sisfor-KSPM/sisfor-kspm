<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeatureUsage extends Model
{
    protected $table = 'feature_usage';

    protected $fillable = [
        'feature_name',
        'user_id',
        'usage_count',
        'usage_date',
    ];

    protected $casts = [
        'usage_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
