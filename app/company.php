<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['name','city','cp'];

    
}
