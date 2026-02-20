<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyProfitRate extends Model
{
    protected $table = 'monthly_profit_rates';

    protected $fillable = ['year_month', 'percentage'];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];
}
