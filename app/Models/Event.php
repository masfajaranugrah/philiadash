<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'start', 'end', 'className', 'allDay', 'location', 'description', 'extendedProps'];

    // Jika Anda ingin meng-cast kolom tertentu
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'extendedProps' => 'array', // Meng-cast extendedProps menjadi array
    ];
}
