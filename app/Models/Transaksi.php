<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tabungan;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'user_id',
        'tabungan_id',
        'nominal',
        'keterangan',
        'tgl_transaksi',
        'jenis', // saving / withdraw
    ];

    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class, 'tabungan_id');
    }
}


