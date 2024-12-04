<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    
    protected $fillable = [
        'name',
        'dob',
        'address',
        'created_by',
        'updated_by'
    ];
}
