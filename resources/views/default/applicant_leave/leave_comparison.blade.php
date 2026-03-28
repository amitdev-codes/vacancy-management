@extends('layouts.archive_admin_template')
@section('content')
<style>
    .foo {
        width: 20px;
        height: 20px;
        margin: 5px;
        border: 1px solid rgba(0, 0, 0, .2);
    }

    .matched {
        background: yellowgreen;
    }

    .mistakes {
        background: burlywood;
    }

    .only_in_erp {
        background: rosybrown;
    }

    .missing_in_erp {
        background: cadetblue;
    }

    .mistakes_data {
        color: red;
    }
</style>
@php
switch ($page_title) {
case "Add Applicant Profile":
$applicantProfile="active";
break;
case "Edit Applicant Profile":
$applicantProfile="active";
break;
case "Add Applicant Family Information":
$applicantFamilyInfo="active";
break;
case "Edit Applicant Family Information":
$applicantFamilyInfo="active";
break;
case "Add Education Information":
$applicantEducation="active";
break;
case "Edit Education Information":
$applicantEducation="active";
break;
case "Add Training Information":
$applicantTraining="active";
break;
case "Edit Training Information":
$applicantTraining="active";
break;
case "Add Council Certificate":
$applicantCouncil="active";
break;
case "Edit Council Certificate":
$applicantCouncil="active";
break;
case "Add Privilege Group Certificate":
$applicantPrivilege="active";
break;
case "Edit Privilege Group Certificate":
$applicantPrivilege="active";
break;
case "Add Applicant Experience Info":
$applicantExpereince="active";
break;
case "Edit Applicant Experience Info":
$applicantExpereince="active";
break;

case "Add Applicant Leave Detail":
$applicantLeaveDetails="active";
break;

default:
echo "";
}

$applicant_id = Request::get("applicant_id");
if(!isset($applicant_id))
$applicant_id = $row->user_id;
if(!isset($applicant_id))
$applicant_id=$row->applicant_id;

if(Session::get('is_applicant') == 1){
$applicant_id = Session::get('applicant_id');
}
$prefix = config('crudbooster.ADMIN_PATH');
$query = "?applicant_id=$id&va_id=$va_id";
@endphp

<div class="panel panel-default">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li role="presentation" class="{{$applicantProfile}}"><a
                    href="/{{$prefix}}/applicant_profile/archive/{{$va_id}}"><i class='fa fa-user'></i> - Profile</a></li>
            <li role="presentation" class="{{$applicantFamilyInfo}}"><a
                    href="/{{$prefix}}/applicant_family_info/archive/{{$va_id}}"><i class='fa fa-group'></i> - Family
                    Details</a></li>
            <li role="presentation" class="{{$applicantEducation}}"><a
                    href="/{{$prefix}}/applicant_edu_info{{$query}}"><i class='fa fa-book'></i> - Education</a></li>
            <li role="presentation" class="{{$applicantTraining}}"><a
                    href="/{{$prefix}}/user_training_info{{$query}}"><i class='fa fa-book'></i> - Training</a></li>
            <li role="presentation" class="{{$applicantExpereince}}"><a
                    href="/{{$prefix}}/applicant_exp_info{{$query}}"><i class='fa fa-book'></i> - Experience</a></li>
            <li role="presentation" class="{{$applicantCouncil}}"><a
                    href="/{{$prefix}}/applicant_council_certificate{{$query}}"><i class='fa fa-institution'></i> -
                    Council</a></li>
            <li role="presentation" class="{{$applicantPrivilege}}"><a
                    href="/{{$prefix}}/applicant_privilege_certificate{{$query}}"><i class='fa fa-user-secret'></i> -
                    Privilege Group</a></li>

            @if($isNtStaff||(CRUDBooster::myPrivilegeId() == '1') || (CRUDBooster::myPrivilegeId() == '2'))
            <li role="presentation" class="{{$applicantLeaveDetails}}"><a
                    href="/{{$prefix}}/applicant_leave_details{{$query}}"><i class='fa fa-plane'></i> - Leave Details</a>
            </li>

            <li role="presentation" class="{{$applicantPrivilege}}"><a
                    href="/{{$prefix}}/applicant_service_history{{$query}}"><i class='fa fa-user-secret'></i> - Service
                    History</a></li>
            @endif
        </ul>
    </div>
    <div class="panel-body" style="padding:20px 0px 0px 0px">
        @if($index_statistic)
        <div id='box-statistic' class='row'>
            @foreach($index_statistic as $stat)
            <div class="{{ ($stat['width'])?:'col-sm-3' }}">
                <div class="small-box bg-{{ $stat['color']?:'red' }}">
                    <div class="inner">
                        <h3>{{ $stat['count'] }}</h3>
                        <p>{{ $stat['label'] }}</p>
                    </div>
                    <div class="icon">
                        <i class="{{ $stat['icon'] }}"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(!is_null($pre_index_html) && !empty($pre_index_html))
        {!! $pre_index_html !!}
        @endif

        @if($parent_table)
        <div class="box box-default">
            <div class="box-body table-responsive no-padding">
                <table class='table table-bordered'>
                    <tbody>
                        <tr class='active'>
                            <td colspan="2"><strong><i class='fa fa-bars'></i>
                                    {{ ucwords(urldecode(g('label'))) }}</strong></td>
                        </tr>
                        @foreach(explode(',',urldecode(g('parent_columns'))) as $c)
                        <tr>
                            <td width="25%"><strong>
                                    @if(urldecode(g('parent_columns_alias')))
                                    {{explode(',',urldecode(g('parent_columns_alias')))[$loop->index]}}
                                    @else
                                    {{  ucwords(str_replace('_',' ',$c)) }}
                                    @endif
                                </strong></td>
                            <td> {{ $parent_table->$c }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="box">
            <div class="box-header"></div>
            <div class="box-body table-responsive no-padding">
                @include("crudbooster::default.table")
            </div>
        </div>

        @if(!is_null($post_index_html) && !empty($post_index_html))
        {!! $post_index_html !!}
        @endif
    </div>
</div>
<style>
    td.notmatched {
        font-weight: bold;
        color: darkred;
    }
</style>
@if(CRUDBooster::myPrivilegeId()==1 || CRUDBooster::myPrivilegeId()==5)
   <div class="box box-default">
       <div class="box-body table-responsive no-padding">
           <h4 style="color: saddlebrown;text-align:center; font-weight: bolder;">ERP Data</h4>
               <table id="table_dashboard" class="table table-hover table-striped table-bordered">
                   <thead style="color:  rebeccapurple;">
                       <tr class="active">
                           <th width="1%">No.</th>
                           <th width="auto">Emp No </th>
                           <th width="auto">Leave Type </th>
                           <th width="auto">Date From Ad</th>
                           <th width="auto">Date To Ad </th>
                           <th width="auto">Imported Mode</th>
                           <th width="auto">Imported At</th>
                           <th width="auto">Imported By</th>
                           <th width="auto">Erp File Uploads</th>
                           <th width="auto">Remarks</th>
                       </tr>
                   </thead>
                   <tbody>
                   @if($erp_data)
                       @foreach($erp_data as $key => $erp)
                       <tr>
                           <td>{{$loop->iteration}} </td>
                           <td>{{$erp->emp_no}}</td>
                           <td>{{$erp->leave_type}}</td>
                           <td>{{$erp->date_from_ad}}</td>
                           <td>{{$erp->date_to_ad}}</td>
                           <td>{{$erp->imported_mode}}</td>
                           <td>{{$erp->imported_at}}</td>
                           <td>{{$erp->imported_by}}</td>
                           <td>{{$erp->erp_file_uploads_id}}</td>
                           <td>{{$erp->remarks}}</td>
                       </tr>
                       @endforeach
                    @endif
                   </tbody>
               </table>
       </div>
   </div>

<!-- merged data div -->
@if($merged_data)
    <div class="box box-default">
        <div class="box-body table-responsive no-padding table-editable">
            @if($merged_data[0]->is_approved==0)
            <div class="align-left" style="text-align: right;">
                <button class="btn btn-primary" style="margin:5px;margin-bottom:-32px"><a
                        href="remerge_data_leave/{{$id}}/{{$va_id}}"
                        onclick="return confirm('Are you sure to remerged data?')" style="color:white">Remerge</a>
                 </button>
            </div>
            @endif
            <h4 style="color: saddlebrown;text-align:center;font-weight: bolder;">Merged Data</h4>
            <table id="table_dashboard" class="table table-hover table-striped table-bordered">
                <thead style="color:  rebeccapurple;">
                    <tr class="active">
                        <th width="1%">No.</th>
                        <th width="auto">Emp No </th>
                        <th width="auto">Leave Type </th>
                        <th width="auto">Date From Bs</th>
                        <th width="auto">Date To Bs </th>
                        <th width="auto">Date From Ad</th>
                        <th width="auto">Date To Ad</th>
                        <th width="auto">File Uploads</th>
                        <th width="auto">Remarks</th>
                        <th width="auto">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($merged_data as $key => $merged_data)
                    @if($merged_data->flag=="mistakes")
                    <tr style="background:burlywood">
                        @elseif($merged_data->flag=="correct")
                    <tr style="background:yellowgreen">
                        @elseif($merged_data->flag=="only_in_erp")
                    <tr style="background:rosybrown">
                        @else
                    <tr style="background:cadetblue">
                        @endif
                        <td>{{$loop->iteration}} </td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'emp_no') !== false?'darkred':''}}">
                            {{$merged_data->emp_no}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'leave_type_id') !== false?'darkred':''}}">
                            {{$merged_data->leave_type}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'date_from_bs') !== false?'darkred':''}}">
                            {{$merged_data->date_from_bs}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'date_to_bs') !== false?'darkred':''}}">
                            {{$merged_data->date_to_bs}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'date_from_ad') !== false?'darkred':''}}">
                            {{$merged_data->date_from_ad}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'date_to_ad') !== false?'darkred':''}}">
                            {{$merged_data->date_to_ad}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'file_uploads') !== false?'darkred':''}}">
                            {{$merged_data->file_uploads}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'remarks') !== false?'darkred':''}}">
                            {{$merged_data->remarks}}</td>
                        <td>
                            @if($merged_data->is_approved==0)
                            <a class="btn btn-xs btn-success btn-edit" title="Edit Data"
                                href="/app/merged_data_leave/edit/{{$merged_data->id}}">
                                <i class="fa fa-pencil"></i></a>
    
                            @endif
                            @if($merged_data->is_approved==0)
                            <a class="btn btn-xs btn-danger" title="Delete Data"
                                href="/app/merged_data_leave/delete/{{$merged_data->id}}"
                                onclick="return confirm('Are you sure to Delete merged data?')">
                                <i class="fa fa-trash-o"></i></a>
                            @endif
                        </td>
                    </tr>
    
                    @endforeach
                </tbody>
            </table>
     
          <div class="col-xs-2">
              <div class="foo matched"></div>
              <h5 style="margin-left:30px;margin-top:-23px">Matched</h5>
          </div>
          <div class="col-xs-2">
              <div class="foo mistakes"></div>
              <h5 style="margin-left:30px;margin-top:-23px">Mismatched</h5>
          </div>
          <div class="col-xs-2">
              <div class="foo only_in_erp"></div>
              <h5 style="margin-left:30px;margin-top:-23px">Only In ERP</h5>
          </div>
          <div class="col-xs-2">
              <div class="foo missing_in_erp"></div>
              <h5 style="margin-left:30px;margin-top:-23px">Missing in ERP</h5>
          </div>
   
        @if($merged_data->is_verified==0)
        <div style="margin: 20px;text-align:right;">
            <button class="btn btn-info"><a href="verify_merged_data_leave/{{$id}}/{{$va_id}}"
                    onclick="return confirm('Are you sure to Verify merged data?')" style="color:white">Verify</a></button>
        </div>
        @endif
       @if($merged_data->is_verified==1 && $merged_data->is_approved==0 )
       <div style="margin: 10px;text-align:right;">
           <button class="btn btn-info"><a href="approve_merged_data_leave/{{$id}}/{{$va_id}}"
                   onclick="return confirm('Are you sure to approve merged data?')" style="color:white">Approve</a></button>
       </div>
       @endif
    </div>
</div>
       @if($merged_data->is_verified==1)
       <div class="box-body table-responsive no-padding">
           <table id="table_dashboard" class="table table-hover table-striped table-bordered">
               <thead style="color:  rebeccapurple;">
                   <tr class="active">
                       <th width="auto">Verified by</th>
                       <th width="auto">Verified on </th>
                       <th width="auto">Approved by </th>
                       <th width="auto">Approved on</th>
                   </tr>
               </thead>
               <?php $i=1; ?>
               <tbody>
       
               </tbody>
               <tr>
                   <td>{{$merged_data->verified_by}}</td>
                   <td>{{$merged_data->verified_on}}</td>
                   <td>{{$merged_data->approved_by}}</td>
                   <td>{{$merged_data->approved_on}}</td>
               </tr>
           </table>
       </div>
       @endif

@endif
@endif
@endsection