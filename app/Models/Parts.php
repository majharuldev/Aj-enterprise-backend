<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parts extends Model
{
    protected $fillable = [
        'user_id',
        'parts_name',
        'validity',
    ];
}
