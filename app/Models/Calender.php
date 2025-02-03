<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Calender extends Model
{
    use HasFactory;

    // Explicitly specify the table name if it is not "calenders"
    protected $table = 'calenders'; // or whatever the table name is

    protected $fillable = [
        'title',
        'start',
        'end',
        'allDay',
        'className',
        'location',
        'description'
    ];
}
