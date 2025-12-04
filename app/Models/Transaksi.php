<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tabungan;

class Transaksi extends Model
{
    protected $fillable = [
    'tabungan_id',
    'tgl_transaksi',
    'nominal',
    'jenis',
    'keterangan',   // <-- tambahkan ini
];

 public function tabungan()
    {
        return $this->belongsTo(Tabungan::class, 'tabungan_id');
    }

}
