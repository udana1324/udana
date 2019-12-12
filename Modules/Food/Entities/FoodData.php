<?php

namespace Modules\Food\Entities;

use Illuminate\Database\Eloquent\Model;

class FoodData extends Model
{
    protected $fillable = [
    	'code', 
        'name',
        'category',
        'price',
        'flag_ready',
        'user',
        'flag_active'
    ];
}
