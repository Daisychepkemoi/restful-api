<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public function answers(){
    	return $this->belongsTo('App\Answers');
    }
    public function users(){
    	return $this->belongsTo('App\Users');
    }
}
