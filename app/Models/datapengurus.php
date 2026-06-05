<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datapengurus extends Model
{
    use HasFactory;

    protected $table = 'datapenguruses';
    
    protected $fillable = [
        'nama',
        'nim',
        'jabatan',
        'divisi',
        'periode',
        'angkatan',
        'email',
        'linkedin',
        'foto_pengurus'
    ];
}
