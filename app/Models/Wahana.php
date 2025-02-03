<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Wahana extends Model
{
    use HasFactory; 

    protected $table = 'wahana'; 
    protected $primaryKey = 'id_wahana'; 
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; 

    protected $fillable = ['title', 'description', 'location', 'price', 'images'];


}
