<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyPaymentDetail extends Model
{
    use HasFactory;
    protected $table = 'vacancy_payment_details';
    protected $fillable = [
        'token_number',
        'applicant_id',
        'amount_paid',
        'txn_id',
    ];
}
