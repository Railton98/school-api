<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['description'];

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }
}
