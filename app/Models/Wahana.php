<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wahana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wahana'; 
    protected $primaryKey = 'id_wahana'; 
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; 

    // Daftar field yang bisa diisi secara massal
    protected $fillable = ['title', 'description', 'location', 'price', 'images'];

    // Cast images sebagai array (karena disimpan dalam JSON)
    protected $casts = [
        'images' => 'array',
    ];
}
