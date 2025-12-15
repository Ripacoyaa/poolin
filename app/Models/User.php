<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // email_verified_at tidak diperlukan
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

public function rooms()
{
    return $this->belongsToMany(Room::class, 'room_user');
}



public function transaksis()
{
    return $this->hasMany(Transaksi::class);
}

public function room()
{
    return $this->belongsToMany(Room::class, 'room_user') // sama pivot
        ->withTimestamps();
}

public function getPhotoUrlAttribute()
{
    return $this->photo_path
        ? \Illuminate\Support\Facades\Storage::url($this->photo_path)
        : asset('images/user.png');
}

}
