<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users(){
        return $this->hasMany('App\Group');
    }

    public function plugins(){
        return $this->hasMany('App\Plugin');
    }
}
