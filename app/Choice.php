<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    //
    protected $fillable=[
        'question_id',
        'description',
        'is_correct_choice',
        'icon_url',
    ];
    public function question(){
        return $this->belongsTo('App\Question');
    }
}
