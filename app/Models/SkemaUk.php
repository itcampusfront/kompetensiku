<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkemaUk extends Model
{
    use HasFactory;

    protected $table = 'skema_uks';
    protected $guarded = ['id'];

    public function skema_uji()
    {
        return $this->belongsTo(SkemaUji::class, 'skema_uji_id');
    }
}