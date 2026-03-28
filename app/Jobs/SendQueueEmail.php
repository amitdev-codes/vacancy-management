<?php

namespace App\Jobs;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['message']=$this->details['message'];
        $emails=$this->details['email'];
        // dd($emails);
        // $emails[0]='amitdev67@gmail.com';
//        $chunks=array_chunk($emails,5);
//          foreach ($chunks as $chunk){
//              $applicantEmail=$chunk;
//              CRUDBooster::sendEmail(['to' => $applicantEmail, 'data' => $data, 'template' => 'custom_bulk_email']);
//        }

        foreach ($emails as $chunk){
              $applicantEmail=$chunk;
              CRUDBooster::sendEmail(['to' => $applicantEmail, 'data' => $data, 'template' => 'custom_bulk_email']);
        }
    }
}
