<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title></title>
  <link href="http://vaars3.test/vendor/crudbooster/assets/adminlte/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
  .admit_card {
    padding: 25px;
    width: 850px;
  }

  header {
    text-align: center;
  }

  .logo {
    float: left;
    clear: right;
  }

  .heading {
    text-align: center;
    float: left;
    clear: right;
    margin-left: 20%;
  }

  .photo {
    float: right;
  }

  .box {
    width: 127px;
    height: 30px;
    border: 1px solid #000;
    margin-left: 3px;
    margin-bottom: 20px;
  }

  caption {
    text-align: left;
    margin-bottom: 5px;
  }

  @font-face {
    font-family: kalimati;
    src: url({{ URL::asset("fonts/kalimati.ttf")}}) format("truetype");

  }

  .nepali_td {
    font-family: kalimati;
  }
</style>

<body>
  @foreach($admit_card as $value)
  <div class="admit_card" style="height:auto">
    <header class="nepali_td">
      <div class="logo">
        <img src='{{asset("/images/logo.png")}}' style="width: 100%">
      </div>
      <div class="heading">
        <h1 style="margin-bottom: -30px;margin-top: 5px;"> नेपाल टेलिकम</h1>
        <h3 style="margin-left: -21px; font-size: 23px;font-weight: 300;margin-bottom: 0px;">( नेपाल दूरसंचार कम्पनी
          लिमिटेड)</h3>
        <h2 style="text-decoration: underline; margin-top: 0px;margin-bottom:0px;">प्रवेशपत्र</h2>
        <h3 style="text-decoration: underline; margin-top: 0px;margin-left:-40px;margin-bottom:0px;">खुल्ला तथा समावेसी
          प्रतियोगितात्मक परीक्षा</h3>
      </div>
      <div class="photo" style="padding: 5px;">
        <img src='{{asset("/images/avatar.jpg")}}' style="height: 150px;width: 130px;margin-top: 4px;border: 1px solid #000;">
        <div class="box"></div>
      </div>
      <img style="height:40px; width:100px;margin-top:140px;position: absolute;margin-left: 80px;" src="{{asset("/img/rajan_sir.png")}}" />
    </header>
    <table style="clear:both;" class="nepali_td">
      <thead>
        <tr>
          <td style="float: left;"><b>Applicant ID :</b>{{$value->applicant_id}}</td>
        </tr>
        <tr>
          <td style=" text-align: left; "><b>उम्मेदवारको नाम,थर:</b>{{$value->applicant_name}}
          </td>
          <td style=" text-align: left;padding-left: 80px;"><b>नागरिकता नं/जारी जिल्ला:</b>
            {{$value->citizenship_no}}/{{$value->citizenship_district}}</td>
        </tr>
      </thead>
    </table>
    <table style="margin: 0px;font-size: 18px;" width="100%">
      <tr>
        <th align="center"><b>रोल नम्बर: H-7 </b></th>
      </tr>
    </table>
    <table style="margin:0px; width:100%; marign-bottom:3px;" class='center_details nepali_td' border="1"
      cellspacing="0" cellpadding="3">
      <tr style="text-align: center">
        <th style="width:10%">बिज्ञापन नं.</th>
        <th style="width:25%">पद/सेवा/समूह/तह</th>
        <th style="width:10%">पत्र</th>
        <th style="width:10%;text-align:center" colspan="7">समावेसी</th>
        <th style="width:25%">केन्द्र</th>
        <th style="width:15%">मिति</th>
        <th style="width:10%">समय</th>
      </tr>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>खुल्ला</th>
        <th>महिला</th>
        <th>आ.जं</th>
        <th>मधेशी</th>
        <th>दलित</th>
        <th>अपाङ्ग</th>
        <th>पि.क्षे</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>

      <td rowspan="4" class="nepali_td">{{$value->ad_no}}</td>
      <td rowspan="4">{{$value->designation}}-{{$value->work_service}}/{{$value->service_group}}/{{$value->work_level}}
      </td>
      @for ($i=0;$i<@count($papers);$i++) <tr>
        <td>{{$center_details['paper_name'][$i]}}</td>

        <td>@if($value->is_open==true)<i class="fa fa-check" aria-hidden="true"></i>@else {{'-'}}@endif </td>
        <td>@if($value->is_female==true)<i class="fa fa-check" aria-hidden="true"></i>@else {{'-'}}@endif </td>
        <td>@if($value->is_janajati==true)<i class="fa fa-check" aria-hidden="true"></i>@else {{'-'}}@endif </td>
        <td>@if($value->is_madhesi==true)<i class="fa fa-check" aria-hidden="true"></i>@else {{'-'}}@endif </td>
        <td>@if($value->is_dalit==true)<i class="fa fa-check" aria-hidden="true"></i>@else {{'-'}}@endif </td>
        <td>@if($value->is_handicapped==true)<i class="fa fa-check" aria-hidden="true"></i>@else {{'-'}}@endif </td>
        <td>@if($value->is_remote_village==true)<i class="fa fa-check" aria-hidden="true"></i>@else{{'-'}}@endif </td>
        <td>{{$center_details['centername'][$i]}}</td>
        <td>{{$center_details['date'][$i]}}</td>
        <td>{{$center_details['time'][$i]}}</td>
        <tr>
          @endfor
    </table>
    <p style="text-align: justify; margin-top:auto;font-size: 15px;" class="nepali_td">नोट: यस कम्पनीबाट लिइने उक्त पदको
      परीक्षामा
      तपाइलाई सम्मिलित हुन अनुमति दिइएको छ। विज्ञापनमा तोकिएको सर्त नपुगेको ठहर भएमा जुनसुकै अवस्थामा पनि यो अनुमति रद्द
      हुनेछ।
    </p>
    <div class="photo" style="margin-left:-75px;float:right;height:30px;width:100px;margin-top:-26px;border:none">
      <img style="margin-right:75px;margin-top:-8px;float:right;width:100px;" src="/img/rajanSir.png" />
    </div>
    <h4 style="text-align:right" class="nepali_td">जारी गर्ने अधिकृतको नाम : राजन कुमार अधिकारी,प्रबन्धक </h4>
    <hr class="dotted-line">
    <table border="1" width="100%" cellpadding="2" cellspacing="0" style="text-align: justify;" class="nepali_td">
      <caption><b><u>उम्मेदवारले पालना गर्नुपर्ने नियमहरु:</u></b></caption>
      <tr>
        <td>१. उम्मेदवारले परीक्षा हलमा परीक्षा दिन आउँदा अनिवार्य रुपमा प्रवेशपत्र ल्याउनु पर्नेछ । प्रवेशपत्र विना
          परीक्षामा बस्न दिइने छैन ।</td>
      </tr>
      <tr>
        <td>२. लिखित परीक्षाको नतीजा प्रकाशित भएपछि अन्तरवार्ता हुने दिनमा पनि प्रवेशपत्र ल्याउनु अनिवार्य छ ।</td>
      </tr>
      <tr>
        <td>३. परीक्षा सुरु हुने १५ मिनेट अगाडी घण्टीद्वारा सुचना गरेपछि परीक्षा हलमा प्रवेश गर्न दिइने छ । वस्तुगत
          परीक्षा शुरु भएको १५ मिनेट पछि विषयगत परीक्षा शुरु भएको आधा घण्टा पछि आउने र वस्तुगत तथा विषयगत दुवै परीक्षामा
          संगै हुनेमा २० मिनेट पछि आउने उम्मेदवारले परीक्षामा बस्न पाउने छैन ।</td>
      </tr>
      <tr>
        <td>४. हलमा किताव, कापि, कागज, चिट लैजानु हुदैन । उम्मेदवारले आपसमा कुराकानी र संकेत गर्नु हुदैन साथै मोबाइल फोन
          प्रयोग गर्न पाईदैन ।</td>
      </tr>
      <tr>
        <td>५. परीक्षाहलमा परीक्षाको मर्यादा विपरित उम्मेदवारले कुनै काम गरेमा केन्द्राध्यक्षले परीक्षा हलबाट निष्काशन
          गरी तुरुन्त कानुन बमोजिम कारवाही गर्नेछ र त्यसरी निष्काशन गरिएको उम्मेदवारको सो दिनको परीक्षा स्वत: रद्द भएको
          मानिनेछ ।</td>
      </tr>
      <tr>
        <td>६. विरामी भएको उम्मेदवारले परीक्षा हलमा प्रवेश गरी परीक्षा दिने क्रममा निजलाई केहि भएमा कम्पनी जवाफदेही हुने
          छैन ।</td>
      </tr>
      <tr>
        <td>७. परीक्षा दिईरहेको समयमा कुनै उम्मेदवारको नाममा चिट्ठी, फोन, बीमा आदी प्राप्त भएमा उम्मेदवारले उत्तरकापी
          बुझाए पछी निजलाई सो कुराको जानकारी गराईने छ ।</td>
      </tr>

      <tr>
        <td>८. उम्मेदवारले आफुले परीक्षा दिएको दिनमा आफ्नो हाजिर गर्न छुट भएमा तुरुन्त केन्द्राध्यक्षलाई खबर गरी हाजिर
          गर्नु गर्नेछ ।</td>
      </tr>
      <tr>
        <td>९. कम्पनीले सुचनाद्वारा निर्धारण गरेको कार्यक्रम अनुसार परीक्षा संचालन हुनेछ ।</td>
      </tr>
      <tr>
        <td>१०. परीक्षा हाल भित्र हल्ला हुन दिनु हुदैन । कुनै उम्मेदवारले प्रश्नपत्रमा रहेको अस्पष्टताको सम्बन्धमा
          सोध्नु पर्दा पनि परीक्षामा सम्मिलित अन्य उम्मेदवारहरुलाई बाधा नपर्ने गरी सोध्ने पर्नेछ ।</td>
      </tr>
      <tr>
        <td>११. परीक्षा सम्बन्धमा तोकिएको अन्य सबै शर्तहरु पालना गर्नु पर्नेछ ।</td>
      </tr>
    </table>
  </div>
  @endforeach
</body>
</html>