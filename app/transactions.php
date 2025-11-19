<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class transactions extends Model
{
    use Sortable;
    protected $fillable = [
        'transaction_code', 'serial_code', 'name', 'img_path', 'rent_date', 
        'return_date', 'duration', 'price', 'status', 'items_id', 'users_id'
    ];
    public $sortable = ['id', 'name', 'price', 'rent_date', 'return_date', 'duration'];
}
