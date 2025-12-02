<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}

