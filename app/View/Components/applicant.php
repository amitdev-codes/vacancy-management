<?php

namespace App\View\Components;

use Illuminate\View\Component;

class applicant extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public  $page_title;
    public  $isNtStaff;
    public  $applicantID;

    public function __construct($componentName,$checkNtStaff,$applicantID)
    {
        $this->page_title=$componentName;
        $this->isNtStaff=$checkNtStaff;
        $this->applicantID=$applicantID;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.applicant');
    }
}
