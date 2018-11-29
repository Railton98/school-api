<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['name', 'birth', 'gender', 'classroom_id'];

    // /**
    //  * The accessors to append to the model's array form.
    //  * @var array
    //  */
    // protected $appends = ['is_accepted'];
    //
    // /**
    //  * The attributes that should be hidden for arrays.
    //  * @var array
    //  */
    // protected $hidden = ['created_at', 'updated_at'];
    //
    // /**
    //  * The attributes that should be cast to native types.
    //  * @var array
    //  */
    // protected $casts = [
    //     'birth' => 'date:d/m/Y',
    // ];
    //
    // /**
    //  * Get the accepted flag for the student.
    //  */
    // public function getIsAcceptedAttribute()
    // {
    //     return $this->attributes['birth'] > '2002-01-01' ? 'accepted' : 'not_accepted';
    // }

    /**
     * Get the classroom of the student.
     */
    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }
}
