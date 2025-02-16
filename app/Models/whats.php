<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class whats extends Model
{
    use HasFactory; 

    protected $table = 'whats'; 
    protected $primaryKey = 'id_whats'; 
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; 

    protected $fillable = ['images'];


}