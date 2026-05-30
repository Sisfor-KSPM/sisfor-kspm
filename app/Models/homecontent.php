<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class homecontent extends Model
{
    protected $table = 'homecontents';

    protected $fillable = [
        'tagline',
        'judul',
        'deskripsi',
        'ig_link',
        'yt_link',
        'linkedin_link',
        'tt_link',
        'email',
        'whatsapp',
    ];
}
