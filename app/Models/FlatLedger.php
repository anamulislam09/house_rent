<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatLedger extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'agreement_id',
        'tenant_id',
        'flat_id',
        'rent',
        'service_charge',
        'utility_bill',
        'date',
    ];
}
