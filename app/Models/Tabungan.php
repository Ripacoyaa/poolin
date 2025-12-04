<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungans';

    protected $fillable = [
        'user_id',
        'room_id',
        'nama',
        'foto',
        'target_tabungan',
        'total_terkumpul',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

}
