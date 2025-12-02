<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    protected $dates = ['occurred_at'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
