




	<style>

tr {background-color: #f2f2f2;}
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


table tr td{
	
		border: 3px solid #000000;
		border-collapse: collapse;
	}
	 .noborder{
			border-right: 3px solid #fff !important;
			border-left: 3px solid #fff!important;
			border-top: 3px solid #fff!important;
			border-bottom: 3px solid #fff !important;
		}


	</style>

	
	
	




	<div class="table-responsive" data-pattern="priority-columns">
		<table cellspacing="0" class="table table-small-font table-bordered  table-striped">
			<thead>
			<tr>
					<th colspan="25" style="text-align:center">नेपाल टेलिकम</th>
				</tr>
				<tr>
					<th colspan="25" style="text-align:center">पपदपूर्ति सचिबालय</th>
				</tr>

<tr>
					<th colspan="25" style="text-align:center">बैयक्तिक विवरण बापतको अंक तालिका</th>
				</tr>
                टोकन नं.: {{$intro_data[0]->token_number}}
				<tr><th colspan="25" >कर्मचारी नं.: {{$intro_data[0]->nt_staff_code}} </th> </tr>
				<tr>	<th colspan="25" >कर्मचरिको नाम : {{$intro_data[0]->fullname}} </th></tr>
                <tr>	<th colspan="25" >टोकन नं.: {{$intro_data[0]->token_number}} </th></tr>
				
				<tr>	<th colspan="25" >हालको पद र तह: {{ $intro_data[0]->current_post}},{{$intro_data[0]->current_work_level}} </th>
				<tr>	<th colspan="25" >बि.नं.: {{$intro_data[0]->ad_no}} </th></tr>
				<tr>	<th colspan="25" >पद : {{$intro_data[0]->applied_post}} </th></tr>
				<tr> <th colspan="25" >सेवा समुह र उपसमुह : {{$intro_data[0]->current_service_sub_group}},{{$intro_data[0]->current_service_group}} </th></tr>
                <tr>	<th colspan="25" >स्थायि ठेगाना: जिल्ला : {{$intro_data[0]->district_id}} </th></tr>
                <tr>	<th colspan="25" >गा.वि.स./न.पा.: {{$intro_data[0]->local_level_id}} </th></tr>
				
				<tr>
					<th colspan="17" style="text-align:center">अंक गणनाको अबधि २०७४ अषाढ मसान्तसम्म</th>
				</tr>


			<tr>
			<td> <b>१. जेष्ठता विवरण </b></td>
					<td>{{5}}</td>
					<td>2</td>
			<td colspan="5"><b><center>हालको पदको नोकरी विवरण </center></b></td>
			<td rowspan="3"><b>बार्षिक अंकदर</b></td>
			<td rowspan="3"><b>प्राप्ताङ्क </b></td>
			<td rowspan="3"><b>कैफियत</b></td>
				<td rowspan="3"><b>3</td>
		</tr> 

		<tr>
			<td colspan="2" rowspan="2"><b>बहाल रहेको कार्यलाय </b></td>
			<td rowspan="2"></td>
			<td colspan="2"><b>अस्थयी/ स्थायी सेव अबधि</b></td>
			<td rowspan="2"><b>बर्ष</b></td>
			<td rowspan="2"><b>महिना</b></td>
			<td rowspan="2"><b>दिन</b></td>
		</tr>
		<tr>
			<td><b>देखि</b></td>
			<td><b>सम्म</b> </td>
		</tr>
		<tr>
		
			<td colspan="3" class="noborder"><b>RECRUITMENT COMMITTEE</b></td>
			<td>2073-3-1</td>
			<td>2075-03-31</td>
			<td>{{2}}</td>
			<td>{{change}}</td>
			<td>1</td>
			<td>1</td>
			<td>3</td>
			<td>6.258</td>
			<td>nothing</td>
		</tr>
		</table>


<br><br>






		<table  cellspacing="10" cellpadding="10" width="100%">

		<tr>
			<td rowspan="2"><b>2.भौगोलिक  काम गरेको जिल्ला</b></td>
			<td rowspan="2"><b>बर्ग </b></td>
			<td rowspan="2"><b>लिङ्ग M/F</b></td>
			<td colspan="5" align="center"><b>(रुजु हजिर् भयेको अबथि अध्ययन बिदा, असधरन बिदा लियेको  अबधि बाहेक)</b></td>
			<td rowspan="2"><b>बार्षिक अंकदर</b></td>
			<td rowspan="2"><b>प्राप्ताङ्क</b></td>
			<td rowspan="2"><b>कुल प्राप्ताङ्क</b></td>
			<td rowspan="2"><b>प्रमाणित कोष</b></td>
 
		</tr>
		<tr>
			<td><b>देखि</b></td>
			<td><b>सम्म</b> </td>
			<td><b>बर्ष</b></td>
			<td><b>महिना</b></td>
			<td><b>दिन</b></td>
		</tr>
		<tr>
			<td>Kathmandu</td>
			<td>NGA</td>
			<td>M</td>
			<td>a</td>
			<td>a</td>
			<td>a</td>
			<td>a</td>
			<td>a</td>
			<td>a</td>
			<td>a</td>
			<td rowspan="2">a</td>
			<td>a</td>
		</tr>
		<tr>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
			<td>b</td>
		</tr>
		<tr>
			<td>c</td>
			<td>c</td>
			<td>c</td>
			<td>c</td>
			<td>c</td>
			<td>c</td>
			<td>c</td>
			<td>c</td>
			<td><b>जम्मा </b></td>
			<td>c</td>
			<td>c</td>
			<td>c</td>
		</tr>

				</table>

<br><br>
 <table  cellspacing="10" cellpadding="10" width="100%">
		<tr>
 
			<td rowspan="2"><b>३. क प्र भैइ कार्यरत रहेको कार्यलय</b></td>
			<td></td>
			<td></td>
			<td colspan="5" align="center"><b>हलको पदम का प्र भैइ कार्य गरेको बिबरण</b></td>
			<td rowspan="2"><b>बार्षिक अंकदर</b></td>
			<td rowspan="2"><b>प्राप्ताङ्क</b></td>
			<td rowspan="2"><b>कुल प्राप्ताङ्क</b></td>
			<td rowspan="2"><b>कैफियत</b></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td><b>देखि</b></td>
			<td><b>सम्म</b> </td>
			<td><b>बर्ष</b></td>
			<td><b>महिना</b></td>
			<td><b>दिन</b></td>
		
	

			</tr>
<tr>
			<td colspan="2"><b>दु स क सुन्धारा</b></td>
			<td></td>
			<td>d</td>
			<td>d</td>
			<td>d</td>
			<td>d</td>
			<td>d</td>
			<td>d</td>
			<td>d</td>
			<td>d</td>
			<td>d</td>
		</tr>
		<tr>
			<td>f</td>
			<td>e</td>
			<td>f</td>
			<td>f</td>
			<td>f</td>
			<td>f</td>
			<td>f</td>
			<td>f</td>
			<td><b>जम्मा</b></td>
			<td>f</td>
			<td>f</td>
			<td>f</td>
		</tr> 

			
		</table>
		
<br><br>

		<table  cellspacing="10" cellpadding="10" width="100%">
		<tr>
			<td colspan="4"><b><b>४. शैक्षिक योग्यता विवरण : </b></td>
			<td colspan="4"><b>उपधिको नम र बिषय</b></td>
			<td><b>shreni</b></td>
			<td><b>प्राप्ताङ्क</b></td>
			<td><b>कुल प्राप्ताङ्क</b></td>
			<td><b>कैफियत</b></td>
		</tr>
	

<tr>
			<td colspan="4"><b>तोकियेको न्युनतम शैक्षिक योग्यता</b></td>
			<td colspan="4">m</td>
			<td>m</td>
			<td>k</td>
			<td rowspan="2">1</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="4"><b>न्युनतम योग्यता भन्दा मथिको सम्बन्धित बिषयको यक उपाधि</b></td>
			<td colspan="4">g</td>
			<td>m</td>
			<td>k</td>
			<td>l</td>
		</tr>
		

		<tr>
			<td colspan="4"><b>1.</b>जेष्ठता प्राप्तङ्ग</td>
			<td>g</td>

		</tr>
			<tr>
			<td colspan="4"><b>२.</b> भोगलिक को प्राप्तङ्ग </td>
			<td>g</td>
			<td colspan="7" class="noborder" align="center"><b>रुजु गर्ने: g</b></td>
		</tr>
			<tr>
			<td colspan="4"><b>३.</b> का. प्र. बपतको अंक </td>
			<td>h</td>
			<td colspan="7" class="noborder" align="center"></td>
		</tr>
			<tr>
			<td colspan="4"><b>४.</b> शैक्षिक योग्यता बपत अंक </td>
			<td>h</td>
			<td colspan="7" class="noborder" align="center"><b>प्र्माणित गर्ने: h</td>

		<tr>
			<td colspan="4"><b> जम्मा अंक </b></td>
			<td>h</td>
			<td colspan="7" class="noborder" align="center"></td>
		</tr>
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
					 <
					 @if($value->token_number == null)
					<td>
						NA
					</td>
					@else
					<td>{{$value->token_number}}</td>
					@endif
					 @if($opening_type_id!=1)
					 <td>{{$value->nt_staff_code}}</td>
					@endif
					<td>{{$value->gender}}</td>
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
					<td>{{$value->working_office}}</td>
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