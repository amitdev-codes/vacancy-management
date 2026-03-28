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
				<th colspan="5" >वि.नं: {{$intro_data[0]->ad_no}} </th>
				<th colspan="5" >सेवा/समूह :{{$intro_data[0]->samuha}}/{{$intro_data[0]->upsamuha}} </th>
				<th colspan="5" >पद संख्या: {{$intro_data[0]->total_req_seats}} </th>
			</tr>
			<tr>
				<th colspan="5" >पद: {{$intro_data[0]->designation}} </th>
				<th colspan="5" >श्रेणी/तह: {{$intro_data[0]->work_level}} </th>
				<th colspan="5" >बिज्ञापन भएको मिति: {{$intro_data[0]->date_to_publish_bs}} </th>
			</tr>

			<tr>
				<th colspan="17" style="text-align:center"><b>	आन्तरिक प्रतियोगितात्मक तर्फका उम्मेदवारहरुको स्वीकृत नामावली</b></th>
			</tr>
			<tr>
        <th class="nepali_td">क्र.सं</th>
				<th>रोल नं</th>
				<th class="nepali_td">उम्मेदवारको नाम, थर </th>
				<th class="nepali_td">लिङ्ग</th>
				<th class="nepali_td">तह</th>
				<th class="nepali_td">पद</th>
				<th class="nepali_td">बाबुको नाम</th>
        <th class="nepali_td">आमाको नाम</th>
        <th class="nepali_td">बजेको नाम</th>
				<th>भौचर/रसिद नं</th>
				<th class="nepali_td">शुल्क</th>
				<th class="nepali_td">सम्पर्क नं/मोबाइल</th>
				<th class="nepali_td">कैफियत</th>
			</tr>

		</thead>
		<tbody>
			@if($candidate_data)
       @foreach ($candidate_data as $value)
			 <tr>
        <td>{{$loop->iteration}}</td>
				<td>{{$value->roll}}</td>
				<td class="nepali_td">{{$value->applicant_name_np}}</td>
				<td>{{$value->gender}}</td>
				<td>{{$value->work_level}}</td>
				<td>{{$value->current_designation}}</td>
				<td class="nepali_td">{{$value->father_name_np}}</td>
				<td class="nepali_td">{{$value->mother_name_np}}</td>
				<td class="nepali_td">{{$value->grand_father_np}}</td>
				<td>{{$value->paid_receipt_no}}</td>
				<td>{{($value->total_paid_amount)?$value->total_paid_amount:'NA'}}</td>
        <td>{{($value->mobile)?$value->mobile:'NA'}}</td>
				<td>{{$value->remarks}}</td>
			</tr>
			@endforeach
     @endif
		</tbody>
	</table>
</div>
