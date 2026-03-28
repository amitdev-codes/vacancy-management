<html>
<head>
<meta charset="UTF-8">
  <title></title>
 <link href='{{asset("/css/admit_card.css")}}' rel="stylesheet" >
 <link href="{{ asset("vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.css") }}" rel="stylesheet" type="text/css" />
 <!-- Font Awesome Icons -->
 <link href="{{asset("vendor/crudbooster/assets/adminlte/font-awesome/css")}}/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
   @font-face { font-family: "Mangal";  src: url({{asset("/fonts/mangal.ttf")}}) format("truetype"); }
  </style>
<body >

@foreach($admit_card as $value)
<div class="admit_card" style="font-family:Mangal">
<header>
    <div class="logo">
        <img src='{{asset("/img/logo.png")}}' style="width: 100%">
    </div>
    <div class="heading">
        <h1 style="margin-bottom: -38px"> नेपाल टेलिकम</h1>
        <br>
        <h3 style="margin-left: -21px; font-size: 23px;font-weight: 300;">( नेपाल दुरसंचार कम्पनी )</h3>
        <h2 style="text-decoration: underline; text-indent: 50px; margin-top: 0px;">प्रवेशपत्र</h2>
        <h3 style="text-decoration: underline; margin-top: 0px;">खुल्ला/समावेशी परीक्षा</h3>
    </div>
    <div class="photo" style="padding: 5px;">
        <img src="{{asset($value->photo)}}">
         <img style="height:40px; width:150px;margin-top:20px;" src="{{asset($value->signature_sample)}}" />
    </div>
</header>
<table>
    <thead>
        <tr>
        <th style="text-decoration: underline; float: left;">Token No : {{$value->token_number}} </th>
        </tr>
        <tr>
        <td colspan="3" style=" text-align: left; "><b>उम्मेदवारको नाम,थर:</b>  {{$value->applicant_name}}</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><b> क) बिज्ञापन नं.:</b> {{$value->ad_no}}</td>
        </tr>
        <tr>
            <td><b>ख) पद:</b> {{$value->designation}}</b></td>
            <td><b>ग) तह:</b> {{$value->work_level}}</td>
        </tr>
        <tr>
            <td><b>घ) सेवा:</b> {{$value->work_service}}</td>
            <td><b>ङ) समूह:</b> {{$value->service_group}}</td>
        </tr>
        <tr>
            <td><b>च) उप - समूह:</b> {{$value->service_sub_group}}</td>
            <td colspan="2"><b> छ) खुल्ला/समावेशी समूह:</b></td>
        </tr>
        <tr>
        <td></td>
            <td>
            <span>
            <?php 
            if ($value->is_open==1) {echo "खुल्ला";}
            if ($value->is_female==1) { echo ", महिला";}
            if ($value->is_janajati==1) {echo ", जनजाती";}
            if ($value->is_dalit==1) {echo ", दलित";}
            if ($value->is_madhesi==1) {echo ", मधेशी";}
            if ($value->is_handicapped==1) {echo ", अपाङ्ग";}
            if ($value->is_remote_village==1){ echo ", पिछडिएको क्षेत्र";}
            
            ?>
            
            </span>
            </td>
        </tr>
    </tbody>
</table>

<label><u><b>कम्पनीको कर्मचारीले भर्ने:</b></u></label>
<table style="margin: 0px;" >
 <tr>
   <td><b>परीक्षा केन्द्र:</b> {{$value->exam_center}}</td>
   <td><b>जारी गर्ने अधिकृतको नाम: </b>राम प्रशाद हुमागाई</td>
 </tr>
 <tr>
   <td colspan="2"><b>रोल नम्बर:</b> {{$value->exam_roll_no}}</td>
 </tr>
 <tr>
   <td colspan="2"><b>परीक्षा मिति:</b> प्रथम पत्र:{{$value->exam_date_bs}}</td>
 </tr>
  <tr>
    <td style="padding-left: 120px;">द्दितीय पत्र:</td>
    
 </tr>
</table>
<p style="text-align: justify;">नोट: यस कम्पनीबाट लिईने उक्त पदको परीक्षामा तपाईलाई निम्न केन्द्रबाट सम्मिलित हुन अनुमति दिएको छ ।
 विज्ञापनमा तोकीएको शर्त नपुगेको ठहर भाएमा जुनसुकै अवस्थामा पनि यो अनुमति रद्द हुन सक्नेछ । </p>

@endforeach
<hr class="dotted-line">
<div style="clear: both;">
        <h4 style="text-align:center;"><b>उम्मेदवारले पालन गर्नु पर्ने शर्तहरु </b></h4>
<table class="table-rules">

  <tr><td> 1. उम्मेदवारले परीक्षा हलमा परीक्षा दिन आउँदा अनिवार्य रुपमा प्रवेशपत्र ल्याउनु पर्नेछ |प्रवेशपत्र विना परिक्षामा बस्न दिइने छैन |</td></tr>
  <tr><td> 2. लिखित परीक्षाको नतीजा प्रकाशित भएपछि अन्तरवार्ता हुने दिनमा पनि प्रवेशपत्र ल्याउनु अनिवार्य छ |</td></tr>
  <tr><td> 3. परीक्षा सुरु हुने 15 मिनेट अगाडी घण्टीद्धारा सुचना गरेपछि परीक्षा हलमा प्रवेश गर्न दिइने छ | वस्तुगत परीक्षा शुरु भएको 15 मिनेट पछि विषयगत परीक्षा शुरु भएको आधा घण्टा पछि आउने र वस्तुगत तथा विषयगत दुवै परीक्षामा सँगै हुनेमा 20 मिनेट पछि आउने उम्मेदवारले परीक्षामा बस्न पाउने छैन |</td></tr>
  <tr><td> 4. हलमा किताब, कापि, कागज, चिट आदि लैजानु हुदैन | उम्मेदवारले आपसमा कुराकानी र संकेत गर्नु हुदैन साथै मोवाइल फोन प्रयोग गर्न पार्इदैन |</td></tr>
  <tr><td> 5. परीक्षाहलमा परीक्षाको मर्यादा विपरीत उम्मेदवारले कुनै काम गरेमा केन्द्राध्यक्षले परीक्षा हलबाट निष्काशन गरी तुरुन्त कानुन बमोजिम कारवाही गर्नेछ र त्यसरी निष्काशन गरिएको उम्मेदवारको सो दिनको परीक्षा स्वत: रद्ध भएको मानिनेछ |</td></tr>
  <tr><td> 6. बिरामी भएको उम्मेदवारले परीक्षा हलमा प्रवेश गरी परीक्षा दिने क्रममा निजलार्इ केहि भएमा कम्पनी जवाफदेही हुने छैन |</td></tr>
  <tr><td> 7. परीक्षा दिर्इरहेको समयमा कुनै उम्मेदवारको नाममा चिट्ठी, फोन, बीमा आदी प्राप्त भएमा उम्मेदवारले उत्तरकापी बझाए पछी मात्र निजलार्इ सो कुराको जानकारी गरार्इने छ |</td></tr>
  <tr><td> 8. उम्मेदवारले आफुले परीक्षा दिएको दिनमा आफ्नो हाजिर गर्न छुट भएमा तुरुन्त केन्द्राध्यक्षलार्इ खबर गरी हाजिर गर्नु गर्नेछ |</td></tr>
  <tr><td> 9. कम्पनीले सुचनाद्धारा निर्धारण गरेको कार्यक्रम अनुसार परीक्षा संचालन हुनेछ |</td></tr>
  <tr><td> 10. परीक्षा हल भित्र हल्ला हुन दिनु हुदैन | कुनै उम्मेदवारले प्रश्नपत्रमा रहेको अस्पष्टताको सम्बन्धमा सोध्नु पर्दा पनि परीक्षामा सम्मिलित अन्य उम्मेदवारहरुलार्इ बाधा नपर्ने गरी सोध्ने पर्नेछ |</td></tr>
  <tr></tr><td> 11. परीक्षा सम्बन्धमा तोकिएको अन्य सबै शर्तहरु पालना गर्नु पर्नेछ |</td></tr>
</table>
</div>

</body>
</html>
