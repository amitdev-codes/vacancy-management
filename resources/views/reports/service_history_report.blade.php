<!DOCTYPE html>
<html>
<head>
<link href="<?php echo public_path('/css/bootstrap.min.css'); ?>"  rel="stylesheet" type="text/css" />
<style>
li{
    list-style-type:decimal;
}
.pull-left{
    float:left;
   
}
span{    width: 50% !important;
    float: left;
}
table{
    /* border:1px solid; */
    margin-left:20px;
    margin-bottom:20px;
}
tr,td,table{
    /* border:1px solid; */
}
</style>
<style>
 @font-face { font-family: "Mangal";  src: url({{ URL::asset("fonts/mangal.ttf")}}) format("truetype"); }
</style>
</head>
<body  style="font-family:Mangal">
<Section>
<div class='container'>
<h3 style="text-align:center">Applicant Service History</h3>

<img style="height:150px; width:150px;margin-top:0px;margin-left: 690px;position: absolute;border: 1px solid;" src="{{ public_path() . '/'.$apply_info->photo }}" />
<img style="height:50px; width:150px;margin-top:164px;margin-left: 690px;position: absolute;" src="{{ public_path() . '/'.$apply_info->signature_upload }}" />

<table width="75%">
<tr >
    <td>Employee code: {{$apply_info->nt_staff_code}}</td>
    <td>Token Number:{{$apply_info->token_number}}</td> 
</tr>
<tr >
    <td>Name: {{$apply_info->name_en}}</td>
    <td>Applied for Designation:{{$apply_info->designation_en}}</td> 
</tr>
<tr >
    <td>Current Designation:  {{$current_position->designation}}</td>
    <td>Applied for level:{{$apply_info->work_level}}</td> 
</tr>
<tr >
    <td>Current Level:  {{$current_position->work_level}}</td>
    <td>Service Group:{{$apply_info->service_group}}</td> 
</tr>
</table>

<ul>
<li>
<p>Working Offices:</p>
<ul>
@foreach($service_history as $sh)
<li>{{$sh->working_office}} ({{$sh->date_from_bs}} To {{$sh->date_to_bs}})</li>
@endforeach

</ul>
</li>
<li>
<p>रमाना पत्र :</p>
<ul>
@foreach($service_history as $sh)
@if($sh->leave_letter!=null)
<li>
<img style="height:400px; width:400px;margin-top:10px;" src="{{ public_path() . '/'.$sh->leave_letter }}" />

</li>
@endif
@endforeach
</ul>
</li>
<li>
<p>कोष प्रमाणित पत्र :</p>
<ul>
@foreach($service_history as $sh)
@if($sh->distance_certificate!=null)
<li>
<img style="height:400px; width:400px;margin-top:10px;" src="{{ public_path() . '/'.$sh->distance_certificate }}" />

</li>
@endif
@endforeach
</ul>
</li>
<li>
<p>नियुक्ति पत्र ( हालको पदको )</p>
<ul>
@foreach($service_history as $sh)
@if($sh->is_current==1)
<li>
<img style="height:400px; width:400px;margin-top:10px;" src="{{ public_path() . '/'.$sh->appointment_letter }}" />

</li>
@endif
@endforeach
</ul>
</li>
<li>
<p>Office Incharge:</p>
<ul>
@foreach($service_history as $sh)
@if($sh->is_office_incharge==1)
<li>
{{$sh->working_office}}({{$sh->incharge_date_from_bs}} To {{$sh->incharge_date_to_bs}})
</li>
@endif
@endforeach
</ul>
</li>
<li>
<p>Qualification:</p>
<ul>
@foreach($service_history as $sh)
    @if($sh->is_current==1)
        @if($sh->minimum_qualification_degree!=null)
        <li>
        {{$sh->minimum_qualification_degree}}
        </li>
            @if($sh->minimum_qualification_upload!=null)
            <img style="height:400px; width:400px;margin-top:10px;" src="{{ public_path() . '/'.$sh->minimum_qualification_upload }}" />
            @endif
            
            @if($sh->additional_qualification_degree!=null) 
            <li>
            {{$sh->additional_qualification_degree}}
            </li>
                @if($sh->additional_qualification_upload!=null)
                <img style="height:400px; width:400px;margin-top:10px;" src="{{ public_path() . '/'.$sh->additional_qualification_upload }}" />
                @endif  
            @endif
        @else
        @foreach($education as $ed)
        <li>
        {{$ed->name_en}}
        </li>
        <img style="height:400px; width:400px;margin-top:10px;" src="{{ public_path() . '/'.$ed->certificate_1 }}" />
        
        @endforeach
        @endif
    @endif
@endforeach
</ul>
</li>
<li>


</li>
</ul>
</div>
</Section>
</body>
</html>
<!-- <h1>Applicant apply Info</h1>
<div class="container-fluid">
        <div class="table-responsive">
            <table class="table">
                    <tr>
                        <td>Name:</td>
                        <td>{{$apply_info->name_en}}</td>
                    </tr>
                </tbody>
</table> -->
