<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable=[
        'question',
        'is_general',
        'categories',
        'point',
        'icon_url',
        'duration',
    ];
    public function choice(){
        return $this->hasMany('App\Choice');
    }
}
