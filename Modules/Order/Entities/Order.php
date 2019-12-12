<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'order_num', 
        'table_num',
        'total_price',
        'status',
        'user',
        'flag_active'
    ];
}
