<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'judul_riset',
        'deskripsi_singkat',
        'kategori',
        'penulis',
        'tanggal_rilis',
        'pdf_file',
        'status',
    ];
}