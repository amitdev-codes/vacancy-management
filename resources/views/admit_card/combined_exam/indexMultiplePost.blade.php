<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admit Card</title>
    <link href="{{ asset('/vendor/crudbooster/assets/adminlte/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        /* @font-face {
            font-family: "Mangal";
            src: url({{ URL::asset('fonts/mangal.ttf') }}) format("truetype");
        }

        body {
            font-family: Mangal;
        } */


        @font-face {
            font-family: "Kalimati";
            src: url({{ URL::asset('fonts/kalimati.ttf') }}) format("truetype");
        }

        body {
            font-family: kalimati;
        }

        .admit_card {
            padding: 25px;
            max-width: 1100px;
            margin: 0 auto;
        }

        header {
            text-align: center;
        }

        .logo img {
            width: 50%;
        }

        .photo img {
            border: 1px solid #000;
        }

        .box img {
            height: 40px;
            width: 100%;
        }

        .rules-table td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="admit_card">
        <header class="d-flex justify-content-between align-items-start">
            <div class="logo">
                <img src='{{ asset('images/logo.png') }}' alt="Logo">
                <div class="photo position-relative">
                    <img src="{{ asset('img/nb_sir.png') }}"
                        style="height:40px; width:80px;margin-top:120px;position: absolute;z-index: 2;" alt="Nb Sir">

                    <img src="{{ asset($posts_applied[0]->photo) }}" style="height: 150px;width: 130px;margin-top: 4px;"
                        onerror="this.onerror=null;this.src='../images/avatar.jpg';" alt="Applicant Photo">

                    <div class="box mt-2">
                        <img src="{{ asset($posts_applied[0]->signature_sample) }}"
                            onerror="this.onerror=null;this.src='../images/sign.jpg';" alt="Signature Sample">
                    </div>
                </div>
            </div>
            <div class="heading text-center mx-auto">
                <h2 class="mb-0 mt-1">नेपाल दूरसंचार कम्पनी लिमिटेड</h2>
                <h4 class="font-weight-normal mb-1">( नेपाल टेलिकम )</h4>
                <h2 class="text-underline my-1">प्रवेशपत्र</h2>
                <h5 class="text-underline my-0">आ.प्र र खुला तथा समावेशी प्रतियोगितात्मक परीक्षा</h5>
            </div>
            <div class="photo position-relative">
                <img src="{{ asset($posts_applied[0]->citizenship) }}"
                    style="height: 300px;width: 250px;margin-top: 4px;"
                    onerror="this.onerror=null;this.src='../images/avatar.jpg';" alt="Applicant Citizenship">
            </div>
        </header>



        <div class="mt-3">
            <div class="d-flex justify-content-between">
                <div><b>Applicant ID : </b>{{ $posts_applied[0]->applicant_id }}</div>
                <div style="margin-left:70px"><b>नागरिकता नं/जारी जिल्ला:</b>
                    {{ $posts_applied[0]->citizenship_no }}/{{ $posts_applied[0]->citizenship_district }}</div>
            </div>
            <div class="d-flex justify-flex-end">
                <div><b>उम्मेदवारको नाम,थर: </b>{{ $posts_applied[0]->applicant_name }}</div>
                <div style="margin-left:150px">
                    <b>रोल नम्बर: </b>{{ $posts_applied[0]->exam_roll_no }}
                </div>
            </div>
        </div>

        <table style="margin:0px;font-size:14px;" class='mt-2 center_details' border="1" cellspacing="0"
            cellpadding="3" width="100%">
            <tr>
                <th rowspan="2">बिज्ञापन नं.</th>
                <th rowspan="2">आवेदन समूह</th>
                <th rowspan="2">पद/सेवा/समूह/तह</th>
                <th rowspan="2">पत्र</th>
                <th rowspan="2">खुला</th>
                <th colspan="6">समावेशी</th>
                <th rowspan="2">केन्द्र</th>
                <th rowspan="2">मिति</th>
                <th rowspan="2">समय</th>
            </tr>
            <tr>
                <th>महिला</th>
                <th>आ.ज.</th>
                <th>मधेशी</th>
                <th>दलित</th>
                <th>अपाङ्ग</th>
                <th>पि.क्षे.</th>
            </tr>

            <tbody>
                @php $prev_ad_no= null; @endphp
                @foreach ($posts_applied as $key => $pa)
                    <tr>
                        @if ($prev_ad_no === $pa->ad_no)
                            <td></td>
                            <td></td>
                            <td></td>
                        @else
                            <td>{{ $pa->ad_no }}</td>
                            <td class="nepali_td">{{ $pa->opening_type }}</td>
                            <td>{{ $pa->designation }}-{{ $pa->work_service }}/{{ $pa->service_group }}/{{ $pa->work_level }}
                            </td>
                        @endif
                        <td>{{ $pa->paper_name_np }}</td>
                        <td>
                            @if ($pa->is_open == true)
                                <i class="fa fa-check"></i>
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($pa->is_female == true)
                                <i class="fa fa-check"></i>
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($pa->is_janajati == true)
                                <i class="fa fa-check"></i>
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($pa->is_madhesi == true)
                                <i class="fa fa-check"></i>
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($pa->is_dalit == true)
                                <i class="fa fa-check"></i>
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($pa->is_handicapped == true)
                                <i class="fa fa-check"></i>
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($pa->is_remote_village == true)
                                <i class="fa fa-check"></i>
                                @else{{ '-' }}
                            @endif
                        </td>
                        <td>{{ $pa->exam_center }}</td>
                        <td>{{ $pa->date_bs }}</td>
                        <td>{{ $pa->time_from }}</td>
                    </tr>
                    @php $prev_ad_no = $pa->ad_no; @endphp
                @endforeach
            </tbody>
        </table>

        <p class="text-justify mt-2" style="font-size: 14px;">
            नोट: यस कम्पनीबाट लिइने उक्त पदको परीक्षामा तपाइलाई सम्मिलित हुन अनुमति दिइएको छ। विज्ञापनमा तोकिएको सर्त
            नपुगेको ठहर भएमा जुनसुकै अवस्थामा पनि यो अनुमति रद्द हुनेछ।
        </p>

        <div class="d-flex justify-content-end">
            <div class="photo mr-4" style="height:100%;width:100px;">
                <img src="{{ asset('img/nb_sir.png') }}" style="width:100%;" alt="Signature">
            </div>
        </div>
        <h6 style="text-align:right">जारी गर्ने अधिकृतको नाम : निर्झर भट्टाराई,प्रबन्धक </h6>
        <hr class="dotted-line my-4">

        <caption class="text-left"><b><u>उम्मेदवारले पालना गर्नुपर्ने नियमहरु:</u></b></caption>
        <table class="table table-bordered rules-table" style="font-size:14px;">

            <tbody>
                <tr>
                    <td>१. परीक्षा दिन आउँदा अनिवार्य रुपमा प्रवेशपत्र ल्याउनु पर्नेछ। प्रवेशपत्र विना परीक्षामा बस्न
                        पाईने छैन।</td>
                </tr>
                <tr>
                    <td>२. परीक्षा हल भित्र मोबाइल फोन ल्याउन पाईने छैन।</td>
                </tr>
                <tr>
                    <td>३. लिखित परीक्षाको नतीजा प्रकाशित भएपछि अन्तरवार्ता हुने दिनमा पनि प्रवेशपत्र ल्याउनु पर्ने छ।
                    </td>
                </tr>
                <tr>
                    <td>४. परीक्षा सुरु हुने ३० मिनेट अगावै घण्टीद्वारा सुचना गरेपछि परीक्षा हलमा प्रवेश गर्न दिइने छ।
                        वस्तुगत परीक्षा शुरु भएको १५ मिनेट पछि र विषयगत परीक्षा शुरु भएको आधा घण्टा पछि आउने साथै
                        वस्तुगत तथा विषयगत दुवै परीक्षासंगै हुनेमा २० मिनेट पछि आउने उम्मेदवारले परीक्षामा बस्न पाउने
                        छैन।</td>
                </tr>
                <tr>
                    <td>५. परीक्षा हलमा प्रवेश गर्न पाउने समय अवधि (बुंदा नं ४ मा उल्लेख गरिएको) बितेको १० मिनेट पछि
                        मात्र उम्मेदवारलाई परीक्षा हल बाहिर जाने अनुमति दिईने छ।</td>
                </tr>
                <tr>
                    <td>६. परीक्षा हलमा प्रवेश गरेपछि किताव, कपी, कागज, चिट वा निषेधित सामाग्रीहरु आदि आफु साथ राख्नु
                        हुदैन। उम्मेदवारले आपसमा कुराकानी र संकेत गर्नु हुदैन।</td>
                </tr>
                <tr>
                    <td>७. परीक्षा हलमा उम्मेदवारले परीक्षाको मर्यादा विपरित कुनै काम गरेमा केन्द्राध्यक्षले परीक्षा
                        हलबाट निष्काशन गरी तुरुन्त कानुन बमोजिम कारवाही गर्नेछ र त्यसरी निष्काशन गरिएको उम्मेदवारको सो
                        विज्ञापनको परीक्षा स्वत: रद्द भएको मानिनेछ।</td>
                </tr>
                <tr>
                    <td>८. विरामी भएको उम्मेदवारले परीक्षा हलमा प्रवेश गरी परीक्षा दिने क्रममा निजलाई केहि भएमा स्वयं
                        परीक्षार्थी जवाफदेही हुनुपर्नेछ।</td>
                </tr>
                <tr>
                    <td>९. उम्मेदवारले परीक्षा दिएको दिनमा हाजिर अनिवार्य रुपले गर्नुपर्ने छ।</td>
                </tr>
                <tr>
                    <td>१०. कम्पनीले सुचनाद्वारा निर्धारण गरेको कार्यक्रमअनुसार परीक्षा संचालन हुनेछ।</td>
                </tr>
                <tr>
                    <td>११. उम्मेदवारले वस्तुगत परीक्षामा आफुलाई प्राप्त प्रश्नको 'की' उत्तरपुस्तिकामा अनिवार्य रुपले
                        लेख्नु पर्ने छ।नलेखेमा उत्तरपुस्तिका स्वत: रद्द हुने छ।</td>
                </tr>
                <tr>
                    <td>१२.ल्याकत (आ.क्यु.) परीक्षामा क्याल्कुलेटर प्रयोग गर्न पाईने छैन।</td>
                </tr>
                <tr>
                    <td>१३.कुनै उम्मेदवारले प्रस्नपत्रमा रहेको अस्पष्टताको सम्बन्धमा सोध्नु पर्दा परीक्षामा सम्मिलित
                        अन्य उम्मेदवारलाई बाधा नपर्ने गरी निरीक्षकलाई सोध्नु पर्ने छ।</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
