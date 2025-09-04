<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyExpense extends Model
{
    protected $fillable = [
        'user_id', // 🔴 এটা না থাকায় error হয়েছে
        'date',
        'particulars',
        'payment_category',
        'paid_to',
        'amount',
        'status'
    ];
}
