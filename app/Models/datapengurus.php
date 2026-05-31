<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class datapengurus extends Model
{
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
