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
				<th colspan="17" style="text-align:center"><b>आन्तरिक मूल्यांकन बढुवा तर्फका उम्मेदवारहरुको स्वीकृत नामावली</b></th>
			</tr>
			<tr>
				<th>S.N.</th>
				<th>Applicant ID</th>
				<th>Nt Staff Code</th>
				<th class="nepali_td">नाम</th>
				<th>Name</th>
        <th>Birth Date</th>
				<th>Address</th>
				<th>Current Designation</th>
				<th>Working Office</th>
				<th>Work Level</th>
				<th>Seniority Date (B.S)</th>
				<th class="nepali_td">योग्यता</th>
        <th>Minimum Qualification/Division</th>
        <th>Additional Qualification/Division</th>
				<th>Token No.</th>
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
				<td>{{$value->ap_id}}</td>
				<td>{{$value->nt_staff_code}}</td>
				<td class="nepali_td">{{$value->applicant_name_np}}</td>
				<td>{{$value->applicant_name_en}}</td>
				<td>{{$value->date_of_birth}}</td>
				<td>{{$value->address}}</td>
				<td>{{$value->current_designation}}</td>
				<td>{{$value->working_office}}</td>
				<td>{{$value->work_level}}</td>
				<td>{{$value->seniority_date_bs}}</td>
				<td>{{$education_data[$value->ap_id]}}</td>
        <td>{{$value->minimum_qualification_degree}}/{{$value->minimum_qualification_division}}</td>
        <td>{{$value->additional_qualification_degree}}/{{$value->minimum_qualification_division}}</td>
        <td>{{($value->token_number)?$value->token_number:'NA'}}</td>
        <td>{{($value->email)?$value->email:'NA'}}</td>
        <td>{{($value->mobile)?$value->mobile:'NA'}}</td>
        <td>{{$value->service_history_remarks}}</td>
			</tr>
			<?php $count++;
					   ?>
			@endforeach
     @endif
		</tbody>
	</table>
</div>
