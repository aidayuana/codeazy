<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function sekolahcourse()
    {
        return $this->hasMany(SekolahCourse::class, 'course_id', 'id');
    }
}
