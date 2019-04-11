<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class logs extends Model
{
    use Sortable;
    protected $fillable = [
        'name', 'action', 'status'
    ];
    public $sortable = ['id', 'name', 'action', 'status'];
}
