<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'driver_name',
        'vehicle_size',
        'vehicle_category',
        'reg_zone',
        'reg_serial',
        'reg_no',
        'reg_date',
        'status',
        'tax_date',
        'route_per_date',
        'fitness_date',
        'fuel_capcity',
    ];
}
