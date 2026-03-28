@extends('crudbooster::admin_template')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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

                                    <a style="margin-top:-23px" href="javascript:void(0)" id="btn_advanced_filter" data-url-parameter="" title="Advanced Sort &amp; Filter" class="btn btn-sm btn-default ">
                        <i class="fa fa-filter"></i> Sort &amp; Filter
                    </a>

                 <form method="get" style="display:inline-block;width: 260px;" action="/Applicant_profile_search">
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
        <div class="box-body table-responsive no-padding">
            <!-- start of amit changes -->
                   <div class="col-md-12">
                <div class="card">
                   <div class="card-body">
                   <!-- end of amit changes -->
                  <form id="form-table" method="post" action="http:vaars.test/app/applicant_profile/action-selected">
                  <input type="hidden" name="button_name" value="">
                  <input type="hidden" name="_token" value="P7frwxqaFQv4IPfaxansv8IR15zzMfuCvsQNIqXu">
                  <table id="table_search" class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr class="active">
                        <th width="1%">No.</th>
                        <th width="auto"> <a href="/app/applicant_profile" title="Click to sort ascending">Applicant ID &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/applicant_profile" title="Click to sort ascending">Full Name &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/applicant_profile" title="Click to sort ascending">Gender &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/applicant_profile" title="Click to sort ascending">DOB &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/applicant_profile" title="Click to sort ascending">Mobile No. &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/applicant_profile" title="Click to sort ascending">Email &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/applicant_profile" title="Click to sort ascending">NT Staff &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="auto"><a href="/app/applicant_profile" title="Click to sort ascending">Photo &nbsp; <i class="fa fa-sort"></i></a></th>
                        <th width="100px" style="text-align:right">Action</th>
                    </tr>
                </thead>

        @foreach($data1 as $data)
                <tbody>

                    <tr>
                              <td>{{ $loop->iteration}}</td>
                              <td>{{$data->id}}</td>
                              <td>{{$data->first_name_en}}<br>{{$data->first_name_np}}</td>
                              <td>{{$data->gender_id}}</td>
                              <td>{{$data->dob_ad}}<br>{{$data->dob_bs}}</td>
                              <td>{{$data->mobile_no}}</td>
                              <td>{{$data->email}}</td>
                              <?php
                              $value=$data->is_nt_staff;
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
                              <td><a data-lightbox="roadtrip" rel="group_{applicant_profile}" title="Photo:{{$data->first_name_en}}<br>{{$data->first_name_np}}" href="{{URL::to('/'.$data->photo)}}">
                              <img width="40px" height="40px" src="{{URL::to('/'.$data->photo)}}"></a></td>
                              <td><div class="button_action" style="text-align:right"><a class="btn btn-xs btn-primary btn-detail" title="Detail Data" href="{{URL::to('/app/applicant_profile/detail/'.$data->id)}}"><i class="fa fa-eye"></i></a>


<a class="btn btn-xs btn-success btn-edit" title="Edit Data" href="{{URL::to('/app/applicant_profile/edit/'.$data->id)}}"><i class="fa fa-pencil"></i></a>

<a class="btn btn-xs btn-warning btn-delete" title="Delete" href="javascript:;" onclick="swal({
title: &quot;Are you sure ?&quot;,
text: &quot;You will not be able to recover this record data!&quot;,
type: &quot;warning&quot;,
showCancelButton: true,
confirmButtonColor: &quot;#ff0000&quot;,
confirmButtonText: &quot;Yes!&quot;,
cancelButtonText: &quot;No&quot;,
closeOnConfirm: false },
function(){

    <?php
$value=$data->id;

?>
     location.href=&quot;http:vaars.test/app/applicant_profile/delete/$value&quot; });"><i class="fa fa-trash"></i></a>

</div></td>
                        </tr>
                        @endforeach
                </table>
                </div>
                </div>
                </div>
                </div>
</body>
</html>












@endsection