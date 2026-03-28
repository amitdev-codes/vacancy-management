@extends('layouts.applicant_admin_template')
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
.mistakes_data{
  color: red;
}
</style>
<div>

  <x-applicant-tabs></x-applicant-tabs>
  @php
  $applicant_id = Request::get("applicant_id");
  @endphp
  @if(!isset($applicant_id))
       @php
         $applicant_id = $id;
       @endphp
  @endif
  @if(Session::get('is_applicant') == 1)
      @php
      $applicant_id = Session::get('applicant_id');
      @endphp
  @endif
 @php
  $prefix = config('crudbooster.ADMIN_PATH');
  $query = "?applicant_id=$applicant_id";
 @endphp

  <div class="panel panel-default">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li role="presentation" class="{{$applicantProfile}}"><a href="/{{$prefix}}/applicant_profile/archive/{{$va_id}}"><i class='fa fa-user'></i> - Profile</a></li>
            <li role="presentation" class="{{$applicantFamilyInfo}}"><a href="/{{$prefix}}/applicant_family_info/archive/{{$va_id}}"><i class='fa fa-group'></i> - Family Details</a></li>
            <li role="presentation" class="{{$applicantEducation}}"><a href="/{{$prefix}}/applicant_edu_info{{$query}}"><i class='fa fa-book'></i> - Education</a></li>
            <li role="presentation" class="{{$applicantTraining}}"><a href="/{{$prefix}}/user_training_info{{$query}}"><i class='fa fa-book'></i> - Training</a></li>
            <li role="presentation" class="{{$applicantExpereince}}"><a href="/{{$prefix}}/applicant_exp_info{{$query}}"><i class='fa fa-book'></i> - Experience</a></li>
            <li role="presentation" class="{{$applicantCouncil}}"><a href="/{{$prefix}}/applicant_council_certificate{{$query}}"><i class='fa fa-institution'></i> - Council</a></li>
            <li role="presentation" class="{{$applicantPrivilege}}"><a href="/{{$prefix}}/applicant_privilege_certificate{{$query}}"><i class='fa fa-user-secret'></i> - Privilege Group</a></li>
            @if($isNtStaff)
            <li role="presentation" class="{{$applicantLeaveDetails}}"><a href="/{{$prefix}}/applicant_leave_details{{$query}}"><i class='fa fa-plane'></i> - Leave Details</a>
            </li>
                <li role="presentation" class="{{$applicantService}}"><a href="/{{$prefix}}/applicant_service_history{{$query}}"><i class='fa fa-user-secret'></i> - Service History</a></li>
            @endif
        </ul>

    </div>

    <div class="panel-body" style="padding:20px 0px 0px 0px">
      @if($index_statistic)
      <div id='box-statistic' class='row'>
      @foreach($index_statistic as $stat)
          <div  class="{{ ($stat['width'])?:'col-sm-3' }}">
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
              <td colspan="2"><strong><i class='fa fa-bars'></i> {{ ucwords(urldecode(g('label'))) }}</strong></td>
            </tr>
            @foreach(explode(',',urldecode(g('parent_columns'))) as $c)
            <tr>
              <td width="25%"><strong>
               @if(urldecode(g('parent_columns_alias')))
              {{explode(',',urldecode(g('parent_columns_alias')))[$loop->index]}}
              @else
              {{  ucwords(str_replace('_',' ',$c)) }}
               @endif
              </strong></td><td> {{ $parent_table->$c }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    <div class="box">
        <div class="box-header">
        @if($isApplicant!='true')
        @if($page_title=='Applicant Service History')
        <a href="export_service_history/{{$va_id}}" target="_blank"><button type="button" class="btn btn-primary">Export Service History</button></a>
        @endif
        @endif
            @if($isApplicant=='true')
              @if($table!="applicant_training_info")

            <a href="{{CRUDBooster::adminPath()}}/{{$table}}/add" id="btn_add_new_data" class="btn btn-sm btn-success" title="Add Data">
                <i class="fa fa-plus-circle"></i> Add Data
            </a>
            @else
            <a href="{{CRUDBooster::adminPath()}}/user_training_info/add" id="btn_add_new_data" class="btn btn-sm btn-success" title="Add Data">
                <i class="fa fa-plus-circle"></i> Add Data
            </a>
            @endif
            @endif
            <br style="clear:both"/>
        </div>
        <div class="box-body table-responsive no-padding">
            @include("crudbooster::default.table")
        </div>
    </div>

   @if(!is_null($post_index_html) && !empty($post_index_html))
       {!! $post_index_html !!}
   @endif

    </div>
  </div>
</div>
<style>
    td.notmatched{
        font-weight:bold;
        color:darkred;
    }
</style>
@if(CRUDBooster::myPrivilegeId()==1|| CRUDBooster::myPrivilegeId()==5)
@if($erp_data)

<!--END AUTO MARGIN-->

<!-- erp data div -->
<div class="box box-default">
<div class="box-body table-responsive no-padding">
  <h4 align="center" style="color: saddlebrown;font-weight: bolder;">ERP Data</h3>
  
  <table id="table_dashboard" class="table table-hover table-striped table-bordered">
                    <thead style="color:  rebeccapurple;">
                    <tr class="active">
                     <th width="1%">No.</th>
                     <th width="auto">Office </th>
                     <th width="auto">Designation </th>
                     <th width="auto">Service Group </th>
                     <th width="auto">Date From </th>
                     <th width="auto">Date To</th>
                     <th width="auto">Incharge </th>
                     <th width="auto">Incharge from </th>
                     <th width="auto">Incharge to </th>
                     <!-- <th width="auto">Currently Working </th> -->
                     <th width="auto">Seniority date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                   
                   
                    @foreach($erp_data as $key => $erp_data)
                      <tr>
                        <td>{{$i++}} </td>
                        <td>{{$erp_data->working_office}}</td>
                        <td>{{$erp_data->designation}}</td>
                        <td>{{$erp_data->service_group}}</td>
                        <td>{{$erp_data->date_from_bs}}</td>
                        <td>{{$erp_data->date_to_bs}}</td>
                        <td>{{$erp_data->is_office_incharge}}</td>
                        <td>{{$erp_data->incharge_date_from_bs}}</td>
                        <td>{{$erp_data->incharge_date_to_bs}}</td>
                        <!-- <td>{{$erp_data->is_current}}</td> -->
                        <td>{{$erp_data->seniority_date_bs}}</td>
                    </tr>
                   
                    @endforeach
                    </tbody>
                   
                  </table>
  </div>
</div>

@if(count($merged_data)>0)
<!-- merged data div -->
<div class="box box-default">
<div class="box-body table-responsive no-padding table-editable">
@if($merged_data[0]->is_approved==0)
<div class="align-left" align="right">
<button class="btn btn-primary" style="margin:5px;margin-bottom:-32px"><a href="remerge_data/{{$id}}/{{$va_id}}"  onclick="return confirm('Are you sure to remerged data?')" style="color:white">Remerge</a></button>
</div> 
@endif
  <h4 align="center" style="color: saddlebrown;font-weight: bolder;">Merged Data</h3>
  
  <table id="table_dashboard" class="table table-hover table-striped table-bordered">
                    <thead style="color:  rebeccapurple;">
                    <tr class="active">
                      <th width="1%">No.</th>
                     <th width="18%">Office </th>
                     <th width="auto">Designation </th>
                     <th width="auto">Service Group </th>
                     <th width="auto">Date From </th>
                     <th width="auto">Date To</th>
                     <th width="auto">Incharge </th>
                     <th width="auto">Incharge from </th>
                     <th width="auto">Incharge to </th>
                     <!-- <th width="auto">Currently Working </th> -->
                     <th width="auto">Seniority date</th> 
                     <th width="10px">Action</th>
                     
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                   
                   
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
                        <td>{{$i++}}</td>
                        
                        <td style="color:{{strpos($merged_data->mismatched_key, 'working_office') !== false?'darkred':''}}">{{$merged_data->working_office}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'designation') !== false?'darkred':''}}">{{$merged_data->designation}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'service_group') !== false?'darkred':''}}">{{$merged_data->service_group}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'date_from_bs') !== false?'darkred':''}}">{{$merged_data->date_from_bs}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'date_to_bs') !== false?'darkred':''}}">{{$merged_data->date_to_bs}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'is_office_incharge') !== false?'darkred':''}}">{{$merged_data->is_office_incharge}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'incharge_date_from_ad') !== false?'darkred':''}}"> {{$merged_data->incharge_date_from_bs}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'incharge_date_to_bs') !== false?'darkred':''}}">{{$merged_data->incharge_date_to_bs}}</td>
                        <td style="color:{{strpos($merged_data->mismatched_key, 'seniority_date_bs') !== false?'darkred':''}}">{{$merged_data->seniority_date_bs}}</td>
                        <td >
                        @if($merged_data->is_approved==0)
                        <a class="btn btn-xs btn-success btn-edit" title="Edit Data" href="/app/merged_data/edit/{{$merged_data->id}}">
                        <i class="fa fa-pencil"></i></a>
                        
                        @endif
                        @if($merged_data->is_approved==0)
                        <a class="btn btn-xs btn-danger" title="Delete Data" href="/app/merged_data/delete/{{$merged_data->id}}" onclick="return confirm('Are you sure to Delete merged data?')">
                        <i class="fa fa-trash-o"></i></a>
                        
                        @endif
                        </td>
                    </tr>
                   
                    @endforeach
                    </tbody>
                   
                  </table>
  
    <div>
        <div class="col-xs-2">
        <div class="foo matched"></div> <h5 style="margin-left:30px;margin-top:-23px">Matched</h5>
        </div>
        <div class="col-xs-2">
        <div class="foo mistakes"></div> <h5 style="margin-left:30px;margin-top:-23px">Mismatched</h5>
        </div>
        <div class="col-xs-2">
        <div class="foo only_in_erp"></div> <h5 style="margin-left:30px;margin-top:-23px">Only In ERP</h5>
        </div>
        <div class="col-xs-2">
        <div class="foo missing_in_erp"></div> <h5 style="margin-left:30px;margin-top:-23px">Missing in ERP</h5>
        </div>
    </div> 
    @if($merged_data->is_verified==0)
    <div align="right" style="margin: 20px;">
    
    <button class="btn btn-info"><a href="verify_merged_data/{{$id}}/{{$va_id}}"  onclick="return confirm('Are you sure to Verify merged data?')" style="color:white">Verify</a></button>
    </div>
    @endif
    @if($merged_data->is_verified==1 && $merged_data->is_approved==0 )
    <div align="right" style="margin: 10px;">

    <button class="btn btn-info"><a href="approve_merged_data/{{$id}}/{{$va_id}}"  onclick="return confirm('Are you sure to approve merged data?')" style="color:white">Approve</a></button>
   
    
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
@endif
@endsection
