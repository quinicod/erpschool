<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $table = 'students';

    protected $fillable = ['name','lastname','age'];

    public function cursos()
    {
        return $this->hasManyThrough('App\grade','App\study','id_student','id','id','id_grade');
    }
    public function studies()
    {
        return $this->hasMany(study::class);
    }

}
