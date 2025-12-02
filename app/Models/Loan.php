<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'person_name',
        'person_contact',
        'reason',
        'principal_amount',
        'outstanding_balance',
        'currency',
        'bank_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }
}
