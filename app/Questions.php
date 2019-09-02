<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
   
    public function answers(){
    	return $this->hasMany('App\Answers');
    }
    public function users(){
    	return $this->belongsTo('App\Users');
    }
    public function comments(){
    	return $this->HasMany('App\Comments');
    }
}
