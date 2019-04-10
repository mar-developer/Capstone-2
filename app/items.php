<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    function user()
    {
        return $this->belongsToMany('App\User', 'item_user')->withPivot('duration');
    }
}
