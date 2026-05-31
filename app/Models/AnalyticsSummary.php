<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsSummary extends Model
{
    protected $table = 'analytics_summaries';

    protected $fillable = [
        'date',
        'total_page_views',
        'unique_visitors',
        'total_users_registered',
        'total_reports_downloaded',
        'total_event_clicks',
        'total_gallery_views',
        'total_dictionary_views',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
