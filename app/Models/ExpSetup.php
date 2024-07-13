<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpSetup extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'cat_id',
        'exp_name',
        'date',
        'created_by',
        'status',
    ];
}
