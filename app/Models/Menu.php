<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus'; 
    protected $primaryKey = 'id'; 
    protected $fillable = [
        'kode_menu',
        'nama',
        'harga',
        'gambar',
        'kategori',
        'stok',
    ];
}
