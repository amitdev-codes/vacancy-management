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
	<a href="/../admin/selected_candidates/export/{{request()->route('id')}}">
		<button class="btn btn-primary">Export to Excel</button>
	</a>
	@endif
</div>

<div class="btn-group">
	@if($candidate_data)
		<a href="/../admin/selected_candidates/loksewaexport/{{request()->route('id')}}">
			<button class="btn btn-warning">Export to Loksewa</button>
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
		</div>
		<div class='panel-footer'>
			<p class="nepali_td">खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</p>
		</div>
	</div>
</header>
<div class="box box-solid box-primary" style="overflow-x:auto;">
<form id='form-table' method='post'>
	<table class="table-responsive table-striped table-bordered table nepali_td" id="candidates">
		<thead>
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
				<th>Father/ Mother</th>
				<th class="nepali_td">बुबा / आमा</th>
				<th class="nepali_td">GrandFather</th>
				<th class="nepali_td">बाजे</th>
        <th>योग्यता</th>
				@if($level->level==8||$level->level==9)
					<th>अनुभब</th>
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
					<th>Email</th>
					<th>Mobile</th>
					<th>Remarks</th>
			</tr>
		</thead>
		<tbody>
			@if($candidate_data)
       @foreach ($candidate_data as $value)
			 <tr>
        <td>{{($candidate_data->currentPage()-1) * $candidate_data->perPage() + $loop->iteration  }}</td>
				<td>{{$value->roll}}</td>
				<td>{{$value->ap_id}}</td>
				<td>{{$value->nt_staff_code}}</td>
				<td class="nepali_td">{{$value->applicant_name_np}}</td>
				<td>{{$value->applicant_name_en}}</td>
				<td>{{$value->date_of_birth}}</td>
				<td>{{$value->gender}}</td>
				<td>{{$value->address}}</td>
				<td class="nepali_td">{{$value->father_mother}}</td>
				<td class="nepali_td">{{$value->father_mother_np}}</td>
				<td class="nepali_td">{{$value->grand_father}}</td>
				<td class="nepali_td">{{$value->grand_father_np}}</td>
				<td>
					@foreach($candidate_education_data[$value->ap_id] as $key=>$ap_edu_data)
						@php
						$merged_data=$ap_edu_data->edu_degree;
						$applicant_edu_data[]=	$merged_data;	
						echo nl2br($merged_data."\n");
						@endphp
					@endforeach 
				</td>


        @if($level->level==8||$level->level==9)
        <td>
        @php
            for($i=0; $i<count($expereince_data[$value->ap_id]); $i++){
              echo $expereince_data[$value->ap_id][$i].'</br>';
          } 
        @endphp
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
        <td>{{($value->email)?$value->email:'NA'}}</td>
        <td>{{($value->mobile)?$value->mobile:'NA'}}</td>
				<td></td>
			</tr>
			@endforeach
     @endif
		</tbody>
	</table>
</form>
	<div class="col-md-8">{!! urldecode(str_replace("/?","?",$candidate_data->appends(Request::all())->render())) !!}</div>
@php
	$from = $candidate_data->count() ? ($candidate_data->perPage() * $candidate_data->currentPage() - $candidate_data->perPage() + 1) : 0;
    $to = $candidate_data->perPage() * $candidate_data->currentPage() - $candidate_data->perPage() + $candidate_data->count();
    $total = $candidate_data->total();
@endphp
    <div class="col-md-4"><span class="pull-right">{{ cbLang("filter_rows_total") }}
            : {{ $from }} {{ cbLang("filter_rows_to") }} {{ $to }} {{ cbLang("filter_rows_of") }} {{ $total }}</span>
	</div>
</div>
@endsection