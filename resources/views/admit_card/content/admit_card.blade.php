<body>

@foreach($result as $value)    
<div class="admit_card">
<header>
    <div class="logo">
        <img src="../../../img/logo.png" style="width: 100%">
    </div>
    <div class="heading">
        <h1 style="margin-bottom: -38px">नेपाल टेलिकम</h1>
        <br>
        <h3 style="margin-left: -21px; font-size: 23px;font-weight: 300;">( नेपाल दुरसंचार कम्पनी )</h3>
        <h2 style="text-decoration: underline;">परीक्षाको प्रवेसपत्र</h2>
    </div>
    <div class="photo">
        <img src="photo.jpg">
    </div>
</header>
<table>
    <thead>
        <th style="text-decoration: underline; float: left;">परीक्षार्थीले भर्ने</th>
        <th colspan="3" style="text-decoration-line: underline; text-align: left;  "> उमेदवारले परीक्षा दिने समूह उल्लेख गर्ने</th>

    </thead>
    <tbody>
        <tr>
            <td>क) बिज्ञापन नं.: {{$value->ad_no}}</td>
            <td>क) अन्तरिक
                <input type="text" name="Tick" style="width: 60px; height: 20px; padding: 2px;">
            </td>
            <td colspan="2" style="text-decoration-line: underline;">ख) समाबेसी </td>
        </tr>
        <tr>
            <td>ख) नाम, थर: {{$value->applicant_name}}</td>
            <td>ग) खुल्ला
                <input type="text" id="open" class="js-open"  data-open="{{$value->is_open}}" name="Tick" style="width: 60px; height: 20px; padding: 2px;"> </td>

            <td style="text-align: left;">महिला </td>
            <td>
                <input type="text" id="female" class="js-female"  data-female="{{$value->is_female}}" name="Tick" style="width: 60px; height: 20px; padding: 2px;"> </td>
        </tr>
        <tr>
            <td>ग) पद: {{$value->designation}}</td>
            <td>घ) सेवा: {{$value->work_service}}</td>

        
            <td style="text-align: left;">आदिबासी / जनजाती
            </td>
            <td style="text-align: left;">
                <input type="text" name="Tick" id="janajati" class="js-janajati"  data-janajati="{{$value->is_janajati}}" style="width: 60px; height: 20px; padding: 2px;"> </td>
        </tr>
        <tr>
            <td>ङ) समूह: {{$value->service_group}}</td>
            <td>च) उप - समूह: {{$value->service_sub_group}}</td>
            <td style="text-align: left;">मधेसी
            </td>
            <td style="text-align: left;">
                <input type="text" id="madhesi" class="js-madhesi" data-madhesi="{{$value->is_madhesi}}" name="Tick" style="width: 60px; height: 20px; padding: 2px;"> </td>
        </tr>
        <tr>
        <td colspan="2">छ) श्रेणी तह:</td>
            <td style="text-align: left;">दलित
            </td>
            <td style="text-align: left;">
                <input type="text"id="dalit" class="js-dalit" data-dalit="{{$value->is_dalit}}" name="Tick" style="width: 60px; height: 20px; padding: 2px;"> </td>
        </tr>
        <tr>
        <td colspan="2">छ) परीक्षार्थीको दस्तकत नमुना : <img style="height:40px; width:150px;" src="{{$value->signature_sample}}" /></td>
            <td style="text-align: left;">अपाङ्ग
            </td>
            <td style="text-align: left;">
                <input type="text" name="Tick" id="apanga" class="js-apanga" data-apanga="{{$value->is_handicapped}}" style="width: 60px; height: 20px; padding: 2px;"> </td>
        </tr>
        <tr>
        <td colspan="2"></td>
            <td style="text-align: left;">पिछाडीएको क्षेत्र
            </td>
            <td style="text-align: left;">
                <input type="text" name="Tick" id="remote" class="js-remote" data-remote="{{$value->is_remote_village}}" style="width: 60px; height: 20px; padding: 2px;"> </td>
        </tr>
    </tbody>
</table>



<label>कम्पनि सम्बन्धि कर्मचारीले भर्ने</label>
<p>यस कम्पनी मिति {{$value->exam_date_bs}} मा लिईने परीक्षामा तपाईलाई निम्न केन्द्रबाट सम्मिलित हुन अनुमति दिएको छ ।</p>
<p> बिज्ञापन तोकीएको शर्त झुठो ठहर भाएमा जुनसुकै अवस्थामा पनि यो अनुमति रद्द हुन सक्नेछ । </p>
<h4> रोल नं: {{$value->exam_roll_no}}</h4>
<h4>परिक्षा केन्द्र : {{$value->exam_center}}</h4>
<h4 style="float: right; margin-top: -40px; border-top: 1px solid #000; padding: 2px;
} "> अधिकृत दस्तखत</h4>
</div>
    @endforeach
    

    <script>
        // $(document).ready(function(){
        //    var madesi = $("#madhesi").attr("data-madhesi");
        //    var open = $("#open").attr("data-open");
        //    var janajati = $("#janajati").attr("data-janajati");
        //    var dalit = $("#dalit").attr("data-dalit");
        //    var apanga = $("#madhesi").attr("data-apanga");
        //    var remote = $("#remote").attr("data-remote");

        //   console.log(open);

       
        //    if(open == true){
        //        $(".js-open").css("background-color", "black");
        //    }
        //    if(madesi == true){
        //        $(".js-madesi").css("background-color", "black");
        //    }
        //    if(janajati){
        //        $(".js-janajati").css("background-color", "black");
        //    }
        //    if(dalit){
        //        $(".js-dalit").css("background-color", "black");
        //    }
        //    if(apanga){
        //        $(".js-apanga").css("background-color", "black");
        //    }
        //    if(remote){
        //        $(".js-remote").css("background-color", "black");
        //    }
        // });
    </script>
</body>