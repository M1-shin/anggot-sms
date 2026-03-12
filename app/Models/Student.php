<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'date_of_birth',
        'sex',
        'email',
        'mobile_number',
        'address',
        'school_name',
        'course',
        'year_level',
        'father_name',
        'mother_name',
        'parent_occupation',
        'parents_gross_income'
    ];
}
