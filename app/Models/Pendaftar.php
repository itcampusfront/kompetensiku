<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftars';
    protected $guarded = ['id'];

    public function skema_jadwal()
    {
        return $this->belongsTo(SkemaJadwal::class, 'skema_jadwal_id');
    }
}