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
     * Properti $fillable ini sangat penting untuk keamanan.
     * Hanya kolom-kolom yang disebutkan di sini yang bisa diisi
     * menggunakan metode seperti Product::create([...]).
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
}