<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'income_source_id',
        'bank_id',
        'amount',
        'currency',
        'occurred_at',
    ];

    protected $dates = ['occurred_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function source()
    {
        return $this->belongsTo(IncomeSource::class, 'income_source_id');
    }
}

