<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id', 'menu_name', 'price', 'qty', 'subtotal'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}