<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $id)
 */
class WebPaymentLog extends Model
{
    use HasFactory;
    protected $table = 'web_payment_log';
    protected $fillable = [
        'psp_id',
        'applicant_id',
        'applicant_name',
        'email',
        'mobile',
        'applicant_token',
        'notice_no',
        'advertisement_no',
        'applied_date_ad',
        'applied_date_bs',
        'applied_group',
        'total_amount',
        'eservice_trans_ref_code',
        'created_at',
        'psp_code',
        'psp_product',
        'process_step',
        'fiscal_year_id',
    ];
}
