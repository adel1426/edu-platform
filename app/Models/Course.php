<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * السماح بالإدخال الجماعي لجميع الحقول (ما عدا id).
     */
    protected $guarded = ['id'];
}
