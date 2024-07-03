<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancedAmount extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'agreement_id',
        'inv_id',
        'tenant_id',
        'date',
        'particular',
        'deposit',
        'withdraw',
        'balance',
    ];
}
