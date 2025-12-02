<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeSource extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'income_source_id');
    }
}
