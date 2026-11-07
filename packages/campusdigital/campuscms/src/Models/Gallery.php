<?php

namespace Campusdigital\CampusCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    
    protected $fillable = [
        'judul_gambar',
        'gambar'
    ];

    public $timestamps = false;
}
