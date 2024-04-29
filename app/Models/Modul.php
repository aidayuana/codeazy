<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'modul';

    protected $fillable = [
        'sekolah_course_id',
        'judul',
        'file_path',
    ];

    public function sekolahCourse()
    {
        return $this->belongsTo(SekolahCourse::class);
    }
}
