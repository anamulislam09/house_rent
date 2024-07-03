<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalAgreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'tenant_id',
        'building_id',
        'advanced',
        'created_date',
        'from_date',
        'to_date',
        'duration',
        'notice_period',
        'status',
    ];
}
