@extends('crudbooster::admin_template')
@section('content')

        <div >
 @if($isApplicant!='true')
        @if(CRUDBooster::getCurrentMethod() != 'getProfile' && $button_cancel)
          @if(g('return_url'))
          <p><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
          @else
          <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
          @endif
        @endif
  @endif
<?php
switch ($page_title) {
    case "Add Applicant Profile":
        $applicantProfile = "active";
        break;
    case "Edit Applicant Profile":
        $applicantProfile = "active";
        break;
    case "Add Applicant Family Information":
        $applicantFamilyInfo = "active";
        break;
    case "Edit Applicant Family Information":
        $applicantFamilyInfo = "active";
        break;
    case "Add Education Information":
        $applicantEducation = "active";
        break;
    case "Edit Education Information":
        $applicantEducation = "active";
        break;
    case "Add Training Information":
        $applicantTraining = "active";
        break;
    case "Edit Training Information":
        $applicantTraining = "active";
        break;
    case "Add Council Certificate":
        $applicantCouncil = "active";
        break;
    case "Edit Council Certificate":
        $applicantCouncil = "active";
        break;
    case "Add Privilege Group Certificate":
        $applicantPrivilege = "active";
        break;
    case "Edit Privilege Group Certificate":
        $applicantPrivilege = "active";
        break;
    case "Add Applicant Experience Info":
        $applicantExpereince = "active";
        break;
    case "Edit Applicant Experience Info":
        $applicantExpereince = "active";
        break;
    case "Add Applicant Leave Details":
        $applicantLeaveDetails = "active";
        break;
    case "Edit Applicant Leave Details":
        $applicantLeaveDetails = "active";
        break;
    case "Add Applicant Service History":
        $applicantServiceHistory = "active";
        break;
    case "Edit Applicant Service History":
        $applicantServiceHistory = "active";
        break;
    default:
        echo "";
}

$applicant_id = Request::get("applicant_id");
if (!isset($applicant_id))
    $applicant_id = $id;

if (Session::get('is_applicant') == 1) {
    $applicant_id = Session::get('applicant_id');
}
    //$applicant_id = Session::get("applicant_id");
$prefix = config('crudbooster.ADMIN_PATH');
$query = "?applicant_id=$applicant_id";

?>
    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            <strong><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> {!! $page_title or "Page Title" !!}</strong>
        </div>  -->
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li role="presentation" class="{{$applicantProfile}}"><a href="/{{$prefix}}/applicant_profile/edit/{{$applicant_id}}"><i class='fa fa-user'></i> - Profile</a></li>
                <li role="presentation" class="{{$applicantFamilyInfo}}"><a href="/{{$prefix}}/applicant_family_info/edit/{{$applicant_id}}"><i class='fa fa-group'></i> - Family Details</a></li>
                <li role="presentation" class="{{$applicantEducation}}"><a href="/{{$prefix}}/applicant_edu_info{{$query}}"><i class='fa fa-graduation-cap'></i> - Education</a></li>
                <li role="presentation" class="{{$applicantTraining}}"><a href="/{{$prefix}}/user_training_info{{$query}}"><i class='fa fa-cogs'></i> - Training</a></li>
                <li role="presentation" class="{{$applicantExpereince}}"><a href="/{{$prefix}}/applicant_exp_info{{$query}}"><i class='fa fa-book'></i> - Experience</a></li>
                <li role="presentation" class="{{$applicantCouncil}}"><a href="/{{$prefix}}/applicant_council_certificate{{$query}}"><i class='fa fa-institution'></i> - Council</a></li>
                <li role="presentation" class="{{$applicantPrivilege}}"><a href="/{{$prefix}}/applicant_privilege_certificate{{$query}}"><i class='fa fa-user-secret'></i> - Privilege Group</a></li>
                @if($isNtStaff)
                    <li role="presentation" class="{{$applicantLeaveDetails}}"><a href="/{{$prefix}}/applicant_leave_details{{$query}}"><i class='fa fa-plane'></i> - Leave Details</a></li>
                    <li role="presentation" class="{{$applicantServiceHistory}}"><a href="/{{$prefix}}/applicant_service_history{{$query}}"><i class='fa fa-folder'></i> - Service History</a></li>
                @endif
            </ul>
        </div>
        <div class="panel-body" style="padding:20px 0px 0px 0px">
            <?php
            $action = (@$row) ? CRUDBooster::mainpath("edit-save/$row->id") : CRUDBooster::mainpath("add-save");
            $return_url = ($return_url) ? : g('return_url');
            ?>
            <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action='{{$action}}'>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type='hidden' name='return_url' value='{{ @$return_url }}'/>
            <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}'/>
            <input type='hidden' name='ref_parameter' value='{{urldecode(http_build_query(@$_GET))}}'/>
            @if($hide_form)
                <input type="hidden" name="hide_form" value='{!! serialize($hide_form) !!}'>
            @endif
                    <div class="box-body" id="parent-form-area">

                        @if($command == 'detail')
                            @include("crudbooster::default.form_detail")
                        @else
                            @include("crudbooster::default.form_body")
                        @endif
                    </div><!-- /.box-body -->

                    <div class="box-footer" style="background: #F5F5F5">

                        <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-10">
                                @if($isApplicant=='true' || CRUDBooster::myPrivilegeId()==5)
                                    @if(CRUDBooster::isCreate() || CRUDBooster::isUpdate())
                                    @if($button_save && $command != 'detail')
                                    <input type="submit" name="submit" value='{{trans("crudbooster.button_save")}}' class='btn btn-success'>
                                @endif

                            @endif
                            @endif
                        </div>
                        </div>

                    </div><!-- /.box-footer-->

                    </form>

        </div>
    </div>
    </div><!--END AUTO MARGIN-->

@endsection