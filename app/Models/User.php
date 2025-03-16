<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    protected $table = 'users'; // Menentukan tabel yang digunakan
    protected $primaryKey = 'id'; // Menentukan primary key
    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password', // Menyembunyikan password saat mengembalikan data
    ];
    public function orders()    {        return $this->hasMany(Order::class);    }
}
