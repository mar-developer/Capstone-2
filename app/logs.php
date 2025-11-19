<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class logs extends Model
{
    protected $fillable = [
        'name', 'action', 'status', 'user_id'
    ];
}
