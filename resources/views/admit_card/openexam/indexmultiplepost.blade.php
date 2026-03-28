<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="{{asset('/vendor/crudbooster/assets/adminlte/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
</head>
<style>
    @font-face {
        font-family: "Mangal";
        src: url({{ URL::asset("fonts/mangal.ttf")}}) format("truetype");
    }
    body{margin: 0 auto; font-family: mangal;}
    .admit_card{padding: 25px; width: 915px; font-family: mangal;}
   header{text-align: center;}
   .logo{float:  left; clear: right;}
   .heading{text-align: center; float: left; clear:  right; margin-left: 20%;}
   .photo{float: right;}
   .box{width: 127px; height: 40px; border: 1px solid #000;margin-left: 3px;margin-bottom: 20px;margin-top:5px;}
   caption{text-align: left;margin-bottom: 5px;}
</style>

<body>

    <div class="admit_card" style="height:auto">
        <header>
            <div class="logo">
                <img src='{{asset('images/logo.png')}}' style="width: 100%">
            </div>
            <div class="heading">
                <h1 style="margin-bottom: -30px;margin-top: 5px;"> नेपाल टेलिकम</h1>
                <h3 style="margin-left: -21px; font-size: 23px;font-weight: 300;margin-bottom: 0px;">( नेपाल दूरसंचार कम्पनी लिमिटेड)</h3>
                <h2 style="text-decoration: underline; margin-top: 0px;margin-bottom:0px;">प्रवेशपत्र</h2>
                <h3 style="text-decoration: underline; margin-top: 0px;margin-left:-40px;margin-bottom:0px;">खुल्ला तथा समावेशी प्रतियोगितात्मक परीक्षा</h3>
            </div>
            <div class="photo" style="padding: 5px;">
                <img style="height:40px; width:80px;margin-top:120px;margin-left:0px;position: absolute;z-index: 2;" src="{{asset('img/rajanSir.png')}}" />
                <img src="{{asset($posts_applied[0]->photo)}}"
                style="height: 150px;width: 130px;margin-top: 4px;border: 1px solid #000;z-index: 1;" onerror="this.onerror=null;this.src='../images/avatar.jpg';" style="height: 50px;">
               
                <div class="box"> <img style="height:40px; width:127px;" src="{{asset($posts_applied[0]->signature_sample)}}" onerror="this.onerror=null;this.  src='../images/sign.jpg';" style="height: 40px;" />
                </div>
        </header>
        <table style="clear: both;">
            <thead>
                <tr>
                    <td style="float: left;"><b>Applicant ID : </b>{{$posts_applied[0]->applicant_id}} </td>
                </tr>
                <tr>
                    <td style=" text-align: left; "><b>उम्मेदवारको नाम,थर: </b>{{$posts_applied[0]->applicant_name}}
                    </td>
                    <td style=" text-align: left;padding-left: 200px;"><b>नागरिकता नं/जारी जिल्ला:</b>
                      {{$posts_applied[0]->citizenship_no}}/{{$posts_applied[0]->citizenship_district}}</td>
                </tr>
            </thead>

        </table>

        <table style="margin: 0px;font-size: 18px;" width="100%" >
            <tr>
                <th align="center"><b>रोल नम्बर: </b>{{$posts_applied[0]->exam_roll_no}}</th>
            </tr>
        </table>

   <table style="margin:0px; " class='center_details' border="1" cellspacing="0" cellpadding="3" width="100%">
       <tr>
          <th style="width:10%" rowspan="2">बिज्ञापन नं.</th>
          <th style="width:25%" rowspan="2">पद/सेवा/समूह/तह</th>
          <th style="width:10%" rowspan="2">पत्र</th>
          <th style="width:10%" rowspan="2">खुल्ला</th>
          <th style="width:10%;text-align:center" colspan="6">समावेशी</th>
          <th style="width:25%" rowspan="2">केन्द्र</th>
          <th style="width:15%" rowspan="2">मिति</th>
          <th style="width:10%" rowspan="2">समय</th>
        </tr>
          <tr>
            <th>महिला</th>
            <th>आ.ज.</th>
            <th>मधेशी</th>
            <th>दलित</th>
            <th>अपाङ्ग</th>
            <th>पि.क्षे.</th>
        </tr>
               @php $prev_ad_no= null; @endphp
             @foreach($posts_applied as $key=>$pa)
             <tr>
                 @if($prev_ad_no===$pa->ad_no)
                 <td></td>
                 <td></td>
                 @else
                 <td>{{$pa->ad_no}}</td>
                 <td>{{$pa->designation}} -{{$pa->work_service}}/{{$pa->service_group}}/{{$pa->work_level}}</td>
                 @endif


                 @php
                 $unicodeChar = "\u{2713}";  
                 @endphp
                <td style="text-align: center">{{$pa->paper_name_np}}</td>
                <td style="text-align: center">@if($pa->is_open==true)<i class="fa fa-check"></i> @else {{'-'}}@endif </td>
                <td style="text-align: center">@if($pa->is_female==true)<i class="fa fa-check"></i>@else {{'-'}}@endif </td>
                <td style="text-align: center">@if($pa->is_janajati==true)<i class="fa fa-check"></i>@else {{'-'}}@endif </td>
                <td style="text-align: center">@if($pa->is_madhesi==true)<i class="fa fa-check"></i>@else {{'-'}}@endif </td>
                <td style="text-align: center">@if($pa->is_dalit==true)<i class="fa fa-check"></i>@else {{'-'}}@endif </td>
                <td style="text-align: center">@if($pa->is_handicapped==true)<i class="fa fa-check"></i>@else {{'-'}}@endif </td>
                <td style="text-align: center">@if($pa->is_remote_village==true)<i class="fa fa-check"></i>@else{{'-'}}@endif </td>


                <td style="text-align: center">{{$pa->exam_center}}</td>
                <td style="text-align: center">{{$pa->date_bs}}</td>
                <td style="text-align: center">{{$pa->time_from}}</td>
              </tr>
              @php
               $prev_ad_no= $pa->ad_no;
              @endphp
             @endforeach
      
      </table>
        <p style="text-align: justify; margin-top:auto;font-size: 15px;">नोट: यस कम्पनीबाट लिइने उक्त पदको परीक्षामा
            तपाइलाई सम्मिलित हुन अनुमति दिइएको छ। विज्ञापनमा तोकिएको सर्त नपुगेको ठहर भएमा जुनसुकै अवस्थामा पनि यो अनुमति रद्द हुनेछ।
        </p>
        <div class="photo" style="margin-left:-75px;float:right;height:30px;width:100px;margin-top:-26px;border:none">
            <img style="margin-right:75px;margin-top:-8px;float:right;width:100px;" src="{{asset('img/rajanSir.png')}}" />
        </div>
        <h4 style="text-align:right">जारी गर्ने अधिकृतको नाम : राजन कुमार अधिकारी<br><span style="margin-right:30px;">(प्रबन्धक) </span>
          </h4>
            <hr class="dotted-line">
        <table border="1" width="100%" cellpadding="1" cellspacing="0" style="text-align: justify;page-break-inside: avoid;">
            <caption><b><u>उम्मेदवारले पालना गर्नुपर्ने नियमहरु:</u></b></caption>
            <tr>
                <td>१.परीक्षा दिन आउँदा अनिवार्य रुपमा प्रवेशपत्र ल्याउनु पर्नेछ । प्रवेशपत्र विना परीक्षामा बस्न पाईने छैन ।</td>
            </tr>

            <tr>
              <td>२.परीक्षा भवनमा मोबाइल फोन ल्याउन पाईने छैन ।</td>
           </tr>

            <tr>
                <td>३. लिखित परीक्षाको नतीजा प्रकाशित भएपछि अन्तरवार्ता हुने दिनमा पनि प्रवेशपत्र ल्याउनु अनिवार्य छ ।</td>
            </tr>
              <tr>
                <td>४. परीक्षा सुरु हुने ३० मिनेट अगावै घण्टीद्वारा सुचना गरेपछि परीक्षा हलमा प्रवेश गर्न दिइने छ। वस्तुगत परीक्षा शुरु भएको १५ मिनेट पछि विषयगत परीक्षा शुरु भएको आधा घण्टा पछि आउने र वस्तुगत तथा विषयगत दुवै परीक्षासंगै हुनेमा २० मिनेट पछि आउने उम्मेदवारले परीक्षामा बस्न पाउने छैन ।</td>
            </tr>

            <tr>
              <td>५.परीक्षा हलमा प्रवेश गर्न पाउने समय अवधि (बुंदा नं ४ मा उल्लेख गरिएको) बितेको १० मिनेट पछि मात्र उम्मेदवारलाई परीक्षा हल बाहिर जाने अनुमति दिईने छ।</td>
           </tr>


              <tr>
                <td>६.परीक्षा हलमा प्रवेश गरेपछि किताव, कापि, कागज, चिट आदि आफु साथ राख्नु हुदैन । उम्मेदवारले आपसमा  कुराकानी र संकेत गर्नु हुदैन।</td>
            </tr>
              <tr>
                <td>७. परीक्षा हलमा उम्मेदवारले  परीक्षाको मर्यादा विपरित कुनै काम गरेमा केन्द्राध्यक्षले परीक्षा हलबाट निष्काशन गरी तुरुन्त कानुन बमोजिम कारवाही गर्नेछ र त्यसरी निष्काशन गरिएको उम्मेदवारको सो विज्ञापनको परीक्षा स्वत: रद्द भएको मानिनेछ ।</td>
            </tr>
              <tr>
                <td>८. विरामी भएको उम्मेदवारले परीक्षा हलमा प्रवेश गरी परीक्षा दिने क्रममा निजलाई केहि भएमा कम्पनी जवाफदेही हुने छैन ।</td>
            </tr>


              <tr>
                <td>९. उम्मेदवारले परीक्षा दिएको दिनमा हाजिर अनिवार्य रुपले गर्नुपर्ने छ ।</td>
            </tr>
              <tr>
                <td>१०. कम्पनीले सुचनाद्वारा निर्धारण गरेको कार्यक्रमअनुसार परीक्षा संचालन हुनेछ ।</td>
            </tr>

            <tr>
              <td>११. उम्मेदवारले वस्तुगत परीक्षामा आफुलाई प्राप्त प्रश्नको 'की' उत्तरपुस्तिकामा अनिवार्य रुपले लेख्नु पर्ने छ।नलेखेमा उत्तरपुस्तिका स्वत: रद्द हुने छ।</td>
           </tr>

              <tr>
                <td>१२.ल्याकत (आ.क्यु.) परीक्षामा क्याल्कुलेटर प्रयोग गर्न पाईने छैन ।</td>
            </tr>
              <tr>
                <td>१३.कुनै उम्मेदवारले प्रस्नपत्रमा रहेको अस्पष्टताको सम्बन्धमा सोध्नु पर्दा परीक्षामा सम्मिलित अन्य उम्मेदवारलाई बाधा नपर्ने गरि निरीक्षकलाई सोध्नु पर्ने छ।</td>
            </tr>
        </table>
    </div>
</body>
</html>