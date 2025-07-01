<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_name',
        'quantity',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2'
    ];

    /**
     * Relasi dengan Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi dengan Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor untuk menghitung total (price * quantity)
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
