<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'transactions';

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = ['total_price'];
}
