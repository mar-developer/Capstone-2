<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    function user()
    {
        return $this->belongsToMany('App\User', 'users_id');
    }
}
