file_pormotion_xl_report


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

	<div class="table-responsive" data-pattern="priority-columns">
		<table cellspacing="0" class="table table-small-font table-bordered  table-striped">
			<thead>
			<tr>
					<th colspan="17" style="text-align:center">नेपाल टेलिकम</th>
				</tr>
				<tr>
					<th colspan="17" style="text-align:center">पदपूर्ति सचिबालय</th>
				</tr>
				<tr>
					<th colspan="17" >विज्ञापन: {{$intro_data[0]->ad_no}} </th>
				</tr>
				<tr>
					<th colspan="7" >पद: {{$intro_data[0]->designation}} </th>
					<th colspan="10" >तह: {{$intro_data[0]->work_level}} </th>
				</tr>
				<tr>
					<th colspan="17" >पद संख्या: {{$intro_data[0]->total_req_seats}}</th>

				</tr>
				<tr>
					<th colspan="17" style="text-align:center">आन्तरिक प्रतियोगितात्मक तर्फका उम्मेदवारहरुको स्वीकृत नामावली</th>
				</tr>

				<tr>
					<!-- <th>Applicant ID</th> -->
					<th>S.N.</th>
					<th>Roll</th>
					<th>Applicant ID</th>
					<th>Nt Staff Code</th>

					<th>नाम</th>

					<!-- <th>नाम</th> -->
					<th>Name</th>
					<th>Birth Date</th>
					<th>Address</th>

					<th>बुबा / आमा</th>
					<th>बाजे</th>
					<th>Current Designation</th>
					<th>Work level</th>
					<th>Seniority Date(B.S)</th>

					<th>योग्यता</th>
					@if($level->level==8||$level->level==9)
					<th>अनुभब</th>
					@endif

					<th>Token No.</th>
					<th>Total Amount</th>
					<th>Paid Amount</th>
					<th>Receipt no</th>

					<th>Paid Date(AD)</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Remarks</th>
				</tr>



			</thead>
			<tbody>
			<?php $count = 1;
 					?>
				@if($candidate_data) @foreach($candidate_data as $value)
				<tr>
					<!-- <td>{{$value->id}}</td> -->
					 <td>{{$count}}</td>
					 <td>{{$value->roll}}</td>
					 <td>{{$value->ap_id}}</td>
					 <td>{{$value->nt_staff_code}}</td>

					 <td>{{$value->applicant_name_np}}</td>

					<td>{{$value->applicant_name_en}}</td>
					<!-- <td></td> -->
					<td>{{$value->date_of_birth}}</td>
					<td>{{$value->address}}</td>
					<td>{{$value->father_mother}}</td>
					<td>{{$value->grand_father}}</td>
					<td>{{$value->current_designation}}</td>
					<td>{{$value->work_level}}</td>
					<td>{{$value->seniority_date_bs}}</td>

					<td>{{$education_data[$value->ap_id]}}</td>
					@if($level->level==8||$level->level==9)
					<td>
					<?php
						for($i=0; $i<count($expereince_data[$value->ap_id]); $i++){
						    echo $expereince_data[$value->ap_id][$i].'</br>';
						}
					?>
					</td>
					@endif
					@if($value->token_number == null)
					<td>
						NA
					</td>
					@else
					<td>{{$value->token_number}}</td>
					@endif @if($value->total_amount == null)
					<td style="width:6%">
						NA
					</td>
					@else
					<td style="width:6%">{{$value->total_amount}}</td>

					@if($value->total_paid_amount == null)
					<td>
						NA
					</td>
					@else
					<td>{{$value->total_paid_amount}}</td>
					<td>{{$value->paid_receipt_no}}</td>
					@endif @if($value->paid_date_ad == null)
					<td style="width:6%">
						NA
					</td>
					@else
					<td style="width:6%">{{$value->paid_date_ad}}</td>
					@endif @if($value->email == null)
					<td>
						NA
					</td>
					@else
					<td>{{$value->email}}</td>
					@endif @if($value->mobile == null)
					<td>
						NA
					</td>
					@else
					<td>{{$value->mobile}}</td>
					@endif @endif
					<td></td>
				</tr>
				<?php $count++;
 					?>
				@endforeach @endif
			</tbody>
		</table>
	</div>
