<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'name',
        'building_rent',
        'service_charge',
        'utility_bill',
        'date',
        'auth_id'
    ];
}
