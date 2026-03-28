<?php

namespace App\Jobs;

use App\Helpers\SMShelper;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendQueueSms implements ShouldQueue
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
        $message=$this->details['message'];
        $mobile=$this->details['mobile'];
        foreach ($mobile as $chunk){
            $mobile = "977" . $chunk;
            SMShelper::sendsms($mobile, $message);
        }
    }
}
