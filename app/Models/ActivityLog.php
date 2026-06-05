<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'page_name',
        'activity_type',
        'description',
        'feature_name',
        'action',
        'target_type',
        'target_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Polymorphic menggunakan kolom target_type dan target_id
     */
    public function target(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'target_type', 'target_id');
    }

    /**
     * Accessor untuk memformat deskripsi log aktivitas di dashboard.
     */
    public function getFormattedDescriptionAttribute(): string
    {
        // 1. Ambil aksi dan tipe aktivitas
        $action = strtolower($this->action ?: $this->activity_type); 
        $actType = strtolower($this->activity_type);

        // Jika sistem masa lalu merekam action sebagai 'use', perbaiki paksa di sini
        if ($action === 'use' || str_contains($action, 'use')) {
            if (str_contains($actType, 'create') || str_contains($actType, 'upload')) $action = 'create';
            elseif (str_contains($actType, 'update')) $action = 'update';
            elseif (str_contains($actType, 'delete')) $action = 'delete';
        }

        // 2. Dapatkan nama entitas (Tebak dari 'event_create' menjadi 'Event')
        $modelName = $this->target_type ? class_basename($this->target_type) : null;
        if (empty($modelName)) {
            $parts = explode('_', $actType);
            $modelName = ucfirst($parts[0] ?? 'Aktivitas');
            if ($modelName === 'Report') $modelName = 'Riset'; // Terjemahan opsional
            if ($modelName === 'Event') $modelName = 'Kegiatan';
        }

        // 3. Ambil judul item
        $itemName = '';
        if ($this->target) {
            $itemName = $this->target->title ?? $this->target->kegiatan ?? $this->target->judul_riset ?? $this->target->name ?? '';
        } 
        
        // Controller Anda mengirim string seperti "Event: Workshop A", kita perlu mengekstrak namanya saja.
        if (empty($itemName) && !empty($this->description)) {
            $decoded = json_decode($this->description, true);
            if (is_array($decoded)) {
                $itemName = $decoded['title'] ?? $decoded['kegiatan'] ?? $decoded['judul_riset'] ?? $decoded['name'] ?? '';
            } else {
                $itemName = $this->description;
                // Regex membuang prefix text dari Controller agar bersih
                $itemName = preg_replace('/^(Event|Report|User|Riset|Kegiatan):\s*/i', '', $itemName);
            }
        }

        if (empty($itemName)) $itemName = 'Item tidak diketahui';
        
        // Batasi panjang agar UI tidak berantakan
        if (mb_strlen($itemName) > 50) $itemName = mb_substr($itemName, 0, 47) . '...';

        // 4. Terjemahkan status aksi
        $actionLabel = '';
        switch ($action) {
            case 'create':
            case 'upload':
                $actionLabel = 'ditambahkan';
                break;
            case 'update':
                $actionLabel = 'diperbarui';
                break;
            case 'delete':
                $actionLabel = 'dihapus';
                break;
            default:
                $actionLabel = $action;
        }

        return "{$modelName} {$actionLabel}: {$itemName}";
    }
}