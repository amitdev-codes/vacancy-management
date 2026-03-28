<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use CRUDBooster;
use App\Helpers\PaymentLinker;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {csv_payment_file_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Test email to a user [csv_payment_file_id]';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        //$this->sendEmailAboutLinkage($this->argument('csv_payment_file_id'));
        PaymentLinker::sendEmailAboutLinkage($this->argument('csv_payment_file_id'));
    }

    private function sendEmailAboutLinkage($csv_payment_file_id){
        //List  those records which has been 
        $list = DB::select(DB::raw("SELECT cd.linked_application_id, va.total_amount total_amount_payable, va.total_paid_amount, va.total_amount - va.total_paid_amount remaining_amount
        , cd.receipt_date_ad,cd.receipt_number,va.token_number, cd.amount_paid receipt_amount
        , va.applied_date_ad, va.applied_date_bs
        , d.name_en designation_name_en, d.name_np designation_name_np
        , Concat(ap.first_name_en, ' ', COALESCE(ap.mid_name_en,''), ' ', ap.last_name_en) full_name_en
        , Concat(ap.first_name_np, ' ', COALESCE(ap.mid_name_np,''), ' ', ap.last_name_np) full_name_np, ap.email
        , cd.id csv_payment_file_details_id, va.applicant_id, ap.user_id
        , va.is_paid, cd.id
    FROM csv_payment_file_details cd
        INNER JOIN vacancy_apply va on cd.linked_application_id = va.id
        INNER JOIN applicant_profile ap on va.applicant_id = ap.id
        LEFT JOIN mst_designation d on va.designation_id = d.id
        LEFT JOIN vacancy_post vp on va.vacancy_post_id = vp.id
    WHERE cd.linked_application_id is not null
        AND cd.is_email_sent = 0
        AND cd.csv_payment_file_id = $csv_payment_file_id"));
        
        if(isset($list) && count($list)>0){
            $sent_ids = [];
            foreach($list as $item){
                if($item->is_paid == 1){
                    \App\Helpers\VAARS::sendEmail(['to'=>$item->email, 'data'=>$item, 'template'=>'email_after_receipt_linked_full_payment']);
                }
                else{
                    \App\Helpers\VAARS::sendEmail(['to'=>$item->email, 'data'=>$item, 'template'=>'email_after_receipt_linked_partial_payment']);
                }
                break;
                exit;
            }

        }
    }
}
