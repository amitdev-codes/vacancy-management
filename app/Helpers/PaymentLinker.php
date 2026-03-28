<?php

namespace App\Helpers;

use DB;
use CRUDBooster;

class PaymentLinker
{
    public static $test = "";

    public static $MailSendWaitInMS = 100; // 200 Milli Second
    public static function sendLinkageEmail()
    {
        set_time_limit(300);
        var_dump("task-start-------------------------");
        //List  those records which has been
        $list = DB::select(DB::raw("SELECT cd.linked_application_id, va.total_amount total_amount_payable
            , va.total_paid_amount, va.total_amount - va.total_paid_amount remaining_amount
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
            -- AND cd.csv_payment_file_id = $csv_payment_file_id
        limit 5
            "));
        // var_dump(count($list));
        if (isset($list) && count($list) > 0) {
            $sent_ids = [];
            if (self::$MailSendWaitInMS < 1)
                self::$MailSendWaitInMS = 150;
            $log_file = "";
            foreach ($list as $item) {
                var_dump("loop-start" . \App\Helpers\VAARS::Now());
                // $email = "shakti.shrestha@gmail.com";
                $email = $item->email;
                var_dump($email);
                if ($item->is_paid == 1) {
                    VAARS::sendEmail(['to' => $email, 'data' => $item, 'template' => 'email_after_receipt_linked_full_payment']);
                    $log_file = VAARS::logSendEmail($item->user_id, "payment_link", ['to' => $email, 'data' => $item, 'template' => 'email_after_receipt_linked_full_payment']);
                } else {
                    VAARS::sendEmail(['to' => $email, 'data' => $item, 'template' => 'email_after_receipt_linked_partial_payment']);
                    $log_file = VAARS::logSendEmail($item->user_id, "payment_link", ['to' => $email, 'data' => $item, 'template' => 'email_after_receipt_linked_partial_payment']);
                }

                $send_ids[] = $item->id;
                //TODO :: log the notification email content
                var_dump("email-sent" . \App\Helpers\VAARS::Now());
                DB::table('csv_payment_file_details')
                    ->where('id', "=", $item->id)
                    ->update([
                        "link_email_log_path" => $log_file,
                        "is_email_sent" => 1,
                        "email_sent_date_ad" => \App\Helpers\VAARS::Now()
                    ]);

                usleep(1000000 * (self::$MailSendWaitInMS / 1000));
                var_dump("loop-end" . \App\Helpers\VAARS::Now());
            }
            //---
            // DB::table('csv_payment_file_details')
            //     ->whereIn('id', $send_ids)
            //     ->update([
            //         "is_email_sent" => 1,
            //         "email_sent_date_ad"=>date('Y-m-d H-i-s')
            //     ]);
            var_dump("task-END-------------------------");
        }
    }
}
