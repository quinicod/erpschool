<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class petition extends Model
{
    protected $table = 'petitions';

    protected $fillable = ['id_company','id_grade','type','n_students'];

    public function company()
    {
        return $this->belongsTo(company::class,'id_company');
    }

    public function grade()
    {
        return $this->belongsTo(grade::class,'id_grade');
    }
}
