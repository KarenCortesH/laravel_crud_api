<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    //Variable
    protected $table = 'student';


    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'language'
    ];


}
