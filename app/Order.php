<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function device()
    {
        return $this->belongsTo('App\Device');
    }
}
