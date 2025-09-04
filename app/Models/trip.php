<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class trip extends Model
{
    //


    protected $fillable = [
        'user_id',
        'date',
        'load_point',
        'unload_point',
        'vehicle_no',
        'driver_name',
        'fuel_cost',
        'toll_cost',
        'police_cost',
        'commision',
        'labour',
        'others',
        'total_exp',
        'demrage_day',
        'demrage_rate',
        'demrage_total',
        'customer_name',
        'customer_mobile',
        'Rent_amount',
        'advanced',
        'status',
    ];
}
