<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkemaJadwal extends Model
{
    use HasFactory;

    protected $table = 'skema_jadwals';
    protected $guarded = ['id'];

    public function skema_uji()
    {
        return $this->belongsTo(SkemaUji::class, 'skema_uji_id');
    }

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class, 'skema_jadwal_id');
    }
}