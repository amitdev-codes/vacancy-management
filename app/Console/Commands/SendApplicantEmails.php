<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use CRUDBooster;
use App\Helpers\VAARS;
use DB;


class SendApplicantEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:sendApplicant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Test email to a Applicant';

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
            //  echo 'Im here';  
         $admitCardList = DB::table('admit_card_status')
         ->select('admit_card_status.*','vw_applicant_details.email as email','vw_applicant_details.applicant_name as applicant_name','mst_designation.name_en as name_en','vacancy_post.id as vacancy_post_id')        
         ->leftJoin('vw_applicant_details', array('vw_applicant_details.applicant_id'=> 'admit_card_status.applicant_id'))
         ->leftJoin('vacancy_post', array('vacancy_post.id'=> 'admit_card_status.vacancy_post_id'))
         ->leftJoin('mst_designation', array('vacancy_post.designation_id'=> 'mst_designation.id'))
         ->get();
        

        $a = 1;
         if(isset($admitCardList) && count($admitCardList)>0){
            foreach($admitCardList as $item){
               
                echo $a.'-';
                // VAARS::sendApplicantEmail(array('to'=>$item->email, 'data'=>$item, 'template'=>'admit_card_email'));
                $admit_card_path = 'admit_card/' . $item->vacancy_post_id . "/" . $item->token_number . "_AdmitCard" . ".html";
                $admit_card_pdf_path = 'admit_card/' . $item->vacancy_post_id . "/" . $item->token_number . "_AdmitCard" . ".pdf";
                $files[] = public_path('pdf') . '/' . $admit_card_pdf_path;
                
                CRUDBooster::sendEmailQueue(['to' =>$item->email,'data' => $item,'template' => 'admit_card_email','attachments'=>$files]);
              $a++; 
             }  
        }    

    //    echo'<pre>';print_r($admitCardList);exit;
    //   $sql='SELECT DISTINCT ve.vacancy_post_id,md.name_en,va.token_number,vad.email,vad.applicant_name,vad.applicant_id from vacancy_exam ve 
    //   left join vacancy_apply va on va.id= ve.vacancy_apply_id
    //   left join vw_applicant_details vad on vad.applicant_id=ve.applicant_id
    //   left join mst_designation md on md.id=ve.designation_id
    //   ORDER BY ve.vacancy_post_id';
    //   $list=DB::select(DB::raw($sql));       

        //  var_dump($list);exit; 
        // $a= 1;
        // if(isset($list) && count($list)>0){
        //     foreach($list as $item){
        //         // echo 'Step-'.$a;
        //         // VAARS::sendApplicantEmail(array('to'=>$item->email, 'data'=>$item, 'template'=>'admit_card_email'));
               
        //         // $a++;

        //         $admit_card_path = 'admit_card/' . $item->vacancy_post_id . "/" . $admitCardList->token_number . "_AdmitCard" . ".html";
        //         $admit_card_pdf_path = 'admit_card/' . $admitCardList->vacancy_post_id . "/" . $admitCardList->token_number . "_AdmitCard" . ".pdf";
        //         $files[] = public_path('pdf') . '/' . $admit_card_pdf_path;
                
        //         CRUDBooster::sendEmail(['to' =>$admitCardList->email,'data' => $admitCardList,'template' => 'admit_card_email','attachments'=>$files]);
        //      }  
        // }          
       
    
    }
}
