<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'year',
        'month',
        'exp_setup_id',
        'amount',
        'date',
        'auth_id'
    ];
}


