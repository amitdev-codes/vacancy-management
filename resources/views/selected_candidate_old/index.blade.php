@extends('layouts.admin_template') @section('content')

	<!-- Single button -->
<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Ad No. <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
	@if($adno_data) @foreach($adno_data as $value)
	<li>
		<a href="../../app/selected_candidates/{{$value->id}}">{{$value->ad_title_en}}</a>
	</li>
	@endforeach @endif
  </ul>
</div>

<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Designation <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
	@if($designation_data) @foreach($designation_data as $value)
	<li>
	<a href="../../app/selected_candidates_designation/{{$value->post_id}}">{{$value->designation}}</a>
</li>
@endforeach @endif
  </ul>
</div>

<div class="btn-group">
	@if($candidate_data)
				<a href="../../app/selected_candidates/export/{{request()->route('id')}}">
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
	<!-- <script type="text/javascript" src="../../../js/rwd-table.min.js"></script> -->
	<header>


		<div class="left header panel panel-primary">
			<div clas="panel-body">
				<div class="heading-report">
					<h5>नेपाल टेलिकम</h5>
					<br>
					<h5 style="margin-top: -20px; margin-right: -17px;">पदपूर्ति सचिबालय</h5>
				</div>
				<h6>विज्ञापन: {{$intro_data[0]->ad_no}} </h6>
				<h6>पद: {{$intro_data[0]->designation}} </h6>
				<h6 style="margin-top: -25px;
margin-left: 40%;">तह: {{$intro_data[0]->work_level}}</h6>
				<h6>पद संख्या: {{$intro_data[0]->total_req_seats}} </h6>
				
				
				
				<h6 style="margin-top: -25px;margin-left: 10%;">खुल्ला: {{$intro_data[0]->open_seats}} </h6>
				<h6 style="margin-top: -25px;margin-left: 20%;">महिला: {{$intro_data[0]->mahila_seats}} </h6>
				<h6 style="margin-top: -25px;margin-left: 30%;">जनजाती : {{$intro_data[0]->janajati_seats}} </h6>
				<h6 style="margin-top: -25px;margin-left: 40%;">मधेशी : {{$intro_data[0]->madheshi_seats}} </h6>
				<h6 style="margin-top: -25px;margin-left: 50%;">दलित: {{$intro_data[0]->dalit_seats}} </h6>
				<h6 style="margin-top: -25px;margin-left: 60%;">अपाङ्ग : {{$intro_data[0]->apanga_seats}} </h6>
				<h6 style="margin-top: -25px;margin-left: 70%;">पिछडीएको क्षेत्र: {{$intro_data[0]->remote_seats}} </h6>
			</div>
			<div class='panel-footer'>
				<p>खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</p>
			</div>
		</div>


	</header>
	<div class="table-responsive" data-pattern="priority-columns">
		<table id='report_paginate' cellspacing="0" class="table table-small-font table-bordered  table-striped">
			<thead>
				<tr>
					<!-- <th rowspan="2">Applicant ID</th> -->
					<th rowspan="2">S.N.</th>
					@if($opening_type_id!=3)
					<th rowspan="2">Roll</th>
					<th rowspan="2">Admit Card</th>
					@endif
					<th rowspan="2">Applicant ID</th>
					@if($opening_type_id!=1)
					<th rowspan="2">Nt Staff Code</th>
					@endif
					<th rowspan="2">नाम</th>

					<!-- <th rowspan="2">नाम</th> -->
					<th rowspan="2">Name</th>
					@if($opening_type_id==1)
					<th colspan="2">All/Designation</th>
					@else
					<th colspan="2"></th>
					@endif
					@if($opening_type_id!=3)					
					<th rowspan="2">बुबा / आमा</th>
					<th rowspan="2">बाजे</th>
					@endif
					@if($opening_type_id!=1)
					<th rowspan="2">Current Designation</th>
					<th rowspan="2">Work Level</th>
					<th rowspan="2">Seniority Date (B.S)</th>
					@endif
					<th rowspan="2">योग्यता</th>
					@if($opening_type_id==3)
					<th colspan="2">Service History Education/Division</th>
					@endif
					@if($opening_type_id!=3)
					@if($level->level==8||$level->level==9)
					<th>अनुभब</th>
					@endif
					@endif
					@if($opening_type_id==1)
					<th rowspan="2">तालिम</th>
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
					 <td><a href="/app/admit_card/user/{{$value->token_number}}" target="_blank" style="margin-left:10px;" class="btn btn-xs btn-info">E-Admit Card</a></td>
					 @else
					 <td>--</td>
					@endif
					@endif					 
					 <td>{{$value->ap_id}}</td>
					 @if($opening_type_id!=1)
					 <td>{{$value->nt_staff_code}}</td>
					@endif
					 <td>{{$value->applicant_name_np}}</td>
					<td>{{$value->applicant_name_en}}</td>
					<!-- <td></td> -->
					<td>{{$value->date_of_birth}}</td>
					<td>{{$value->address}}</td>
					@if($opening_type_id!=3)
					<td>{{$value->father_mother}}</td>
					<td>{{$value->grand_father}}</td>
					@endif
					@if($opening_type_id!=1)
					<td>{{$value->current_designation}}</td>
					<td>{{$value->work_level}}</td>
					<td>{{$value->seniority_date_bs}}</td>
					@endif
					<td>{{$education_data[$value->ap_id]}}</td>
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
	<script>
		$(function () {

		});
	</script>

	@endsection