<?php

namespace App\Http\Controllers\ApplicationSettings;

use App\Http\Controllers\Controller;
use App\Traits\FilterTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class SendEmailController extends Controller
{
    use FilterTrait;

    public function viewEmail(){
        if(!empty(Request::all())){
            $data= $this->index();
        }
     return view('applicationSettings.sendEmail',compact('data'));
    }
    public function SendEmail():RedirectResponse{
        $message=Request::input('message');
        $checkbox=Request::input('checkbox');
        $mobilecheckbox=Request::input('mobileCheckbox');
        switch (Request::input('action')) {
            case 'sendEmail':
                $details['email']=$checkbox;
                $details['message']=$message;
                $job = (new \App\Jobs\SendQueueEmail($details))->delay(now()->addSeconds(2));
                dispatch($job);
                break;
            case 'sendSms':
                $details['mobile']=$mobilecheckbox;
                $details['message']=$message;
                $job = (new \App\Jobs\SendQueueSms($details))->delay(now()->addSeconds(5));
                dispatch($job);
                break;

        }
        return redirect()->route('viewEmail')->with('success', 'Mail sent Successfully');
    }

}
