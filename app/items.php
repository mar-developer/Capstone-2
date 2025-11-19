<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'img_path', 'category', 'serial_code'
    ];

    function user()
    {
        return $this->belongsToMany('App\User', 'item_user')->withPivot('duration');
    }
}
