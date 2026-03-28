<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tokenpaymentlog extends Model
{
    use HasFactory;
    protected $table = 'psp_token_payment_logs';
    protected $fillable = [
        'ipaddress', 'useragent', 'psp_id', 'applicant_id', 'applicant_name',
        'applicant_token', 'mobile', 'applied_group', 'total_amount',
        'process_step1', 'validation_pspcode', 'validation_key', 'validation_applicant_token',
        'validation_status', 'validation_message', 'validation_time', 'validation_unique_generated_token', 'created_at',
    ];
}
