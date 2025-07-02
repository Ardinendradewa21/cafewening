<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'stock',
        'category',
        'icon',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Get formatted price for display
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Scope untuk produk yang tersedia (stock > 0)
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope untuk produk berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}