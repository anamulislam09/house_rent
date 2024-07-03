<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'building_id',
        'flat_name',
        'flat_location',
        'flat_rent',
        'service_charge',
        'utility_bill',
        'date',
    ];

}
