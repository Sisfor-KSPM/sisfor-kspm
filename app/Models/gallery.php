<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'foto_link',
        'judul',
        'kategori',
        'tanggal',
        'fotografer',
        'homepage',
    ];
}
