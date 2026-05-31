<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportDownload extends Model
{
    protected $table = 'report_downloads';

    protected $fillable = [
        'report_id',
        'user_id',
        'report_title',
        'download_count',
        'last_download_date',
    ];

    protected $casts = [
        'last_download_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
