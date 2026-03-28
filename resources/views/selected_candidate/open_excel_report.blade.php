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
				<th colspan="17" ><b>विज्ञापन: {{$intro_data[0]->ad_no}}</b></th>
			</tr>
			<tr>
				<th colspan="7" ><b>पद: {{$intro_data[0]->designation}}</b></th>
				<th colspan="10"><b>तह: {{$intro_data[0]->work_level}}</b></th>
			</tr>
      <tr>
        <th colspan="2"><b>पद संख्या: {{$intro_data[0]->total_req_seats}}</b></th>
        <th colspan="2"><b>खुल्ला:{{$intro_data[0]->open_seats}}</b></th>
        <th colspan="2"><b>महिला:{{$intro_data[0]->mahila_seats}}</b></th>
        <th colspan="2"><b>जनजाती : {{$intro_data[0]->janajati_seats}}</b></th>
        <th colspan="2"><b>मधेशी :{{$intro_data[0]->madheshi_seats}}</b></th>
        <th colspan="2"><b>दलित:{{$intro_data[0]->dalit_seats}}</b></th>
        <th colspan="2"><b>अपाङ्ग :{{$intro_data[0]->apanga_seats}}</b></th>
        <th colspan="2"><b>पिछडीएको क्षेत्र:{{$intro_data[0]->remote_seats}}</b></th>
      </tr

			<tr>
				<th colspan="17" style="text-align:center"><b>खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</b></th>
			</tr>
			<tr>
        <th>S.NO</th>
				<th>Roll</th>
				<th>Applicant ID</th>
				<th>Nt Staff Code</th>
				<th class="nepali_td">नाम</th>
				<th>Name</th>
        <th>D.O.B.</th>
				<th>Gender</th>
        <th>Address</th>
				<th class="nepali_td">बुबा / आमा</th>
				<th class="nepali_td">बाजे</th>
        <th>योग्यता</th>
				@if($level->level==8||$level->level==9)
					<th>अनुभव</th>
				@endif
					<th>तालिम</th>
					<th>NT Staff</th>
					<th>खुल्ला</th>
					<th>महिला</th>
					<th>आ.ज.</th>
					<th>मधेशी</th>
					<th>दलित</th>
					<th>अपाङ्ग </th>
					<th>पि.क्षे.</th>
					<th>Token No.</th>
					<th>Total Amount</th>
					<th>Paid Amount</th>
					<th>Receipt no</th>
					<th>Paid Date(AD)</th>
					<th>Mobile</th>
					<th>Email</th>
					<th>Remarks</th>
			</tr>

		</thead>
		<tbody>
			@if($candidate_data)
       @foreach ($candidate_data as $key=> $value)
			 <tr>
        <td>{{$loop->iteration}}</td>
				<td>{{$value->roll}}</td>
				<td>{{$value->ap_id}}</td>
				<td>{{$value->nt_staff_code}}</td>
				<td class="nepali_td">{{$value->applicant_name_np}}</td>
				<td>{{$value->applicant_name_en}}</td>
				<td>{{$value->date_of_birth}}</td>
				<td>{{$value->gender}}</td>
				<td>{{$value->address}}</td>
				<td class="nepali_td">{{$value->father_mother_np}}</td>
				<td class="nepali_td">{{$value->grand_father_np}}</td>
				<td>

				</td>
        @if($level->level==8||$level->level==9)
        <td>

        </td>
        @endif
        <td>{{$training_data[$value->ap_id]}}</td>
        <td>{{($value->nt_staff==true)?'YES':'NO'}}</td>
        <td>{{($value->is_open==true)?"\u{2713}":'-'}}</td>
        <td>{{($value->is_female==true)?"\u{2713}":'-'}}</td>
		    <td>{{($value->is_janajati==true)?"\u{2713}":'-'}}</td>
        <td>{{($value->is_madhesi==true)?"\u{2713}":'-'}}</td>
        <td>{{($value->is_dalit==true)?"\u{2713}":'-'}}</td>
	    	<td>{{($value->is_handicapped==true)?"\u{2713}":'-'}}</td>
        <td>{{($value->is_remote_village==true)?"\u{2713}":'-'}}</td>
        <td>{{($value->token_number)?$value->token_number:'NA'}}</td>
        <td>{{($value->total_amount)?$value->total_amount:'NA'}}</td>
        <td>{{($value->total_paid_amount)?$value->total_paid_amount:'NA'}}</td>
				<td>{{$value->paid_receipt_no}}</td>
        <td>{{($value->paid_date_ad)?$value->paid_date_ad:'NA'}}</td>
        <td>{{($value->mobile)?$value->mobile:'NA'}}</td>
				<td>{{($value->email)?$value->email:'NA'}}</td>
				<td></td>
			</tr>
			@endforeach
     @endif
		</tbody>
	</table>
</div>
