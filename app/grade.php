<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class grade extends Model
{
    protected $table = 'grades';

    protected $fillable = ['name','level'];

    public function students()
    {
        return $this->hasManyThrough('App\student','App\study','id_grade','id','id','id_student');
    }
}
