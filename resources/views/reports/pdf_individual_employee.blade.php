<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
      
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" 
  integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<style>
 @font-face { font-family: "Mangal";  src: url({{ URL::asset("fonts/mangal.ttf")}}) format("truetype"); }
</style>

  <style>
    body{  font-family: "Mangal"; }
    table#tokentbl td {border: none;}
    .headertop h3 {   line-height: 1.5;}
    thead { display: table-header-group }
    tfoot { display: table-row-group }
    tr { page-break-inside: avoid }
</style>
</head>
<body class="main">
    <section class="invoice">
    <div class="box">
    <div class="heading-report">
    <h3 style="text-align:center;"><b>नेपाल टेलिकम</b></h3><br/> 
    <h5 style="text-align:center;margin-top:-20px;"><b>पदपूर्ति सचिवालय </b></h5> <br />
    <h5 style="text-align:center;margin-top:-20px;"><b>बैयक्तिक विवरण बापतको अंक तालिका</b> </h5>
    <img src="{{ public_path() . '/'.$intro_data[0]->photo }}" align="right" height="100" width="100" class="img-circle" style="margin-top: -100px;">    
   </div>
{{-- end of heading section --}}

{{-- start of personal information --}}
    <div class="intro" style="margin-left:10px;">
      <table border="0" class='table' id="tokentbl">
        <tbody> 
        <tr><td><label class=' pull-left'><b>सि.नं. : </b></label><span class='pull-left'>&nbsp;{{$sn}}</span></td>
        <td><label class=' pull-left'><b>कर्मचारी संकेत नं.: </b></label><span class='pull-left'>{{$intro_data[0]->nt_staff_code}}</span></td></tr> 
        <tr><td><label class='pull-left'><b>कर्मचरिको नाम : </b></label><span class='pull-left'>{{ $intro_data[0]->first_name_np }} {{ $intro_data[0]->mid_name_np }}{{$intro_data[0]->last_name_np }}</span></td>
        <td><label class=' pull-left'><b>लिङ्ग : </b></label><span class='pull-left'> {{$distance[0]->gender}} </span></td>
        <td><label class=' pull-left'><b>टोकन नं : </b></label><span class='pull-left'> {{$intro_data[0]->token_number}} </span></td></tr>
        <tr><td><label class=' pull-left'><b>हालको पद र तह : </b></label><span class='pull-left'> {{$intro_data[0]->current_post}},{{$intro_data[0]->current_work_level}}</span></td>
        <td><label class=' pull-left'><b>आवेदन गरेको पद र तह : </b></label><span class='pull-left'> {{$intro_data[0]->apply_designation}},{{$intro_data[0]->apply_work_level}}</span></td>     
        <td><label class=' pull-left'><b>बि.नं. : </b></label><span class='pull-left'> {{ $intro_data[0]->ad_no }}</span></td></tr>             
<tr><td><label class='pull-left'><b>सेवा समुह <?php if(!empty($intro_data[0]->current_service_sub_group)){ ?>र उपसमुह  <?php } ?>:</b></label><span class='pull-left'>{{$intro_data[0]->current_service_group}}<?php if(!empty($intro_data[0]->current_service_sub_group)){?>,{{$intro_data[0]->current_service_sub_group}} <?php } ?></span></td>
        <td><label class='pull-left'><b>स्थायि ठेगाना(जिल्ला) : </b></label><span class='pull-left'> {{ $intro_data[0]->perm_district }}</span></td>
        <td><label class=' pull-left'><b>गा.वि.स./न.पा. </b></label><span class='pull-left'> {{ $intro_data[0]->perm_local_level }}</span></td></tr>
        </tbody>
    </table>
</div>
<h4 style="text-align:center;">
    <b> अंक गणनाको अबधि @php
        echo $year;
        @endphp आषाढ़  मसान्तसम्म</b>
</h4>
<div class="seniority" style="margin-left:10px;margin-right:10px;">
    <h4> <b>१.जेष्ठता विवरण:</b> </h4>
    <table border="1" style="border-collapse: collapse;background-color: #f1f1c1;" class='table'>
    <thead><tr>
    <th style="text-align:center">बहाल रहेको कार्यालय</th><th colspan="5" style="text-align:center">(हालको पदको नोकरी विवरण)</th>
    <th style="text-align:center;width:7px;">जम्मा दिन</th><th style="text-align:center;width:7px;">वार्षिक अंकदर</th><th style="text-align:center">प्राप्तांक</th>
    <th style="text-align:center">कैफियत</th></tr>
    <tr><td></td><td style="text-align:center" colspan="2"><b> सेवा अवधि</b></td><td style="text-align:center"><b>वर्ष</b></td>
    <td style="text-align:center"><b>महिना</b></td><td style="text-align:center"><b>दिन</b></td><td></td><td></td><td></td><td></td>
    </tr>
    <tr><td></td><td style="text-align:center"><b>देखि</b></td><td style="text-align:center"><b>सम्म</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    </thead>
    <tbody>
     @foreach($seniority as $sha)
    <tr><td>{{ $sha->working_office }}</td><td>{{ $sha->seniority_date_bs }}</td><td>{{ $last_fiscal_year_ending_date[0]->date_to_bs }}</td>
     @php
    $date1 = $sha->seniority_date_ad;$date2 = $last_fiscal_year_ending_date[0]->date_to_ad ;$diff = abs(strtotime($date2) - strtotime($date1));
    $years = floor($diff / (365*60*60*24));$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));$days = (floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24))+1);
    $annualmarks= $annual_marks_for_seniority[0]->annual_marks_rate;
    $totaldays5 = floor($diff/(60*60*24));$days5=$totaldays5+1;$marks_in_year=(($days5*$annualmarks)/365);$total_months=floor($days5/ (30));
    if($total_months < $min_duration_months_for_seniority[0]->min_duration_months){$received_point=0;}else{$received_point=round($marks_in_year,3);}       
    @endphp
    <td>{{$years }}</td><td>{{$months }}</td><td>{{ $days }}</td><td><b>{{$days5 }}</b></td>
    <td>{{ $annual_marks_for_seniority[0]->annual_marks_rate }}</td><td>{{ $received_point }}</td><td>{{ $sha->remarks }}</td>
    </tr>
    @endforeach        
    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>जम्मा</b></td>
       @if(!empty($absent_leave_calculation)&&!empty($non_standard_leav))
         @php $absent_point=$salc_point;$non_standard_point=$snsl_point;$total_point_after_deduction_seniority=Round($received_point-($absent_point+$non_standard_point),3);@endphp
          {{-- absent calculation --}}
         @elseif(!empty($absent_leave_calculation)) @php $absent_point=$salc_point;$total_point_after_deduction_seniority=$received_point-$absent_point;@endphp
         {{-- non_standard_leav calculation --}}
         @elseif(!empty($non_standard_leav))@php $non_standard_point=$snsl_point;$total_point_after_deduction_seniority=$received_point-$non_standard_point; @endphp
         @else
         @php $total_point_after_deduction_seniority=$received_point;@endphp
       @endif
   
        @if($total_point_after_deduction_seniority >=$max_obtainable_marks_for_seniority[0]->max_marks_obtainable)
          @php $total_point_after_deduction_seniority=$max_obtainable_marks_for_seniority[0]->max_marks_obtainable;@endphp
          @else @php $total_point_after_deduction_seniority; @endphp
        @endif 
       <td><b>{{ $total_point_after_deduction_seniority }}</b></td>
       @if(!empty($absent_leave_calculation)&&!empty($non_standard_leav))
         <td><b>Both A &L deducted</b></td>
         @elseif(!empty($absent_leave_calculation))
         <td><b> A deducted</b></td>
         @elseif(!empty($non_standard_leav))
         <td><b> L deducted</b></td>
         @else
         <td></td>
       @endif
    </tr> 
 </tbody>
    </table>
</div>
<div><h4><b>
<span style="color:red;">@if(!empty($absent_leave_calculation))Absent:A;@endif</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="color:blue;">@if(!empty($non_standard_leav))Non-Standard_Leave:L;@endif</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="color:green;">@if(!empty($leave_calculation))Education Leave Point:Ep;@endif</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="color:brown;">@if(!empty($total_punishment_days))Punishment:p;@endif</span></b></h4></div>

{{-- end of seniority --}}

{{-- start of geography --}}
<div class="geography" style="margin-left:10px;margin-right:10px;">
    <h4><b>२.भौगोलिक क्षेत्रमा काम गरेको जिल्ला:</b></h4>
    <table border="1" style="border-collapse: collapse;background-color: #f1f1c1;" class='table'>
            <thead>
              <tr>
                <th>कार्यालयहरु</th><th>वर्ग</th>   
                <th colspan="5">(रुजु हाजिर भएको अवधि अध्ययन बिदा,असाधारण बिदा लिएको अवधि बाहेक)</th>
                <th style="text-align:center;width:7px;">जम्मा दिन</th>
                <th style="width:7px;">वार्षिक अंकदर</th>
                <th>प्राप्तांक</th><th>कुल प्राप्तांक</th><th>प्रमाणित कोष</th><th style="text-align:center">कैफियत</th>
             </tr>
             <tr>
                <td></td><td></td>
                <td style="text-align:center"><b>देखि</b></td><td style="text-align:center"><b>सम्म</b></td>  
                <td style="text-align:center"><b>वर्ष</b></td><td style="text-align:center"><b>महिना</b></td><td style="text-align:center"><b>दिन</b></td>   
                <td></td><td></td><td></td><td></td><td></td><td></td>
             </tr>
            </thead>
        <tbody>
         @php $sum = 0; $add_days=0; $number=0;$len=count($distance); @endphp
        @foreach ($distance as $item)
        <tr><td>{{ $item->working_office }}</td><td>{{ $item->varga }}</td><td>{{ $item->start_date_bs }}</td><td>{{ $item->last_date_bs }}</td>
        @php
                 $date1 = $item->start_date_ad;
                 $date2 = $item->last_date_ad;
                 $tdays=$item->difference_in_days; 
                 $diff = abs(strtotime($date2) - strtotime($date1));
                 $years = floor($diff / (365*60*60*24));//years_calculation 
                 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));//months_calculation 
                 $days = (floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24))+1);//days_calculation   
                 $annualmarks_for_geography=$item->annual_rate;//annual_marks_by_gender and varga  
                 $totaldays=$tdays+1;//after adding margin
                 if($totaldays<$min_days_for_geographical){
                   $totaldays=0; $annualmarks_for_geography=0;$total_received_point_geographical=0;$item->distance_point=0;
                   }     
                 else {$totaldays=$totaldays+$item->carry_over_days;}
                 if($item->carry_prev_days>0){$totaldays=$totaldays+$item->carry_prev_days;}
                 $particular_working= (($totaldays*$annualmarks_for_geography)/365);
                // if($totaldays<$min_days_for_geographical){$particular_working=(($totaldays*$annual_rate_with_case_of_min_days)/365);}//in case of if total days is less than min days
                 $received_point_geographical=round($particular_working,3); //received_point_in_particular_office  
                 $total_received_point_geographical=$received_point_geographical;
                 $min_duration_days=($min_duration_months_for_geographic[0]->min_duration_months)*30;
                 $sum+= $total_received_point_geographical;
                 $addsum=round($sum,3);
                 $total_point_after_adding=$addsum;
                 $max_marks= $max_marks_obtainable_for_geographic[0]->max_marks_obtainable;
                 if($addsum >=$max_marks){$addsum=$max_marks;}
                 $add_days+=$totaldays;
                 $grand_total_days=round( $add_days,3);//sum of total working days from all office
                  @endphp
                 <td>{{$years }}</td><td>{{$months }}</td><td>{{ $days }}</td> 
                 <td><b>{{ $totaldays }}</b></td>
                 <td>{{ $annualmarks_for_geography }}</td>
                 <td>{{ $total_received_point_geographical }}</td>
                <td></td> <td> {{$item->distance_km}}</td><td></td>
                </tr>
            @endforeach
              <tr>
                <td></td><td></td><td></td><td></td><td></td> <td></td>
                <td><b>जम्मा</b></td>    
                <td><b>{{ $grand_total_days }}</b></td>
                <td><b>जम्मा</b></td>
              <td>{{$total_point_after_adding}}</td>


              @if(!empty($non_standard_leav)&&!empty($leave_calculation)&&!empty($absent_leave_calculation))
              @php
              $absent_point=$alc_point;$non_standard_point=$nsl_point;
              $total_absent_point= $absent_point+ $non_standard_point;
              $particular_office_point=$working_office_point;
              $leave_point_after_excluding=$lc_point;
              $total_point_after_education=$total_point_after_adding-$particular_office_point+ $leave_point_after_excluding;
              $total_education_point=$total_point_after_education-$total_absent_point;
              $total_point_after_deduction=Round($total_education_point,3);
              @endphp   
              @elseif(!empty($non_standard_leav)&&!empty($leave_calculation))
              @php
                    $non_standard_point=$nsl_point;
                    $particular_office_point=$working_office_point;
                    $leave_point_after_excluding=$lc_point;
                    $total_point_after_education=$total_point_after_adding-$particular_office_point+ $leave_point_after_excluding;
                    $total_point_after_calculation=$total_point_after_education-$non_standard_point;
                  $total_point_after_deduction=Round($total_point_after_calculation,3);
              @endphp
              @elseif(!empty($absent_leave_calculation)&&!empty($leave_calculation))
                    @php
                    $absent_point=$alc_point;

                    $particular_office_point=$working_office_point;
                    $leave_point_after_excluding=$lc_point;
                    $total_point_after_education=$total_point_after_adding-$particular_office_point+ $leave_point_after_excluding;
                    $point_after_absent=$total_point_after_education-$absent_point;
                    $total_point_after_deduction=Round($point_after_absent,3);
                   // $total_point_after_deduction=Round(($total_point_after_adding-$leave_calculation[0]->total_working_office_point+$grand_total_of_education_leave),2)-$absent_spent_in_working_office[0]->total_absent_point;
                    @endphp
              @elseif(!empty($absent_leave_calculation)&&!empty($non_standard_leav))
             @php
                  $absent_point=$alc_point;
                  $non_standard_point=$nsl_point; 
                  $total_point_after_deduction=Round($total_point_after_adding-($absent_point+$non_standard_point),3);
             @endphp
              @elseif(!empty($leave_calculation))
            
              @php
              $particular_office_point=$working_office_point;
              $leave_point_after_excluding=$lc_point;
              $total_point_after_education=$total_point_after_adding-$particular_office_point+ $leave_point_after_excluding;  
              $total_point_after_deduction=Round($total_point_after_education,3);
             
              @endphp
            
              @elseif(!empty($non_standard_leav))
                   @php
                    // $total_point_after_deduction_non_standard_leave=$non_standard_leav[0]->total_point_after_deduction;  
                    $total_point_after_deduction_non_standard_leave=$nsl_point;  
             
                    $total_point_after_deduction=Round(($total_point_after_adding-$total_point_after_deduction_non_standard_leave),3);    
                    @endphp
              @elseif(!empty($absent_leave_calculation))
              @php
              $absent_point=$alc_point;
              $total_point_after_deduction=$total_point_after_adding-$absent_point;
              @endphp
              @else
              @php
                     $total_point_after_deduction=$total_point_after_adding;
                 @endphp
             @endif

            @if($total_point_after_deduction>=$max_marks) @php $total_point_after_deduction=$max_marks; @endphp  
            @else @php $total_point_after_deduction; @endphp 
            @endif 
            <td><b>{{$total_point_after_deduction}}</b></td><td></td>
                @if(!empty($non_standard_leav)&&!empty($leave_calculation)&&!empty($absent_leave_calculation))
                <td><b>A,L & Ep Deducted</b></td>
                @elseif(!empty($non_standard_leav)&&!empty($leave_calculation))
                <td><b>Both L & Ep Deducted</b></td>
                @elseif(!empty($absent_leave_calculation)&&!empty($leave_calculation))
                <td><b>Both A & Ep Deducted</b></td>
                @elseif(!empty($absent_leave_calculation)&&!empty($non_standard_leav))
                <td><b>Both A & L Deducted</b></td>
                @elseif(!empty($leave_calculation))
                <td><b>Ep Deducted</b></td>
                @elseif(!empty($non_standard_leav))
                <td><b>L Deducted</b></td>
                @elseif(!empty($absent_leave_calculation))
                <td><b>A Deducted</b></td>
                @else
                <td></td>
                @endif
            </tr>
        </tbody>
    </table>
</div>
{{-- end of geography --}}

{{-- start of office_incharge --}}
@if(!empty($office_incharge))
<div class="office" style="margin-left:10px;margin-right:10px;">
    <h4><b> ३.कार्यालय प्रमुख भई कार्यरत रहेको कार्यालय: </b> </h4>
    <table border="1" style="border-collapse: collapse;background-color: #f1f1c1;" class='table'>
            <thead>
              <tr>
                <th style="text-align:center">कार्यालय</th>
                <th colspan="5">हालको पदमा का. प्र.भई कार्य गरेको विवरण</th>
                <th style="text-align:center;width:7px;">जम्मा दिन</th>
                <th style="width:7px;">वार्षिक अंकदर</th>
                <th>प्राप्तांक</th>
                <th>कुल प्राप्तांक</th>
                <th>प्रमाणित कोष</th>
              </tr>
              <tr>
                <td></td>
                <td style="text-align:center;"><b style="padding:25px;">देखि</b></td>
                <td style="text-align:center"><b style="padding:25px;">सम्म</b> </td>
                <td style="text-align:center"><b>वर्ष</b> </td><td style="text-align:center"> <b>महिना</b></td><td style="text-align:center"><b>दिन</b></td>   
                <td></td><td></td><td></td><td></td><td></td> 
              </tr>
            </thead>
        <tbody>
        @php $totalsum = 0;$totaldays=0;$total_received_point=0;@endphp
            @foreach($office_incharge as $oi)
            <tr>
                <td>{{ $oi->working_office }}</td>
                <td>{{ $oi->incharge_date_from_bs }}</td>
                <td>{{ $oi->last_incharge_date_bs }}</td>
             
                @php
                $date1 = $oi->incharge_date_from_ad;
                $date2 = $oi->last_incharge_date_ad;
                $diff5 = abs(strtotime($date2) - strtotime($date1));
//calculation in years,months,days
                $years = floor($diff5 / (365*60*60*24));
                $months = floor(($diff5 - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff5 - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
                $totalinchargedays = floor($diff5/ (60*60*24));    
                $inchargetotaldays =$totalinchargedays+1;
                $incharge_annual_marks= $annual_marks_for_office_incharge[0]->annual_marks_rate;
                $marks_in_year_for_incharge=(($inchargetotaldays*$incharge_annual_marks)/365); 
                $totalsum+=$marks_in_year_for_incharge;
                $totaladd=round($totalsum,3);
                $totaldays+=$inchargetotaldays;//incharge_total_days-after_adding
                if($inchargetotaldays <=$min_days_for_office_incharge){$received_point_incharge=0;}else{$received_point_incharge=round($marks_in_year_for_incharge,3);}
                $total_received_point+=$received_point_incharge;
               @endphp
                <td>{{ $years }}</td><td>{{ $months }}</td><td>{{ $days }}</td><td><b>{{ $inchargetotaldays }}</b></td>
                <td>{{ $annual_marks_for_office_incharge[0]->annual_marks_rate }}</td><td>{{ $received_point_incharge }}</td>
                <td></td><td></td>              
            </tr>
            @endforeach
            @php  $grand_tdays=$totaldays; @endphp                           
    <tr><td></td><td></td><td></td><td></td><td></td><td><b>जम्मा</b></td><td><b>{{$grand_tdays}}</b></td><td></td><td><b>जम्मा</b></td>     
      @php 
      $total_received_point_incharge= $total_received_point;     
      $totaladd=round($total_received_point_incharge,3);
      if( $totaladd<floor($annual_marks_for_office_incharge[0]->annual_marks_rate)/2){$totaladd=0;}
      if( $totaladd>floor($max_marks_obtainable_for_office_incharge[0]->max_marks_obtainable)){$totaladd=$max_marks_obtainable_for_office_incharge[0]->max_marks_obtainable;}
      @endphp
      <td><b>{{ $totaladd }}</b></td><td></td>            
    </tr>
    </tbody>
    </table>
</div>
@endif
{{-- end of office_incharge --}}

{{-- start of education --}}
@if(!empty($applied_education_details_minimum) || !empty($education_details_maximum))
<div class="education" style="margin-left:10px;margin-right:10px;">
    <h4> <b>४. शैक्षिक योग्यतासम्बन्धी विवरण: </b> </h4>
    <table border="1" class='table' style="border-collapse: collapse;background-color: #f1f1c1;">
        <thead>
            <tr>
                <th style="text-align:center">योग्यता</th>
                {{-- <th>तोकिएको शैक्षिक योग्यता</th> --}}
                <th rowspan="2">उपाधिको नाम र बिषय</th>
                <th>श्रेणी</th>
                <th>प्राप्तांक</th>
                <th rowspan="2">कुल प्राप्तांक</th>
                <th>कैफियत</th>
            </tr>
        </thead>
        <tbody>
              <tr>
                <td><b>न्युनतम शैक्षिक योग्यता</b></td>     
                {{-- <td>@php foreach($min_education_requirements as $item){ echo$item->degree_name.",\n";}@endphp </td> --}}
                <td>{{ $applied_education_details_minimum[0]->degree_name }}<br/>{{ $applied_education_details_minimum[0]->specialization }}</td>
                <td>{{ $applied_education_details_minimum[0]->division }}</td>
                <td>{{ $applied_education_details_minimum[0]->points }}</td>
                <td></td><td></td>  
              </tr>
            @php $total_max_edu=0;@endphp
            @foreach ($education_details_maximum as $max_degree)
            <tr>
            <td><b> न्युनतम भन्दा माथिको सम्बन्धित बिषयको एक शैक्षिक उपाधि</b></td>
            <td>{{ $max_degree->degree_name }}<br/>{{ $max_degree->specialization }}</td> 
            <td>{{$max_degree->division }}</td><td>{{ $max_degree->additional_points }}</td><td></td><td></td>
            </tr> 
            @php
            $total_max_edu+=$max_degree->additional_points;
            $totaladd_edu=round($total_max_edu,3);
            @endphp
            @endforeach
            @php $tep=$totaladd_edu+$applied_education_details_minimum[0]->points; @endphp
            @if($tep>$max_marks_obtainable_for_education[0]->max_marks_obtainable)
            @php $tep=$max_marks_obtainable_for_education[0]->max_marks_obtainable; @endphp   
            @endif
            <tr><td></td><td></td><td></td><td><b>जम्मा</b></td><td><b> {{$tep}}</b></td><td></td></tr>    
        </tbody>
    </table>
</div>
@endif
{{-- end of education --}}

{{-- start of summary --}}
<div class="summary" style="margin-left:10px;margin-right:10px;">
    <table border="0" class='table' id="tokentbl">
        <tbody>
            <tr><td><label class=' pull-left'><b>१.जेष्ठता प्राप्तांक:</b></label><span class='pull-left'>{{ $total_point_after_deduction_seniority }}</span></td> 
            <td></td><td><label class=' pull-left'><b>तयार गर्ने:</b></label><span class='pull-left'></span></td>
            </tr>
            <tr>
            <td><label class='pull-left'><b>२.भौगोलिक क्षेत्रको प्राप्तांक : </b></label><span class='pull-left'>{{ $total_point_after_deduction }}</span></td><td></td>
            <td><label class='col-md-4 pull-left'><b>रुजु गर्ने: </b></label><span class='pull-left'> </span></td>  
            </tr>
            <tr>
            <td><label class=' pull-left'><b>३.का. प्र.वापतको अंक: </b></label><span class='pull-left'>{{ $totaladd }}</span></td>
            <td></td><td></td>       
            </tr>
            <tr>
            <td><label class=' pull-left'><b>४.शैक्षिक योग्यता वापत अंक : </b></label><span class='pull-left'> {{ $tep }}</span></td> 
            <td></td><td><label class=' pull-left'><b>प्रमाणित गर्ने: </b></label><span class='pull-left'> </span></td>
            </tr>
            <tr>
            <td><label class=' pull-left'><b>जम्मा अंक: </b></label><span class='pull-left'><b>{{ $total_point_after_deduction_seniority+$addsum+$totaladd+$tep }}</b></span></td>     
            </tr>
        </tbody>
    </table>
</div>
{{-- end of summary --}}

<!-- insert into evaluation table -->
<?php
// dd(date("m/d/Y h:i:s", time()));
// deleting data
if(isset($intro_data[0]->applicant_id)){
    DB::table('applicant_evaluation_marks')->where('token_number', '=', $intro_data[0]->token_number)->delete();
    // inserting new points
    $data = array(
        'applicant_id' => $intro_data[0]->applicant_id
        ,'token_number'=>$intro_data[0]->token_number
        , 'seniority_marks' => $received_point
        , 'incharge_marks' => $totaladd
        , 'geographical_marks' => $addsum
        , 'qualification_marks' => $tep
        , 'total_marks' => $received_point+$addsum+$totaladd+$tep
        , 'min_edu_degree_id'=> $applied_education_details_minimum[0]->degree_id
        , 'min_division_id'=>$applied_education_details_minimum[0]->division_id
        , 'max_edu_degree_id'=>$education_details_maximum[0]->degree_id
        , 'max_division_id'=>$education_details_maximum[0]->division_id
    );
    DB::table('applicant_evaluation_marks')->insert($data);
}

 ?>

{{-- start of leave_duration --}}
@if(!empty($leave_calculation))
<div class="leave" style="margin-left:10px;margin-right:10px;">
    <h4 style="text-align:center"> <b> विदासम्बन्धी विवरण: </b> </h4>
    <table border="1" class='table' style="border-collapse: collapse;background-color: #f1f1c1;">
        <thead>
        <tr><th style="text-align:center">कार्यालय</th><th style="text-align:center">बिदाको किसिम</th><th colspan="2" style="text-align:center">बिदाको अवधि</th><th style="text-align:center">जम्मा दिन</th>
            <th style="text-align:center;width:7px;">वार्षिक अंकदर</th><th style="text-align:center">प्राप्तांक</th></tr> 
        <tr><td></td><td></td><td style="text-align:center"><b>देखि</b></td><td style="text-align:center"><b>सम्म</b></td><td></td><td></td><td></td></tr>    
        </thead>
        <tbody> 
            @foreach ($leave_calculation as $educ)
            <tr><td>{{ $educ->working_office }}</td><td>{{ $educ->name_np }}</td><td>{{ $educ->date_from_bs }}</td><td>{{ $educ->date_to_bs }}
                    <td>{{ $educ->difference_in_days }}</td>
                    <td>{{$least_point}}</td><td>{{$educ->education_absent_point}}</td>
                    </tr> 
            @endforeach          
        </tbody>
    </table>
</div>
@endif
{{-- end of leave_duration --}}
{{-- start of punishment_details --}}
@if(!empty($non_standard_leav))
<div class="leave" style="margin-left:10px;margin-right:10px;">
    <h4 style="text-align:center"> <b> असाधारण बिदा सम्बन्धि विवरण: </b> </h4>
    <table border="1" class='table' style="border-collapse: collapse;background-color: #f1f1c1;">
        <thead><tr><th style="text-align:center">बिदाको किसिम</th><th style="text-align:center">कार्यालय</th><th colspan="2" style="text-align:center">बिदाको अवधि</th>
                <th style="text-align:center">जम्मा दिन</th>
                <th colspan="6" style="text-align:center">बिदा सम्बन्धि विवरण</th>
              </tr>
            <tr><td></td><td></td><td style="text-align:center"><b>देखि</b></td><td style="text-align:center"><b>सम्म</b></td><td></td> <td colspan="3" style="text-align:center"><b>जेष्ठता अनुसार</b></td><td colspan="3" style="text-align:center"><b>भौगोलिक क्षेत्र अनुसार</b></td> </tr>
            <tr><td></td><td></td><td></td><td></td><td></td><td><b>अंकदर</b></td><td><b>प्राप्तांक</b></td><td><b>कुल प्राप्तांक</b></td><td><b>अंकदर</b></td><td><b>प्राप्तांक</b></td><td><b>कुल प्राप्तांक</b></td></tr>     
        </thead>
        <tbody>
            @foreach ($non_standard_leav as $nsl)
              <tr><td>{{ $nsl->name_np }}</td><td>{{ $nsl->working_office }}</td><td>{{ $nsl->date_from_bs }}</td><td>{{ $nsl->date_to_bs }}</td>
                  <td>{{ $nsl->difference_in_days }}</td>
                  <td>{{ $nsl->seniority_rate }}</td><td>{{ $nsl->seniority_points }}</td><td></td>
                  <td>{{ $nsl->rate }}</td><td>{{ $nsl->education_absent_point }}</td><td></td> 
                   
              </tr>
            @endforeach
            <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b>जम्मा</b></td><td><b>{{$snsl_point}}</b></td><td></td> <td><b>जम्मा</b></td><td><b>{{$nsl_point}}</b></td></tr>         
        </tbody>
    </table>
</div>
@endif
{{-- end of punishment_details --}}

{{-- start of absent_details --}}
@if(!empty($absent_leave_calculation))
<div class="leave" style="margin-left:10px;margin-right:10px;">
    <h4 style="text-align:center"> <b> अनुपस्थिति सम्बन्धि विवरण: </b> </h4>
    <table border="1" class='table' style="border-collapse: collapse;background-color: #f1f1c1;">
      <thead>      
        <tr><th style="text-align:center">कार्यालय</th><th colspan="2" style="text-align:center">अनुपस्थिति कारवाहीको अवधि</th><th style="text-align:center">जम्मा दिन</th>
            <th colspan="6" style="text-align:center">अनुपस्थिति कारवाहीको बिवरण</th>
            {{-- <th style="text-align:center;width:7px;">वार्षिक अंकदर</th><th style="text-align:center">प्राप्तांक</th><th style="text-align:center">कुल प्राप्तांक</th>  --}}
        </tr>
        <tr><td></td><td style="text-align:center"><b>देखि</b></td><td style="text-align:center"><b>सम्म</b></td><td></td>  
            <td colspan="3" style="text-align:center"><b>जेष्ठता अनुसार</b></td><td colspan="3" style="text-align:center"><b>भौगोलिक क्षेत्र अनुसार</b></td></tr>  
            <tr><td></td><td></td><td></td><td></td><td><b>अंकदर</b></td><td><b>प्राप्तांक</b></td><td><b>कुल प्राप्तांक</b></td><td><b>अंकदर</b></td><td><b>प्राप्तांक</b></td><td><b>कुल प्राप्तांक</b></td></tr>     
      </thead><tbody>
         @foreach ($absent_leave_calculation as $absent)
          <tr>
              <td>{{ $absent->working_office }}</td>
            <td>{{ $absent->date_from_bs }}</td><td>{{ $absent->date_to_bs }}</td><td>{{ $absent->difference_in_days }}</td>    
            <td>{{$absent->seniority_rate}}</td><td>{{$absent->seniority_points}}</td><td></td>
            <td>{{$absent->rate}}</td><td>{{$absent->education_absent_point}}</td><td></td>
          </tr>
        @endforeach
        <tr><td></td><td></td><td></td><td></td><td></td><td><b>जम्मा</b></td><td><b>{{$salc_point}}</b></td><td></td><td><b>जम्मा</b></td><td><b>{{$alc_point}}</b></td></tr> 
        </tbody>
    </table>
</div>
@endif
{{-- end of absent_details --}}
<div class='row' style="margin:0px;">
<h4 class="col-md-6" style="text-align:left"> <b> Printed By:{{ $name }}</b></h4><h4 class="col-md-6" style="text-align:right"> <b> Printed Date:{{ $format }}</b></h4>
</div>

</div>
</section>

</body>