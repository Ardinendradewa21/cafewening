<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

//tentang model = dia mewakili table yg ada di database yg secra otomatis
//mewakili table yg berbentuk plural kalo ga plural bisa pake (protected $table = 'nama table';)
class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    //isi kolom" secara mass assignment supaya fitur mass assignment berjalan
    // protected $fillable = [
    //     'title',
    //     'description'
    // ];

    // guarded = untuk membatasi kolom apa yg gaboleh diisi oleh assignment
    // untuk fillable dan guarded gabisa berjalan bersamaan harus salah satu
    protected $guarded = [
        'id'
    ];
}