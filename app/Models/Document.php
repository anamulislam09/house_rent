<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'auth_id',
        'tenant_id',
        'nid',
        'tin',
        'photo',
        'deed',
        'police_form'
    ];
}
