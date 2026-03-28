<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentdata extends Model
{
    use HasFactory;
    protected $table = 'psp_token_payment_data';
    protected $fillable = [
        'validation_token', 'applicant_id', 'applicant_token', 'pspcode', 'appkey', 'designation_id',
        'counter_code', 'amount', 'expiry_date_time', 'created_at',
    ];
}
