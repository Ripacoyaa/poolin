<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model

{
    use HasFactory;

    protected $fillable = [
        'nama_room',
        'deskripsi',
        'kode_room',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // tabungan
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'room_user') // sesuaikan nama pivot tabel kamu
        ->withTimestamps();
}

    // semua tabungan di room (termasuk milik tabungan)
    public function tabungan()
{
    return $this->hasOne(Tabungan::class, 'room_id');
}


}
