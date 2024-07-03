<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalAgreementDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'rental_agreement_id',
        'flat_id',
    ];
}
