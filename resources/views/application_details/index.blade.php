@extends('crudbooster::admin_template')
@section('content')
<link href="{{asset('css/custom/tabledesign.css') }}" rel="stylesheet" />
@php
if($ad_id==0){
 $combo_title='विज्ञापन';
 }
 else{
   foreach($adno_data as $ad)
   {
   if($ad->id==$id)
   {
     $combo_title=$ad->ad_title_en;
   }
   }
 }
@endphp
<!-- Single button -->
<div class="btn-group">
<button type="button" class="btn btn-primary dropdown-toggle nepali_td" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$combo_title}}
 <span class="caret"></span> 
 </button>
 <ul class="dropdown-menu">
   @if($adno_data) 
     @foreach($adno_data as $ad)
     <li><a class="dropdown-item nepali_td" href="{{route('application_details_designation_view',['id'=>$ad->id])}}">{{$ad->ad_title_en}}</a></li>
    @endforeach
     @endif
 </ul>
</div>


@php
if($md_id==0){
 $combo_title_designation='पद';
 }
 else{
   foreach($designation_data as $key=>$md)
   {
   if($md->post_id==$md_id)
   {
           $combo_title_designation=$md->designation;
       }
   }
 }
@endphp

<div class="btn-group">
 <button type="button" class="btn btn-success dropdown-toggle nepali_td" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   {{$combo_title_designation}}
   <span class="caret"></span> 
 </button>
 <ul class="dropdown-menu">
   @if($designation_data) 
   @foreach($designation_data as $value)
 <li>
   <a class="dropdown-item" href="{{route('application_details_getCandidates',['ad_id'=>$ad->id,'id'=>$value->post_id])}}">{{$value->designation}}</a>
 </li>
   @endforeach
    @endif
 </ul>
</div>


<div class="btn-group">
 @if($candidate_data)
       <a href="../../admin/file_promotion/export/{{request()->route('id')}}">
         <button class="btn btn-primary">Export to Excel</button>
       </a>
       @endif
</div>




 <style>
   .heading-report {
     text-align: -webkit-right;
     margin-right: 45%;
   }


   h5 {
     font-size: 19px;
     font-weight: 700;
   }

   h6 {
     line-height: 15px;
     font-size: 14px !important;
     font-weight: 600;
   }

   p {
     text-align: center;
     font-weight: 700;
     font-size: 18px;
   }
 </style>

<link href="../../../css/rwd-table.min.css" rel="stylesheet">
<script type="text/javascript" src="../../../js/jquery-1.9.1.min.js"></script>
 <header>
   <div class="left header panel panel-primary">
     <div clas="panel-body">
       <div class="heading-report">
         <h5 class="nepali_td">नेपाल टेलिकम</h5>
         <br>
         <h5 class="nepali_td" style="margin-top: -20px; margin-right: -17px;">पदपूर्ति सचिबालय</h5>
       </div>
       <h6 class="nepali_td">विज्ञापन: {{$intro_data[0]->ad_no}} </h6>
       <h6 class="nepali_td">पद: {{$intro_data[0]->designation}} </h6>
       <h6 class="nepali_td">पद संख्या: {{$intro_data[0]->total_req_seats}} </h6>
       <h6 class="nepali_td" style="margin-top: -25px;margin-left: 40%;">तह: {{$intro_data[0]->work_level}}</h6>
       <h6 class="nepali_td" style="margin-top: -25px;margin-left: 60%;">सेवा/समुह  : {{$intro_data[0]->service_group}} </h6>

       <h6 class="nepali_td">खुला: {{$intro_data[0]->total_req_seats}} </h6>
       <h6 class="nepali_td" style="margin-top: -25px;margin-left: 10%;">महिला: {{$intro_data[0]->work_level}}</h6>
       <h6 class="nepali_td" style="margin-top: -25px;margin-left: 20%;">दलित: {{$intro_data[0]->service_group}} </h6>
       <h6 class="nepali_td" style="margin-top: -25px;margin-left: 40%;">पिछडीएको क्षेत्र: {{$intro_data[0]->service_group}} </h6>
       <h6 class="nepali_td" style="margin-top: -25px;margin-left: 60%;">जनजाती: {{$intro_data[0]->service_group}} </h6>
       <h6 class="nepali_td" style="margin-top: -25px;margin-left: 80%;">अपाङ्ग: {{$intro_data[0]->service_group}} </h6>

     </div>
     <div class='panel-footer'>
       <p class="nepali_td">खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</p>
     </div>
   </div>
 </header>

 <div class="table-responsive" data-pattern="priority-columns">
  <table id='report_paginate' cellspacing="0" class="table table-small-font table-bordered  table-striped">
  <thead>
    <tr>
      <th rowspan="2">NT Staff/Not</th>
      <th colspan="6"="6">Group</th>
      <th rowspan="2">Token No.</th>
      <th rowspan="2">Total Amount</th>
      <th rowspan="2">Paid Amount</th>
      <th rowspan="2">Paid Date</th>
      <th rowspan="2">Mobile</th>
      <th rowspan="2">Email</th>
      <th rowspan="2">Remarks</th>

    </tr>
    <tr>
      <th>O</th>
      <th>F</th>
      <th>M</th>
      <th>J</th>
      <th>D</th>
      <th>R</th>

    </tr>
  </thead>
  <tbody>
    @if($candidate_data) @foreach($candidate_data as $value)
    <tr>
    @if($value->is_nt_staff == true)
      <td style="width:6%;">YES</td>
       @else
        <td style="width:6%;">NO</td>
       @endif

       @if($value->is_open == true)
       <td>
         YES
       </td>
       @else
       <td>NO</td>
       @endif

       @if($value->is_female == true)
       <td>
         YES
       </td>
       @else
       <td>NO</td>
       @endif

       @if($value->is_madhesi == true)
       <td>
         YES
       </td>
       @else
       <td>NO</td>
       @endif

       @if($value->is_janajati == true)
       <td>
         YES
       </td>
       @else
       <td>NO</td>
       @endif

       @if($value->is_dalit == true)
       <td>
         YES
       </td>
       @else
       <td>NO</td>
       @endif

       @if($value->is_remote_village == true)
       <td>
         YES
       </td>
       @else
       <td>NO</td>
       @endif

       @if($value->token_number == null)
       <td>
         <NAv></NAv>
       </td>
       @else
       <td>{{$value->token_number}}</td>
       @endif

       @if($value->total_amount == null)
       <td style="width:6%">
         NA
       </td>
       @else
       <td style="width:6%">{{$value->total_amount}}</td>
       @endif

       @if($value->total_paid_amount == null)
       <td style="width:6%">
         NA
       </td>
       @else
       <td style="width:6%">{{$value->total_paid_amount}}</td>
       @endif


       <td>{{$value->paid_date_bs}}</td>

       @if($value->mobile_no == null)
       <td>
         NA
       </td>
       @else
       <td>{{$value->mobile_no}}</td>
       @endif

       @if($value->email == null)
       <td>
         NA
       </td>
       @else
       <td>{{$value->email}}</td>
       @endif

       <td></td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>
 </div>
@endsection