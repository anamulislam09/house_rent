<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseVoucher extends Model
{
    use HasFactory;
    protected $fillable = [
     
        'id',
        'voucher_id',
        'month',
        'year',
        'date',
        'client_id',
        'auth_id',
        'exp_setup_id',
        'amount',
    ];
}
