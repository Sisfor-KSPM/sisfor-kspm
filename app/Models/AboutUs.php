<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit (opsional tapi disarankan karena nama model bahasa Inggris dengan CamelCase)
    protected $table = 'about_us'; 

    protected $fillable = [
        'logo',
        'nama',
        'singkatan',
        'kepanjangan',
        'deskripsi',
        'visi',
        'misi',
        'tahun_berdiri',
        'total_anggota',
        'tahun_aktif',
        'program_kerja',
        'publikasi_riset',
    ];
}