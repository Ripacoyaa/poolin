<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'target_tabungan',
        'total_terkumpul',
        'status',
        'target_date', // ✅ tambahin ini kalau kolomnya ada
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
