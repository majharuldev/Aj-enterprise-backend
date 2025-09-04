<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'driver_name',
        'driver_mobile',
        'nid',
        'address',
        'note',
        'lincense',
        'expire_date',
        'lincense_image',
        'status',
    ];
}
