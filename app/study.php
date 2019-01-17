<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class study extends Model
{
    protected $table = 'studies';

    protected $fillable = ['id_student','id_grade'];

    // public function grado()
    // {
    //     return $this->hasOne(grade::class,'id','id_grade');
    // }

    public function student()
    {
        return $this->belongsTo(student::class,'id_student');
    }
    public function grades()
    {
        return $this->belongsTo(student::class,'id_student');
    }
}
