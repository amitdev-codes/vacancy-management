<?php

namespace App\Helpers;

use App;
use Carbon\Carbon;
use CRUDBooster;
use DateTimeZone;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class VAARS
{
    public static function sendApplicantEmail($config = [])
    {
        $to = $config['to'];
        $data = $config['data'];
        $template = $config['template'];

        //  var_dump($config);  exit;

        $admit_card_path = 'admit_card/' . $data->vacancy_post_id . "/" . $data->token_number . "_AdmitCard" . ".html";
        $admit_card_pdf_path = 'admit_card/' . $data->vacancy_post_id . "/" . $data->token_number . "_AdmitCard" . ".pdf";
        $files[] = public_path('pdf') . '/' . $admit_card_pdf_path;

        VAARS::sendEmail(['attachments' => $files, 'to' => $to, 'data' => $data, 'template' => $template]);
        DB::table('admit_card_status')
            ->where(['vacancy_post_id' => $data->vacancy_post_id, 'token_number' => $data->token_number, 'applicant_id' => $data->applicant_id])
            ->update(['status' => 1]);


    }
    public static function applicantPdfGenerate($config = [])
    {

        $to = $config['to'];
        $data = $config['data'];
        $template = $config['template'];

        // var_dump($config);  exit;

        $admit_card_path = 'admit_card/' . $data->vacancy_post_id . "/" . $data->token_number . "_AdmitCard" . ".html";
        $admit_card_pdf_path = 'admit_card/' . $data->vacancy_post_id . "/" . $data->token_number . "_AdmitCard" . ".pdf";
        $file = public_path('storage') . '/' . $admit_card_path;
        echo $file;
        if (File::exists($file)) {
            echo $file;
            $file_pdf = public_path('pdf') . '/' . $admit_card_pdf_path;
            if (File::exists($file_pdf)) {
                File::delete($file_pdf);
            }
            $html = url('/') . Storage::url($admit_card_path);
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadFile($html);
            $pdf->save($file_pdf);
        }

        DB::table('admit_card_status')->insert(
            ['vacancy_post_id' => $data->vacancy_post_id, 'token_number' => $data->token_number, 'applicant_id' => $data->applicant_id, 'html_path' => $admit_card_path, 'status' => 0]
        );
    }

    public static function sendEmail($config = [])
    {
        if (env("MAIL_TEST", false) == true) {
            $config["to"] = env("MAIL_TEST_RECEIVER", "shakti.shrestha@gmail.com");
        }
        return CRUDBooster::sendEmail($config);
    }
    public static function logSendEmail($user_id, $email_type, $config = [])
    {
        $to = $config['to'];
        $data = $config['data'];
        $template = $config['template'];

        $template = CRUDBooster::first('cms_email_templates', ['slug' => $template]);
        $html = $template->content;
        foreach ($data as $key => $val) {
            $html = str_replace('[' . $key . ']', $val, $html);
            $template->subject = str_replace('[' . $key . ']', $val, $template->subject);
        }

        //save the email content
        $path = uniqid("uploads/$user_id/$email_type-", true) . ".html";
        Storage::put($path, $html);
        return $path;
        //File::
    }

    public static function admitcardSendEmail($user_id, $email_type, $config = [])
    {
        $to = $config['to'];
        $data = $config['data'];
        $template = $config['template'];

        $template = CRUDBooster::first('cms_email_templates', ['slug' => $template]);
        $html = $template->content;
        foreach ($data as $key => $val) {
            $html = str_replace('[' . $key . ']', $val, $html);
            $template->subject = str_replace('[' . $key . ']', $val, $template->subject);
        }

        //save the email content
        $path = uniqid("uploads/$user_id/$email_type-", true) . ".html";
        Storage::put($path, $html);
        return $path;
        //File::
    }

    public static function CDate($dateStr)
    {
        return Carbon::parse($dateStr); //->format('Y-m-d');
    }
    public static function DateFormatted($dateStr)
    {
        return Carbon::parse($dateStr)->format('Y-m-d');
    }

    public static function Today()
    {
        return Carbon::now(new DateTimeZone('Asia/Kathmandu'))->format('Y-m-d');
    }
    public static function Now()
    {
        return Carbon::now(new DateTimeZone('Asia/Kathmandu'))->toDateTimeString();
    }
    public static function NowObj()
    {
        return Carbon::now(new DateTimeZone('Asia/Kathmandu'));
    }

    public static function prepareExcel($fileName, $data)
    {
        ob_end_clean();
        ob_start();

        foreach ($data as $key => $value) {
            $data[$key] = (array) $value;
        }

        Excel::create($fileName, function ($excel) use ($data) {
            $excel->setTitle('sample');
            $excel->sheet('sample', function ($sheet) use ($data) {
                $sheet->with($data);
            });
        })->download('xls');
        ob_flush();
    }

    public static function get_nep($eng_str)
    {
        $replace = array("१", "२", "३", "४", "५", "६", "७", "८", "९", "०");
        $find = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $nep_str = str_replace($find, $replace, $eng_str);
        return $nep_str;
    }

    public static function shout(string $string)
    {
        return strtoupper($string);
    }
}
