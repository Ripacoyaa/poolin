<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_room',
        'kode_room',   // baru
        'tgl_buat',
        'deskripsi',
    ];

     public function tabungans()
    {
        return $this->hasMany(Tabungan::class);
    }
}
