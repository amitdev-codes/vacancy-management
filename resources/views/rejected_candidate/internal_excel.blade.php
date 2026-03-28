<div class="box box-solid box-primary" style="overflow-x:auto;">
	<table class="table-responsive table-striped table-bordered table nepali_td" id="candidates">
		<thead>
			<tr>
				<th colspan="17" style="text-align:center"><b>नेपाल टेलिकम<b></th>
			</tr>
			<tr>
				<th colspan="17" style="text-align:center"><b>पदपूर्ति सचिबालय</b></th>
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
				<th colspan="17" style="text-align:center"><b>	आन्तरिक प्रतियोगितात्मक तर्फका उम्मेदवारहरुको स्वीकृत नामावली</b></th>
			</tr>
			<tr>
        <th>S.NO</th>
				<th>Roll</th>
				<th>Applicant ID</th>
				<th>Nt Staff Code</th>
				<th class="nepali_td">नाम</th>
				<th>Name</th>
        <th>D.O.B.</th>
        <th>Address</th>
				<th>Gender</th>
				<th>Father/ Mother</th>
				<th class="nepali_td">बुबा / आमा</th>
				<th>GranFather</th>
				<th class="nepali_td">बाजे</th>
				<th>Current Designation</th>
				<th>Work Level</th>
				<th>Seniority Date (B.S)</th>
				<th class="nepali_td">योग्यता</th>
				@if($level->level==8||$level->level==9)
				<th class="nepali_td">अनुभब</th>
				@endif
				<th>Token No.</th>
				<th>Total Amount</th>
				<th>Paid Amount</th>
				<th>Receipt no</th>
				<th>Paid Date(AD)</th>
				<th rowspan="2">Rejected Date</th>
				<th rowspan="2">Reject Reason</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Remarks</th>

			</tr>

		</thead>
		<tbody>
			@if($candidate_data)
       @foreach ($candidate_data as $value)
			 <tr>
        <td>{{$loop->iteration}}</td>
				<td>{{$value->roll}}</td>
				<td>{{$value->ap_id}}</td>
				<td>{{$value->nt_staff_code}}</td>
				<td class="nepali_td">{{$value->applicant_name_np}}</td>
				<td>{{$value->applicant_name_en}}</td>
				<td>{{$value->date_of_birth}}</td>
				<td>{{$value->address}}</td>
				<td>{{$value->gender}}</td>
				<td class="nepali_td">{{$value->father_mother}}</td>
				<td class="nepali_td">{{$value->father_mother_np}}</td>
				<td class="nepali_td">{{$value->grand_father}}</td>
				<td class="nepali_td">{{$value->grand_father_np}}</td>
				<td>{{$value->current_designation}}</td>
				<td>{{$value->work_level}}</td>
				<td>{{$value->seniority_date_bs}}</td>
				<td>
					@foreach($candidate_education_data[$value->ap_id] as $key=>$ap_edu_data)
						@php
						// $merged_data=$ap_edu_data->edu_level.'/'.$ap_edu_data->edu_degree.'/'.$ap_edu_data->edu_major;
						$merged_data=$ap_edu_data->edu_degree;
						$applicant_edu_data[]=	$merged_data;	
						// echo nl2br('('.$merged_data.')'."\n");
						echo nl2br($merged_data."\n");
						@endphp
					@endforeach 
				</td>

				{{-- <td>{{$education_data[$value->ap_id]}}</td> --}}

        <td>{{($value->token_number)?$value->token_number:'NA'}}</td>
        <td>{{($value->total_amount)?$value->total_amount:'NA'}}</td>
        <td>{{($value->total_paid_amount)?$value->total_paid_amount:'NA'}}</td>
				<td>{{$value->paid_receipt_no}}</td>
        <td>{{($value->paid_date_ad)?$value->paid_date_ad:'NA'}}</td>
				<td>{{$value->rejected_date_ad}}<br>{{$value->rejected_date_bs}}</td>
				<td>{{$value->rejected_reason}}</td>
        <td>{{($value->email)?$value->email:'NA'}}</td>
        <td>{{($value->mobile)?$value->mobile:'NA'}}</td>
				<td></td>
			</tr>
			@endforeach
     @endif
		</tbody>
	</table>
</div>
