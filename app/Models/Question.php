<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Question extends Model
{
 
        use HasFactory; 
    
        protected $table = 'question'; 
        protected $primaryKey = 'id_question'; 
        public $incrementing = true;
        protected $keyType = 'int';
        public $timestamps = true; 
    
        protected $fillable = ['pertanyaan', 'jawaban'];
    
    
    }
    