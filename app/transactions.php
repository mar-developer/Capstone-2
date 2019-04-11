<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class transactions extends Model
{
    use Sortable;
    protected $fillable = [
        'name', 'action', 'status'
    ];
    public $sortable = ['id', 'name', 'price', 'rent_date', 'return_date', 'duration'];
}
