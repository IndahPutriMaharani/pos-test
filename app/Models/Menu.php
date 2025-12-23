<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'menus';

    // Kolom-kolom yang dapat diisi user
    protected $fillable = ['name', 'image', 'price'];
}
