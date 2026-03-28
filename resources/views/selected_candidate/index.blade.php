@extends('crudbooster::admin_template')
@section('content')
<link href="{{asset('css/custom/tabledesign.css') }}" rel="stylesheet" type="text/css"/>

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
		  <li><a class="dropdown-item nepali_td" href="{{route('selected_candidatesGetdesignation',['id'=>$ad->id])}}">{{$ad->ad_title_en}}--{{$ad->opening_type}}</a></li>
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
		if($md->id==$md_id)
		{
            $combo_title_designation_en=$md->designation_en;
			$combo_title_designation_np=$md->designation_np;
        }
	  }
  }
@endphp






<div class="btn-group">
	<button type="button" class="btn btn-success dropdown-toggle nepali_td" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		{{$combo_title_designation_en}}--{{$combo_title_designation_np}}
		<span class="caret"></span> 
	</button>
	<ul class="dropdown-menu">
		@if($designation_data) 
		@foreach($designation_data as $value)
	<li>
		<a class="dropdown-item" href="{{route('SelectedCandidatesGetCandidates',['ad_id'=>$vacancy_ad_id,'id'=>$value->id])}}">{{$value->designation_en}}-{{$value->designation_np}}</a>
	</li>
		@endforeach
		 @endif
	</ul>
</div>



<div class="btn-group">
	@if($candidate_data)
	<a href="../selected_candidates/export/{{request()->route('id')}}">
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
	<div class="left header panel panel-primary nepali_td">
		<div clas="panel-body">
			<div class="heading-report">
				<h5 class="nepali_td"><img src="{{asset('images/logo.png')}}" height="50px;" width="50px;" style="margin-right:20px;">नेपाल टेलिकम</h5>
				<br>
				<h5 style="margin-top: -35px; margin-right: -17px;" class="nepali_td">पदपूर्ति सचिवालय</h5>
			
			</div>
			<h6 class="nepali_td">विज्ञापन: {{$intro_data[0]->ad_no}} </h6>
			<h6 class="nepali_td">पद: {{$intro_data[0]->designation}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left:50%">तह: {{$intro_data[0]->work_level}}</h6>
			<h6 class="nepali_td">पद संख्या: {{$intro_data[0]->total_req_seats}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 10%;">खुल्ला: {{$intro_data[0]->open_seats}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 20%;">महिला: {{$intro_data[0]->mahila_seats}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 30%;">जनजाती : {{$intro_data[0]->janajati_seats}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 40%;">मधेशी : {{$intro_data[0]->madheshi_seats}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 50%;">दलित: {{$intro_data[0]->dalit_seats}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 60%;">अपाङ्ग : {{$intro_data[0]->apanga_seats}} </h6>
			<h6 class="nepali_td" style="margin-top: -25px;margin-left: 70%;">पिछडीएको क्षेत्र: {{$intro_data[0]->remote_seats}} </h6>
		</div>
		<div class='panel-footer'>
			<p class="nepali_td">खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</p>
		</div>
	</div>
</header>

<div class="box box-solid box-primary" style="overflow-x:auto;">
	<table class="table-responsive table-striped table-bordered table nepali_td" id="candidates">
		<thead>
			<tr>
				<th rowspan="2">S.N.</th>
				@if($opening_type_id!=3)
				<th rowspan="2">Roll</th>
				<th rowspan="2">Admit Card</th>
				@endif
				<th rowspan="2">Applicant ID</th>
				<th rowspan="2">Nt Staff Code</th>
				<th rowspan="2" class="nepali_td">नाम</th>
				<th rowspan="2">Name</th>
				@if($opening_type_id==1)
				<th colspan="2">All/Designation</th>
				@else
				<th colspan="2"></th>
				@endif
				@if($opening_type_id!=3)
				<th rowspan="2" class="nepali_td">Father / Mother</th>
				<th rowspan="2" class="nepali_td">बुबा / आमा</th>
				<th rowspan="2" class="nepali_td">बाजे</th>
				@endif
				@if($opening_type_id!=1)
				<th rowspan="2">Current Designation</th>
				<th rowspan="2">Work Level</th>
				<th rowspan="2">Seniority Date (B.S)</th>
				@endif
				<th rowspan="2" class="nepali_td">योग्यता</th>
				@if($opening_type_id==3)
				<th colspan="2">Service History Education/Division</th>
				@endif
				@if($opening_type_id!=3)
				@if($level->level==8||$level->level==9)
				<th class="nepali_td">अनुभब</th>
				@endif
				@endif
				@if($opening_type_id==1)
				<th rowspan="2" class="nepali_td">तालिम</th>
				<th rowspan="2">NT Staff</th>

				<th colspan="6">Group</th>
				@endif
				<th rowspan="2">Token No.</th>
				@if($opening_type_id!=3)
				<th rowspan="2">Total Amount</th>
				<th rowspan="2">Paid Amount</th>
				<th rowspan="2">Receipt no</th>

				<th rowspan="2">Paid Date(AD)</th>
				@endif
				<th rowspan="2">Email</th>
				<th rowspan="2">Mobile</th>
				<th rowspan="2">Remarks</th>

			</tr>


			<tr>
				<th>D.O.B.</th>
				<th>Address</th>
				@if($opening_type_id!=3)
				@if($level->level==8||$level->level==9)
				<th>Organization/(from-to)</th>
				@endif
				@endif
				@if($opening_type_id==3)
				<th>Minumum</th>
				<th>Additional</th>
				@endif

				@if($opening_type_id==1)
				<th>O</th>
				<th>F</th>
				<th>M</th>
				<th>J</th>
				<th>D</th>
				<th>R</th>
				@endif
			</tr>

		</thead>
		<tbody>
			<?php $count = 1;
					   ?>
			@if($candidate_data) @foreach ($candidate_data as $value)
			<tr>
				<!-- <td>{{$value->id}}</td> -->
				<td>{{$value->rn}}</td>
				@if($opening_type_id!=3)
				<td>{{$value->roll}}</td>
				@if(isset($value->roll))
				<td><a href="/app/admit_card/user/{{$value->token_number}}" target="_blank" style="margin-left:10px;"
						class="btn btn-xs btn-info">E-Admit Card</a></td>
				@else
				<td>--</td>
				@endif
				@endif
				<td>{{$value->ap_id}}</td>

				<td>{{$value->nt_staff_code}}</td>

				<td class="nepali_td">{{$value->applicant_name_np}}</td>
				<td>{{$value->applicant_name_en}}</td>
				<!-- <td></td> -->
				<td>{{$value->date_of_birth}}</td>
				<td>{{$value->address}}</td>
				@if($opening_type_id!=3)
				<td class="nepali_td">{{$value->father_mother}}</td>
				<td class="nepali_td">{{$value->father_mother_np}}</td>
				<td class="nepali_td">{{$value->grand_father}}</td>
				@endif
				@if($opening_type_id!=1)
				<td>{{$value->current_designation}}</td>
				<td>{{$value->work_level}}</td>
				<td>{{$value->seniority_date_bs}}</td>
				@endif
				{{-- <td>{{$education_data[$value->ap_id]}}</td> --}}
				<td>
					@foreach($candidate_education_data[$value->ap_id] as $key=>$ap_edu_data)
						@php
						$merged_data=$ap_edu_data->edu_level.'/'.$ap_edu_data->edu_degree.'/'.$ap_edu_data->edu_major;
						$applicant_edu_data[]=	$merged_data;	
						// echo nl2br('('.$merged_data.')'."\n");
						echo nl2br($merged_data."\n");
						@endphp
					@endforeach 
				</td>
				@if($opening_type_id!=3)
				@if($level->level==8||$level->level==9)
				<td>
					<?php
						  for($i=0; $i<count($expereince_data[$value->ap_id]); $i++){
							  echo $expereince_data[$value->ap_id][$i].'</br>';
						  }
					  ?>
				</td>
				@endif
				@endif
				@if($opening_type_id==1)
				<td>{{$training_data[$value->ap_id]}}</td>
				@if($value->nt_staff == true)
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
				@endif
				@if($opening_type_id==3)
				<td>{{$value->minimum_qualification_degree}}/{{$value->minimum_qualification_division}}</td>
				<td>{{$value->additional_qualification_degree}}/{{$value->additional_qualification_division}}</td>

				@endif
				@if($value->token_number == null)
				<td>
					NA
				</td>
				@else
				<td>{{$value->token_number}}</td>
				@endif

				@if($opening_type_id!=3)
				@if($value->total_amount == null)
				<td style="width:6%">
					NA
				</td>
				@else
				<td style="width:6%">{{$value->total_amount}}</td>
				@endif
				@if($value->total_paid_amount == null)
				<td>
					NA
				</td>
				@else
				<td>{{$value->total_paid_amount}}</td>
				@endif
				<td>{{$value->paid_receipt_no}}</td>
				@if($value->paid_date_ad == null)
				<td style="width:6%">
					NA
				</td>
				@else
				<td style="width:6%">{{$value->paid_date_ad}}</td>
				@endif
				@endif

				@if($value->email == null)
				<td>
					NA
				</td>
				@else
				<td>{{$value->email}}</td>
				@endif
				@if($value->mobile == null)
				<td>
					NA
				</td>
				@else
				<td>{{$value->mobile}}</td>
				@endif

				<td></td>
			</tr>
			<?php $count++;
					   ?>
			@endforeach @endif
		</tbody>
	</table>
</div>
@if($opening_type_id==1)
@if($candidate_data)
{{ $candidate_data->links() }}
@endif
@endif
@endsection