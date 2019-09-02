<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    public function question(){
    	return $this->belongsTo('App\Questions');
    }
    public function comments(){
    	return $this->hasMany('App\Comments');
    }
    public function users(){
    	return $this->belongsTo('App\Users');
    }
}
