<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTransaksi extends Model
{
    // Kalau nama tabel di DB adalah "group_transaksis" (default plural Laravel),
    // ini sebenarnya boleh dihapus. Tapi aman kalau tetap ditulis.
    protected $table = 'group_transaksis';

    protected $fillable = [
        'room_id',
        'user_id',
        'tgl_transaksi',
        'jenis',       // 'spend' atau 'withdraw'
        'nominal',     // jumlah uang
        'keterangan',
    ];
public function user()
{
    return $this->belongsTo(User::class);
}

public function room()
{
    return $this->belongsTo(Room::class);
}

}
