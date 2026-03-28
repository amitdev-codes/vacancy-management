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
		  <li><a class="dropdown-item nepali_td" href="{{route('GetDesignation',['id'=>$ad->id])}}">{{$ad->ad_title_en}}--{{$ad->opening_type}}</a></li>
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
		<a class="dropdown-item" href="{{route('getcandidates',['ad_id'=>$ad->id,'id'=>$value->post_id])}}">{{$value->designation}}</a>
	</li>
		@endforeach
		 @endif
	</ul>
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
	<div class="left header panel panel-primary" style='padding:10px;'>
		<div clas="panel-body">
			<div class="heading-report nepali_td">
				<h5 class="nepali_td">नेपाल टेलिकम</h5>
				<br>
				<h5 class="nepali_td" style="margin-top: -20px; margin-right: -17px;">पदपूर्ति सचिबालय</h5>
			</div>

			<h6 class="nepali_td">सुचना नं.: {{$intro_data[0]->notice_no}} </h6>
			<h6 class="nepali_td">विज्ञापन नं.: {{$intro_data[0]->ad_no}} </h6>
			<h6 class="nepali_td">पदको नाम: {{$intro_data[0]->designation}} </h6>
			<h6 class="nepali_td">तह: {{$intro_data[0]->work_level}}</h6>
			<h6 class="nepali_td">पद संख्या: {{$intro_data[0]->total_req_seats}} </h6>

			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 40%;">सेवा/समुह : {{$intro_data[0]->service_group}} </h6>
		</div>
	</div>

</header>

<div class="btn-group">
	@if($candidate_data)
	  <a href="{{route('exportexcelcandidates',['ad'=>$ad->id,'design'=>$value->post_id])}}" target="_blank"><button class="btn btn-primary"><i class="fa fa-file-excel-o"></i>Export to Excel</button></a>
	  <a href="{{route('exportpdfcandidates',['ad'=>$ad->id,'design'=>$value->post_id])}}" target="_blank"><button class="btn btn-success"><i class="fa fa-print"></i>Export to pdf</button></a>
	@endif
</div>
<div class="box">
	<div class="box-header nepali_td"><p><b>जेष्ठता,भौगोलिक,का. प्र. तथा योग्यता वापतको अंक गणनाको विवरण (अवधि @php
		echo $fiscal_year[0]->code;
		@endphp आषाढ़ मसान्तसम्म)</b></p>
	</div>
<div class="box box-solid box-primary" style="overflow-x:auto;">
	<table class="table-responsive table-striped table-bordered table nepali_td" id="candidates">
		<thead>
			<tr>
			<th>सि.नं.</th>
			<th>Service/Education</th>
			<th>Report</th>
			<th>टोकन नं.</th>
			<th>क.द.नं.</th>
			<th>लिंग</th>
			<th>कर्मचरीको नाम</th>
			<th>जेष्ठता मिति (yyyy/mm/dd)</th>
			<th>जेष्ठता बापतको अंक </th>
			<th>भौगलिक अंक</th>
			<th>का.प्र.बापतको अंक</th>
			<th>शैक्षिक योग्यताको अंक</th>
			<th>जम्मा अंक</th>
			<th colspan="2">न्युनतम शैक्षिक योग्यता</th>
			<th colspan="2">थप शैक्षिक योग्यता</th>
		</tr>
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>उपाधि</th>
			<th>श्रेणी</th>
			<th>उपाधि </th>
			<th>श्रेणी</th>
		</tr>
		</thead>
		<tbody>
			@if($candidate_data)
			 @foreach ($candidate_data as $value)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{$value->status}}</td>
				<td><a class="btn btn-xs btn-primary"
						href="/admin/individual_evaluation/{{$value->token_number}}?sn={{$value->rn}}"><i
							class="fa fa-eye"></i>
					</a></td>
				<td>{{$value->token_number}}</td>
				<td>{{$value->nt_staff_code}}</td>
				<td>{{$value->gender}}</td>
				<td>{{$value->applicant_name_np}}</td>
				<td>{{$value->seniority_date_bs}}</td>
				<td>{{$value->seniority_marks}}</td>
				<td>{{$value->geographical_marks}}</td>
				<td>{{$value->incharge_marks}}</td>
				<td>{{$value->qualification_marks}}</td>
				<td>{{$value->total_marks}}</td>
				<td>{{$value->minimum_qualification_degree}}</td>
				<td>{{$value->minimum_qualification_division}}</td>
				<td>{{$value->additional_qualification_degree}}</td>
				<td>{{$value->additional_qualification_division}}</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="17" style="color:#0035ff;"align="center"><b>!!! कुनै पनि तथायंक फेला परेन !!!! </b>
			</tr>
		 @endif
		</tbody>
		</tbody>
	</table>
</div>
@endsection