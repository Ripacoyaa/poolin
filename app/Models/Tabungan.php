<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'foto',
        'room_id',
        'target_tabungan',
        'total_terkumpul',
        'target_tanggal',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'tabungan_id');
    }
}
