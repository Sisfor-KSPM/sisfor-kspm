<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'kegiatan',
        'tipe',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'pic',
        'deskripsi',
        'status',
        'kuota'
    ];
}