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
                
                <form method="get" style="display:inline-block;width: 260px;" action="/loksewasearch">
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
                  <form id="form-table" method="post" action="http://vaars.test/app/applicant_profile/action-selected">
                  <input type="hidden" name="button_name" value="">
                  <input type="hidden" name="_token" value="P7frwxqaFQv4IPfaxansv8IR15zzMfuCvsQNIqXu">
                  <table id="table_dash" class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr class="active">
                    
                                            <th width="1%">No.</th>
                                            
                                            <th width="auto"> <a href="/app/report_lok_sewa" title="Click to sort ascending">Applicant  &nbsp; <i class="fa fa-sort"></i></a></th>
                                            <th width="auto"><a href="/app/report_lok_sewa" title="Click to sort ascending">Photo &nbsp; <i class="fa fa-sort"></i></a></th>
                                            <th width="auto"><a href="/app/report_lok_sewa" title="Click to sort ascending">Vacancy &nbsp; <i class="fa fa-sort"></i></a></th>
                                            <th width="auto"><a href="/app/report_lok_sewa" title="Click to sort ascending">Designation &nbsp; <i class="fa fa-sort"></i></a></th>
                                            <th width="auto"><a href="/app/report_lok_sewa" title="Click to sort ascending">Token number &nbsp; <i class="fa fa-sort"></i></a></th>
                                            <th width="auto"><a href="/app/report_lok_sewa" title="Click to sort ascending">Roll &nbsp; <i class="fa fa-sort"></i></a></th>
 
                    </tr>
                </thead>

        @foreach($data1 as $data)
                <tbody>
                      
                      
                      <tr>

                              <td>{{$loop->iteration}}</td>
                              <td>{{$data->full_name}}</td>

<td>
<a data-lightbox="roadtrip" rel="group_{lok_sewa_report}" title="Photo:{{$data->full_name}} " href="{{URL::to('/'.$data->photo)}}">
<img width="40px" height="40px" src="{{URL::to('/'.$data->photo)}}"></a>



</td>


                             
                              <td>{{$data->ad_no}}</td>
                              <td>{{$data->designation}}</td>
                              <td>{{$data->token_number}}</td>
                              <td>{{$data->exam_roll_no}}</td>
                            
    
                             



   

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