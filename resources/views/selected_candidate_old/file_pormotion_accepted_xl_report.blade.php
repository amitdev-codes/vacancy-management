


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
                    <th colspan="10" >सेवा/समुह : {{$intro_data[0]->service_group}} </th>
                    
				</tr>
				<tr>
					<th colspan="17" >पद संख्या: {{$intro_data[0]->total_req_seats}}</th>
					
				</tr>
				<tr>
					<th colspan="17" style="text-align:center">	आन्तरिक मूल्यांकन बढुवा तर्फका उम्मेदवारहरुको स्वीकृत नामावली</th>
				</tr>
				<tr>
					<!-- <th>Applicant ID</th> -->
					<th>S.N.</th>
					<th>Token Number</th>
					<th>Nt Staff Code</th>
					
					<th>Sex</th>

					<!-- <th>नाम</th> -->
					<th>Name</th>
					<th>Birth Date</th>
					<th>Address</th>

					<th>Current Designation</th>
					<th>Work level</th>
					<th>Seniority Date(B.S)</th>
					
					<th>योग्यता</th>
					<th>Minimum Qualification/Division</th>
					<th>Additional Qualification/Division</th>
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
					 <td>{{$value->token_number}}</td>
					 <td>{{$value->nt_staff_code}}</td>
					 
					 <td>{{$value->gender}}</td>

				
					
                    <td>{{$value->applicant_name_en}}</td>
					<!-- <td></td> -->
					<td>{{$value->date_of_birth}}</td>
					<td>{{$value->address}}</td>
					<td>{{$value->current_designation}}</td>
					<td>{{$value->work_level}}</td>
					<td>{{$value->seniority_date_bs}}</td>

					<td>{{$education_data[$value->ap_id]}}</td>
					<td>{{$value->minimum_qualification_degree}}/{{$value->minimum_qualification_division}}</td>
					<td>{{$value->additional_qualification_degree}}/{{$value->minimum_qualification_division}}</td>
					
					@if($value->mobile == null)
					<td>
						NA
					</td>
					@else
					<td>{{$value->mobile}}</td>
					@endif
					<td>{{$value->service_history_remarks}}</td>
				</tr>
				<?php $count++;
 					?>
				@endforeach @endif
			</tbody>
		</table>
	</div>


