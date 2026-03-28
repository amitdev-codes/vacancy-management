@extends('crudbooster::admin_template')

@section('content')
<style>.button_action a.btn{width:24px; margin:1px;} th i{display:none !important;}</style>

<div class="box">
        <div class="box-header">
                            <div class="pull-left">
                    <div class="selected-action" style="display:inline-block;position:relative;">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-check-square-o"></i> Bulk Actions
                            <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">
                                                            <li><a href="javascript:void(0)" data-name="delete" title="Delete Selected"><i class="fa fa-trash"></i> Delete Selected</a></li>


                        </ul><!--end-dropdown-menu-->
                    </div><!--end-selected-action-->
                </div><!--end-pull-left-->
                        <div class="box-tools pull-right" style="position: relative;margin-top: -5px;margin-right: -10px">


                <form method="get" style="display:inline-block;width: 260px;" action="/vacancy_applicants_search">
                    <div class="input-group">
                        <input type="text" name="q" value="" class="form-control input-sm pull-right" placeholder="Search">
                        <input type="hidden" name="page" value="6">
                        <div class="input-group-btn">
                 <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <br style="clear:both">

        </div>
        <div class="box-body table-responsive no-padding" style='height: 560px;  overflow: scroll;'>
            <!-- start of amit changes -->
                   <div class="col-md-12">
                <div class="card">
                   <div class="card-body">
                   <!-- end of amit changes -->
                  <form id="form-table" method="post" action="http://vaars.test/app/applicant_profile/action-selected">
                  <input type="hidden" name="button_name" value="">
                  <input type="hidden" name="_token" value="P7frwxqaFQv4IPfaxansv8IR15zzMfuCvsQNIqXu">
                  <table id="table_dash" class="table table-hover table-striped table-bordered ">
                    <thead>
                    <tr class="active">

                        <th width="100px" style="text-align:left; min-width:110px">Action</th>
                        <th width="1%">No.</th>
                        <th width="auto"> <a href="/app/vacancy_applicants" title="Click to sort ascending">ID <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Ad No  <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Designation  <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Published&nbsp;/<br>Last(B.S.) <i class="fa fa-sort"></i></a></th>
                        <!-- <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Published B.S. <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Last B.S. <i class="fa fa-sort"></i></a></th> -->
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Applicant ID <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Photo <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Applicant Name <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Mobile No. <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Applied&nbsp;B.S.  <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Token_No&nbsp;/<br>Total Fee  <i class="fa fa-sort"></i></a></th>
                         <!-- <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Token&nbsp;No &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Total Fee &nbsp; <i class="fa fa-sort"></i></a></th> -->
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Receipt No <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Apanga(H) ">H <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Remote village(R)">R<i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Applied group <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Rejected  <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/vacancy_applicants" title="Click to sort ascending">Cancelled  <i class="fa fa-sort"></i></a></th>

                    </tr>
                </thead>

        @foreach($data1 as $data)
                <tbody>
                      <tr>
                              <td>
                                    <div class="button_action" style="text-align:left"><a class="btn btn-xs btn-danger" title="" onclick="
                                    swal({
                                    title: &quot;Reject&quot;,
                                    text: &quot;Are you sure you want to reject?&quot;,
                                    type: &quot;warning&quot;,
                                    showCancelButton: true,
                                    confirmButtonColor: &quot;#DD6B55&quot;,
                                    confirmButtonText: &quot;Yes!&quot;,
                                    cancelButtonText: &quot;No&quot;,
                                    closeOnConfirm: true, },
                                    function(){

                                    <?php
                                    $value=$data->token_number;
                                    ?>

                                    location.href=&quot;http://vaars.test/app/vacancy_applicants/../vacancy_rejection/edit/$value&quot;});

                                    " href="javascript:;"><i class="fa fa-ban"></i> </a>&nbsp;
                                    <a class="btn btn-xs btn-warning" title="" onclick="
                                    swal({
                                    title: &quot;Cancel&quot;,
                                    text: &quot;Are you sure you want to cancel?&quot;,
                                    type: &quot;warning&quot;,
                                    showCancelButton: true,
                                    confirmButtonColor: &quot;#DD6B55&quot;,
                                    confirmButtonText: &quot;Yes!&quot;,
                                    cancelButtonText: &quot;No&quot;,
                                    closeOnConfirm: true, },
                                    function(){

                                    <?php
                                    $value=$data->token_number;
                                    ?>
                                    location.href=&quot;http://vaars.test/app/vacancy_applicants/../vacancy_apply_cancelation/edit/$value&quot;});

                                    " href="javascript:;"><i class="fa fa-remove"></i> </a>&nbsp;
                                    <a class="btn btn-xs btn-info" title="" onclick="
                                    swal({
                                    title: &quot;Edit&quot;,
                                    text: &quot;Are you sure you want to edit record?&quot;,
                                    type: &quot;warning&quot;,
                                    showCancelButton: true,
                                    confirmButtonColor: &quot;#DD6B55&quot;,
                                    confirmButtonText: &quot;Yes!&quot;,
                                    cancelButtonText: &quot;No&quot;,
                                    closeOnConfirm: true, },
                                    function(){

                                    <?php
                                    $value=$data->token_number;
                                    ?>

                                    location.href=&quot;http://vaars.test/app/vacancy_applicants/../vacancy_apply/edit/$value&quot;});

                                    " href="javascript:;"><i class="fa fa-pencil"></i> </a>&nbsp;
                                    <a class="btn btn-xs btn-primary" title="" onclick="" href="{{URL::to('/app/vacancy_applicants/../vacancy_apply/view/'.$data->token_number)}}"><i class="fa fa-eye"></i> </a>&nbsp;
                                    <a class="btn btn-xs btn-success" title="" onclick="" href="{{URL::to('/app/vacancy_applicants/../applicant_profile/archive/'.$data->token_number)}}"><i class="fa fa-user"></i> </a>&nbsp;

                                    </div>
                              </td>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$data->id}}</td>
                              <td>{{$data->ad_no}}</td>
                              <td>{{$data->designation_en}}</td>
                              <td>{{$data->published_date_bs}}<br>{{$data->last_date_bs}}</td>
                              <!-- <td>{{$data->published_date_bs}}</td>
                              <td>{{$data->last_date_bs}}</td> -->
                              <td>{{$data->applicant_id}}</td>
                               <td>
                                <?php
                                $file = URL::to('/'.$data->photo);
                                if(is_file($file)) { ?>
                                    <a data-lightbox="roadtrip" rel="group_{vw_vacancy_applicant}" title="Photo: {{$data->id}}" href="{{URL::to('/'.$data->photo)}}">
                                    <img width="40px" height="40px" src="{{URL::to('/'.$data->photo)}}"></a>
                                <?php } else {} ?>

                               </td>
                              <td>{{$data->name_en}}</td>
                              <td>{{$data->mobile_no}}</td>
                              <td>{{$data->applied_date_bs}}</td>
                              <td>{{$data->token_number}} / {{$data->total_amount}}</td>
                              <!-- <td>{{$data->token_number}}</td>
                              <td>{{$data->total_amount}}</td> -->
                              <td>{{$data->paid_receipt_no}}</td>
                                <?php
                                    $handi=$data->is_handicapped;
                                        if($handi==0)
                                        {
                                            $apnaga="NO";
                                        }
                                        else
                                        {
                                            $apnaga="YES";
                                        }
                                ?>
                              <td>{{$apnaga}}</td>

                               <?php
                                    $remote=$data->is_remote_village;
                                    if($remote==0)
                                    {
                                        $remote="NO";
                                    }
                                    else
                                    {
                                        $remote="YES";
                                    }
                                 ?>
                              <td>{{$remote}}</td>
                              <td>{{$data->applied_group}}</td>
                                 <?php
                                    $value=$data->is_rejected;
                                    if($value==0)
                                    {
                                        $staff="NO";
                                    }
                                    else
                                    {
                                        $staff="YES";
                                    }

                                ?>
                              <td>{{$staff}}</td>
                                <?php
                                    $cancelled=$data->is_cancelled;
                                    if($cancelled==0)
                                    {
                                        $cancel="NO";
                                    }
                                    else
                                    {
                                        $cancel="YES";
                                    }

                                ?>
                              <td>{{$cancel}}</td>
                        </tr>
                        @endforeach
                </table>
                </div>
                </div>
                </div>
                </div>




















@endsection