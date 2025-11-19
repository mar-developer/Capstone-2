<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class serials extends Model
{
    protected $fillable = [
        'serial_code', 'status', 'items_id'
    ];

    public function items()
    {
        return $this->belongsTo('App\items', 'items_id');
    }
}
