<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ApplicantTabs extends Component
{

    public  $page_title;
    public  $isNtStaff;
    public  $applicantID;
    public  $vaID;

    public function __construct($componentName,$checkNtStaff,$applicantID,$vaID)
    {
      $this->page_title=$componentName;
      $this->isNtStaff=$checkNtStaff;
      $this->applicantID=$applicantID;
      $this->vaID=$vaID;
    }

    public function render()
    {
        return view('components.applicant-tabs');
    }
}
