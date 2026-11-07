<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkemaUji extends Model
{
    use HasFactory;

    protected $table = 'skema_ujis';
    protected $guarded = ['id'];

    public function skema_uks()
    {
        return $this->hasMany(SkemaUk::class, 'skema_uji_id');
    }

    public function skema_jadwals()
    {
        return $this->hasMany(SkemaJadwal::class, 'skema_uji_id');
    }
}