<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'auth_id',
        'name',
        'phone',
        'nid_no',
        'address',
        'email',
        'balance',
        'status',
        'created_date'
    ];
}
