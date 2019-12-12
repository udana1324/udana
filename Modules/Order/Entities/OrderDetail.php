<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
    	'order_num', 
        'item_id',
        'quantity_order',
        'user'
    ];
}
