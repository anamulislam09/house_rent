<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'agreement_id',
        'collection_master_id',
        'inv_id',
        'tenant_id',
        'flat_id',
        'flat_rent',
        'service_charge',
        'utility_bill',
        'total_current_month_rent',
        'previous_due',
        'total_collection_amount',
        'total_collection',
        'current_due',
        'bill_setup_date',
        'collection_date',
        'created_date',
    ];
}
