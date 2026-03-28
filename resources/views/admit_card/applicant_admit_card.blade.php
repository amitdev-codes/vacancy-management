<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="{{asset('css/admit_card.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.css')}}" rel="stylesheet"
        type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{asset('vendor/crudbooster/assets/adminlte/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
        type="text/css" />
</head>
<style>
    @font-face {
        font-family: "Mangal";
        src: url({{ URL::asset("fonts/mangal.ttf")}}) format("truetype");
    }
</style>

<body>
    @foreach($admit_card as $value)
      <div class="admit_card" style="font-family:Mangal;height:auto">
        <header>
            <div class="logo">
                <img src='{{asset("/img/logo.png")}}' style="width: 100%">
            </div>
            <div class="heading">
                <h1 style="margin-bottom: -38px"> नेपाल टेलिकम</h1>
                <br>
                <h3 style="margin-left: -21px; font-size: 23px;font-weight: 300;">( नेपाल दूरसंचार कम्पनी लिमिटेड)</h3>
                <h2 style="text-decoration: underline; text-indent: 50px; margin-top: 10px;margin-bottom:0px;">प्रवेशपत्र</h2>
                @if($opening_type->id==1)
                <h3 style="text-decoration: underline; margin-top: 0px;">खुला/समावेशी परीक्षा</h3>
                @else
                <h3 style="text-decoration: underline; margin-top: 10px;margin-left:-40px;margin-bottom:0px;">आन्तरिक प्रतियोगितात्मक
                    परीक्षा</h3>
                @endif
            </div>
            <div class="photo" style="padding: 5px;">
                <img src="{{asset($value->photo)}}">
                <img style="height:40px; width:150px;margin-top:20px;" src="{{asset($value->signature_sample)}}" />
            </div>
            <img src='{{asset("/img/rajanSir.png")}}'
                style="height: 89px;width: 149px;margin-left: 641px;margin-top: -304px;">

        </header>
        <table>
            <thead>
                <tr>
                    <td style="float: left;">Applicant ID : {{$value->applicant_id}} </td>
                </tr>
                <tr>
                    <td colspan="3" style=" text-align: left; "><b>उम्मेदवारको नाम,थर:</b> {{$value->applicant_name}}
                    </td>
                    <td colspan="3" style=" text-align: left; "><b>नागरिकता नं/जारी जिल्ला:</b>
                        {{$value->citizenship_no}}/{{$value->citizenship_district}}
                </tr>
            </thead>

        </table>

        <table style="margin: 0px;">
            <tr>
            </tr>
            <tr>
                <th colspan="2"><b>रोल नम्बर:</b> {{$value->exam_roll_no}}</th>
            </tr>
        </table>
        <table style="margin:0px; width:100%; marign-bottom:2px;" class='center_details'>
            <th style="width:10%">बिज्ञापन नं.</th>
            <th style="width:25%">पद/सेवा/समूह/तह</th>
            @if($opening_type->id==1)
            <th style="width:10%">खुल्ला/ समावेशी समूह</th>
            @endif
            <th style="width:10%">पत्र</th>
            <th style="width:25%">केन्द्र</th>
            <th style="width:15%">मिति</th>
            <th style="width:10%">समय</th>
            <tr>

                <td rowspan="4">{{$value->ad_no}}</td>
                <td rowspan="4">{{$value->designation}}
                    -{{$value->work_service}}/{{$value->service_group}}/{{$value->work_level}}</td>
                @if($opening_type->id==1)
                   <td rowspan="4">
                             @php
                             if ($value->is_open==1) {echo "खुला";}
                             if ($value->is_female==1) { echo ", महिला";}
                             if ($value->is_janajati==1) {echo ", जनजाती";}
                             if ($value->is_dalit==1) {echo ", दलित";}
                             if ($value->is_madhesi==1) {echo ", मधेशी";}
                             if ($value->is_handicapped==1) {echo ", अपाङ्ग";}
                             if ($value->is_remote_village==1){ echo ", पिछडिएको क्षेत्र";}
                             @endphp
                  </td>
                @endif
                @for ($i=0;$i<@count($papers);$i++) <tr>
                    <td>{{$center_details['paper_name'][$i]}}</td>
                    <td>लोक सेवा आयोग,अनामनगर,काठमाण्डौ</td>
                    <td>{{$center_details['date'][$i]}}</td>
                    <td>{{$center_details['time'][$i]}}</td>
                   <tr>
                @endfor

            </tr>

        </table>
        <p style="text-align: justify; margin-top:auto;">नोट:यस कम्पनीबाट लिइने उक्त पदको परीक्षामा
            तपाइलाई सम्मिलित हुन अनुमति दिइएको छ। विज्ञापनमा तोकिएको सर्त नपुगेको ठहर भएमा जुनसुकै अवस्थामा पनि यो अनुमति रद्द हुनेछ।
              </p>
              <div class="photo" style="margin-left:-75px;float:right;height:30px;width:100px;margin-top:-13px;border:none">
                <img style="margin-right:75px;margin-top:-17px;float:right;width:127px;" src="{{asset('/img/rajanSir.png')}}" />
            </div>
              <h4 style="text-align:right">जारी गर्ने अधिकृतको नाम : राजन कुमार अधिकारी,प्रबन्धक </h4>
        @endforeach
        <hr class="dotted-line">
        <div style="clear:both;">
            <img src='{{asset("/img/exam_rules_2078.png")}}' style="width:100%;height:auto">

        </div>
  
</body>

</html>