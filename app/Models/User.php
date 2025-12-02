<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Relationships
    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function incomeSources()
    {
        return $this->hasMany(IncomeSource::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
