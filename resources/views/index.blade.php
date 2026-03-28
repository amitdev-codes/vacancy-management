@extends('welcome')
@section('content')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
    @if (\Session::has('message'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                <li>{!! \Session::get('message') !!}</li>
            </ul>
        </div>
    @endif

    <style>
        .marquee {
            width: 100%;
            overflow: hidden;
        }

        .marquee p {
            display: inline-block;
            animation: marquee 15s linear infinite;
            white-space: nowrap;
            margin: 0;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .marquee {
            background-color: #f5f5f5;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .marquee p {
            font-size: 24px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .notice-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .blinking-title {
            font-size: 24px;
            color: red;
            font-weight: bold;
            animation: blinker 1.5s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        .alert {
            font-size: 17px;
            margin-top: 10px;
            display: inline-block;
        }
    </style>
    <div class='container nepali_td'>
        <!-- <div class="col-md-12">
                                                                                    <div class="marquee">
                                                                                        <!-- <p>अनलाईन आवेदन सिस्टम अवरुद्ध हुने सूचना! </p>
                                                                                    </div>
                                                                                </div>  -->
        <!-- <div class="col-md-12"> -->
        <!-- <div class="alert alert-info" role="alert" style=" font-size: 17px;"> -->
        <!-- <strong> -->



        <!--
                                                                                            यस कम्पनीको अनलाईन आवेदन प्रणालीलाई अनलाईन भुक्तानी सेवा प्रणालीमा कनेक्सन सेटअप गर्ने कार्यको लागि आज
                                                                                            मिति
                                                                                            २०८१ बैशाख २१ गते बेलुका ०७:३० देखि केही समय सिस्टम बन्द रहने ब्यहोरा सम्बन्धित सबैको जानकारीको लागि यो
                                                                                            सूचना
                                                                                            प्रकाशित गरिएको छ। यसबाट पर्न जाने असुविधा प्रति हामी क्षमाप्रार्थी छौं। -->
        </strong>
        <br />
        <!-- <div style="font-size: 17px;text-align: center; margin-top:2px;"> -->
        <!-- <span style="text-align: center">पदपूर्ति समितिको सचिवालय</span> -->
        <!-- </div> -->
        <!-- </div>  -->

        <!-- <div class="notice-container">
            <h1 class="blinking-title">सूचना</h1>
            <div class="alert alert-warning" role="alert" style=" font-size: 17px;">
                <strong>
                    <b style="color: #0271B4">
                        विज्ञापन नं. ६३-०८०/८१ सहायक लेखा अधिकृतको प्रवेशपत्रमा परीक्षा कार्यक्रमको समय फरक पर्न गएकोले नयाँ
                        प्रवेशपत्रमा सुधार गरिएको व्यहोरा सम्बन्धित परीक्षार्थीहरुलाई जानकारी गराइन्छ ।
                    </b>
                </strong>
            </div>
        </div> -->




        <div class="alert alert-warning" role="alert" style=" font-size: 17px;">
            <strong>
                <b>
                    <a href="{{ asset('notice/notice_schedule_2081.pdf') }}" style="color: #0271B4">
                        नेपाल टेलिकमको मिति २०८१-०१-०७ मा प्रकाशित बिज्ञापन बमोजिमको खुला तथा समावेशी र आन्तरिक
                        प्रतियोगितात्मक लिखित परीक्षाको परिक्षा केन्द्र प्रकाशन गरिएको सम्बन्धि लोक सेवा आयोगको सूचना
                    </a>
                    <b>
            </strong>
        </div>

        {{-- <div class="alert alert-warning" role="alert" style=" font-size: 17px;">
            <strong>
                <b>
                    <a href="{{ asset('notice/assistant.pdf') }}" style="color: #0271B4">
                        लोक सेवा आयोगबाट बि.नं. ६१-०७९/८० (खुला तथा समावेशी), सहायक पदको परिक्षा केन्द्र निर्धारण गरिएको
                        सम्बन्धि सूचना
                    </a>
                    <b>
            </strong>
        </div> --}}


        <div class="notice ">
            <button class="accordion" style="font-size:16px">नेपाल टेलिकमको मिति २०८१-०१-०७ मा प्रकाशित बिज्ञापन बमोजिमको
                आ.प्र,खुला तथा समावेशी तर्फको स्वीकृत तथा अस्वीकृत नामावली हेर्न यहाँ click गर्नुहोला </button>
            <div class="panel news" style="display:none">
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/30.pdf') }}"> 30/2080/81 निर्देशक /
                            प्रबन्धक,( टेलिकम) </a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/31.pdf') }}"> 31/2080/81 प्रबन्द्धक
                            (लेखा)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/32_54.pdf') }}"> 32/2080/81,54/2080/81
                            उप-प्रबन्धक (टेलिकम)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/34_55.pdf') }}"> 34/2080/81,55/2080/81
                            बरिष्ठ इन्जिनियर (टेलिकम)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/35.pdf') }}"> 35/2080/81 बरिष्ठ लेखा
                            अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/36.pdf') }}"> 36/2080/81 वरिष्ठ
                            प्राबिधिक अधिकृत, (निर्माण तथा मर्मत)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/37_57.pdf') }}"> 37/2080/81,57/2080/81
                            टेलिकम इन्जिनियर(इलेक्ट्रोनिक्स & कम्युनिकेशन)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/39_60.pdf') }}"> 39/2080/81,60/2080/81
                            इन्जिनियर (सिभिल)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/40.pdf') }}"> 40/2080/81, प्रशासकिय
                            अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/41.pdf') }}"> 41/2080/81,व्यापार
                            अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/42.pdf') }}"> 42/2080/81,कानुन
                            अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/43.pdf') }}"> 43/2080/81, लेखा
                            अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/44.pdf') }}"> 44/2080/81,प्राबिधिक
                            अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/45.pdf') }}"> 45/2080/81, प्राबिधिक
                            अधिकृत(निर्माण तथा मर्मत)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/46_47.pdf') }}">
                            46/2080/81,62/2080/81, सहायक व्यापार अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/48.pdf') }}"> 48/2080/81, सहायक
                            प्राबिधिक अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/50.pdf') }}"> 50/2080/81, बरिष्ठ
                            सहायक</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/56.pdf') }}"> 56/2080/81, बरिष्ठ लेखा
                            अधिकृत (चा.ए.)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/58.pdf') }}"> 58/2080/81, टेलिकम
                            इन्जिनियर(कम्प्युटर)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/59.pdf') }}"> 59/2080/81, टेलिकम
                            इन्जिनियर(इलेक्ट्रिकल)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/61.pdf') }}"> 61/2080/81, सहायक
                            प्रशासकिय अधिकृत</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/2080/64.pdf') }}"> 64/2080/81, ओभरसियर</a>
                    </p>
                </div>












                {{-- 
                <div>
                    <p
                        style="red !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:red !important" href="{{ asset('notice/2080/63.pdf') }}"> खुला समावेशी बि नं
                            ५०-०७९-८० देखि बि.नं. ६२-०७९-८० सम्म अस्वीकृत नामावली विवरण </a>
                    </p>
                </div> --}}


            </div>
        </div>









        {{-- <div class="notice ">
            <button class="accordion" style="font-size:16px">नेपाल टेलिकमको मिति २०७९/११/१२ मा प्रकाशित बिज्ञापन बमोजिमको
                आन्तरिक तर्फको स्वीकृत तथा अस्वीकृत नामावली हेर्न यहाँ click गर्नुहोला </button>
            <div class="panel news" style="display:none">
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/25.pdf') }}"> 25-079-80 प्रबन्धक
                            प्रशासन(आ.प्र.) </a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/26.pdf') }}"> 26-079-80 उप
                            प्रबन्धक सिभिल (आ.प्र.)</a>
                    </p>
                </div>
                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/27.pdf') }}"> 27-079-80 उप
                            प्रबन्धक टेलिकम (आ.प्र.)</a>
                    </p>
                </div>



                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/28.pdf') }}">28-079-80 उप प्रबन्धक
                            , प्राबिधिक (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/29.pdf') }}"> 29-079-80 उप
                            प्रबन्धक लेखा (आ.प्र.)</a>
                    </p>
                </div>



                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/31.pdf') }}"> 31-079-80 बरिस्ट
                            इन्जिनियर टेलिकम (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/32.pdf') }}">32-079-80 बरिस्ट
                            इन्जिनियर सिभिल (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/33.pdf') }}"> 33-079-80 बरिस्ट
                            लेखा अधिकृत (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/34.pdf') }}"> 34-079-80 बरिस्ट
                            प्रशासकीय अधिकृत (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/35.pdf') }}"> 35-079-80 टेलिकम
                            इन्जिनियर , इलेक्ट्रोनिक्स इने कम्युनिकेसन्स (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/38.pdf') }}"> 38-प्राबिधिक
                            अधिकृत (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/39.pdf') }}">39-079-80 इन्जिनियर
                            सिभिल (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/40.pdf') }}"> 40-079-80 लेखा
                            अधिकृत(आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/41.pdf') }}"> 41-079-80
                            प्रशासकीय अधिकृत(आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/42.pdf') }}"> 42-079-80 व्यापार
                            अधिकृत (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/43.pdf') }}">43-079-80 सहायक
                            प्राबिधिक अधिकृत (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/44.pdf') }}"> 44-079-80 सहायक
                            प्रशासकीय अधिकृत(आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/45.pdf') }}"> 45-079-80सहायक
                            व्यापार अधिकृत(आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/46.pdf') }}"> 46-079-80 सिनियर
                            टेक्निसियन (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/47.pdf') }}"> 47-079-80 बरिस्ट
                            सहायक(आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/48.pdf') }}"> 48-079-80
                            टेक्निसियन (आ.प्र.)</a>
                    </p>
                </div>

                <div>
                    <p
                        style="blue !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:blue !important" href="{{ asset('notice/internal/49.pdf') }}"> 49-079-80 जुनियर
                            टेक्निसियन (आ.प्र.)</a>
                    </p>
                </div>


                <div>
                    <p
                        style="red !important; margin-left: 20px; padding: 5px; margin-bottom: 0px;font-size:16px;font-weight:700">
                        <a style="color:red !important" href="{{ asset('notice/internal/50.pdf') }}"> आन्तरिक तर्फ वि.नं.
                            २५-०७९-८० देखि वि.नं. ४९ -०७९-८० सम्म अस्वीकृत नामावली </a>
                    </p>
                </div>


            </div>

        </div> --}}





        <div class='col-md-12'>
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading text-center advertisement">
                    <h3 style="font-weight: 600;">विज्ञापनको सूचना</h3>
                    <div class="col-md-3 category text-center">
                        <select class="form-control" onchange="location = this.value;">
                            @foreach ($opening_types as $ot)
                                @if ($selected_opening_type == $ot->id)
                                    <option value='?ot={{ $ot->id }}' selected> {{ $ot->name_np }}</option>
                                @else
                                    <option value='?ot={{ $ot->id }}'> {{ $ot->name_np }}</option>
                                @endif
                            @endforeach
                        </select>

                    </div>
                </div>


                <!-- Table -->
                @if ($selected_opening_type == '3' || $selected_opening_type == null)
                    <div class='container' style="margin-bottom: 10px;">
                        @if (!$vacancy_int_promotion->isEmpty())
                            <div class="table-responsive">
                                <h3 style="color:#00368C;">कार्यक्षमता मूल्यांकन बढुवा</h3>

                                <table class="table-striped table-hover table-bordered table-responsive">
                                    <thead style="background-color: lightgray;">
                                        <tr>
                                            <th rowspan='2' class='text-center'> क्र.सं.</th>
                                            <th rowspan='2' class='text-center'>बिज्ञापन नं</th>
                                            <th rowspan='2' width="250px" class='text-center'>पद</th>
                                            <th rowspan='2' class='text-center'>सेवा/समूह</th>
                                            <th rowspan='2' class='text-center'>तह</th>
                                            <th rowspan='2' class='text-center'>रिक्त पद</th>
                                            <th rowspan='2' class='text-center'>का.स.मू.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rnum = 0;
                                        $first = 0;
                                        ?>
                                        @foreach ($vacancy_int_promotion as $res)
                                            <?php
                                            $rnum++;
                                            $first++;
                                            ?> @if ($first == 1)
                                                <h4>प्रकाशित मिति: <strong>
                                                        {{ Vaars::get_nep($res->date_to_publish_bs) }} </strong>
                                                    <span>| अन्तिम मिति: <strong>
                                                            {{ Vaars::get_nep($res->last_date_for_application_bs) }}
                                                        </strong></span>
                                                </h4>
                                            @endif
                                            <tr>
                                                <td class='text-right'>{{ $loop->iteration }}.</td>
                                                <td>&nbsp&nbsp{{ $res->ad_no }}</td>
                                                <td>&nbsp&nbsp{{ $res->desigination }}</td>
                                                <td>&nbsp&nbsp{{ $res->service }} - {{ $res->service_group }}</td>
                                                <td class='text-center'>{{ $res->work_level }}</td>
                                                <td class='text-center'>{{ $res->total_req_seats }}</td>
                                                <td class='text-center'>{{ $res->file_pormotion }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>


                    @endif @if ($selected_opening_type == '2' || $selected_opening_type == null)
                        <div class='container'>
                            @if (!$vacancy_int_open->isEmpty())
                                <div class="table-responsive">
                                    <h3 style="color:#00368C;">आन्तरिक प्रतियोगिता</h3>

                                    <table class="table-striped table-hover table-bordered table-responsive">
                                        <thead style="background-color: lightgray;">
                                            <tr>
                                                <th rowspan='2' class='text-center'> क्र.सं.</th>
                                                <th rowspan='2' class='text-center'>बिज्ञापन नं</th>
                                                <th rowspan='2' width="250px" class='text-center'>पद</th>
                                                <th rowspan='2' class='text-center'>सेवा/समूह</th>
                                                <th rowspan='2' class='text-center'>तह</th>
                                                <th rowspan='2' class='text-center'>रिक्त पद</th>
                                                <th rowspan='2' class='text-center'>आ.प्र.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $rnum = 0;
                                            $first = 0; ?> @foreach ($vacancy_int_open as $res)
                                                <?php $rnum++;
                                                $first++; ?> @if ($first == 1)
                                                    <h4>प्रकाशित मिति: <strong>
                                                            {{ Vaars::get_nep($res->date_to_publish_bs) }} </strong>
                                                        <span>| अन्तिम मिति: <strong>
                                                                {{ Vaars::get_nep($res->last_date_for_application_bs) }}
                                                            </strong></span>
                                                        <span>| डबल दस्तुर मिति: <strong>
                                                                {{ Vaars::get_nep($res->vacancy_extended_date_bs) }}
                                                            </strong></span>
                                                    </h4>
                                                @endif
                                                <tr>

                                                    <td class='text-right'>{{ $loop->iteration }}.</td>
                                                    <td>&nbsp&nbsp{{ $res->ad_no }}</td>
                                                    <td>&nbsp&nbsp{{ $res->desigination }}</td>
                                                    <td>&nbsp&nbsp{{ $res->service }} - {{ $res->service_group }}</td>
                                                    <td class='text-center'>{{ $res->work_level }}</td>
                                                    <td class='text-center'>{{ $res->total_req_seats }}</td>
                                                    <td class='text-center'>{{ $res->internal }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                            @endif

                        </div>

                        @endif @if ($selected_opening_type == '1' || $selected_opening_type == null)
                            <div class='container'>
                                @if (!$vacancy_ext->isEmpty())
                                    <div class="table-responsive">
                                        <h3 style="color:#00368C;">खुला/समावेशी</h3>
                                        <table class="table-striped table-hover table-bordered table-responsive">
                                            <thead style="background-color: lightgray;">
                                                <tr>
                                                    <th rowspan='2' class='text-center'>क्र.सं.</th>
                                                    <th rowspan='2' class='text-center'>बिज्ञापन नं</th>
                                                    <th rowspan='2' width="250px" class='text-center'>पद</th>
                                                    <th rowspan='2' class='text-center'>सेवा/समूह</th>
                                                    <th rowspan='2' class='text-center'>तह</th>
                                                    <th rowspan='2' class='text-center'>कुल</br>संख्या</th>
                                                    <th rowspan='2' class='text-center'>खुला</th>
                                                    <th colspan='6' class='text-center'>समावेशी समूह</th>
                                                </tr>
                                                <tr>
                                                    <th rowspan='2' class='text-center'>महिला</th>
                                                    <th rowspan='2' class='text-center'>जनजाती</th>
                                                    <th rowspan='2' class='text-center'>मधेसी</th>
                                                    <th rowspan='2' class='text-center'>दलित</th>
                                                    <th rowspan='2' class='text-center'>अपाङ्ग</th>
                                                    <th rowspan='2' class='text-center'>पिछडिएको </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php $rnum = 0;
                                                $first = 0; ?> @foreach ($vacancy_ext as $res)
                                                    <?php $rnum++;
                                                    $first++; ?>
                                                    @if ($first == 1)
                                                        <h4>प्रकाशित मिति: <strong>
                                                                {{ Vaars::get_nep($res->date_to_publish_bs) }}
                                                            </strong>
                                                            <span>| अन्तिम मिति: <strong>
                                                                    {{ Vaars::get_nep($res->last_date_for_application_bs) }}
                                                                </strong></span>
                                                            <span>| डबल दस्तुर मिति: <strong>
                                                                    {{ Vaars::get_nep($res->vacancy_extended_date_bs) }}
                                                                </strong></span>
                                                        </h4>
                                                    @endif

                                                    <tr>
                                                        <td class='text-right'>{{ $loop->iteration }}.</td>
                                                        <td>&nbsp&nbsp{{ $res->ad_no }}</td>
                                                        <td>&nbsp&nbsp{{ $res->desigination }}</td>
                                                        <td>&nbsp&nbsp{{ $res->service }} - {{ $res->service_group }}
                                                        </td>
                                                        <td class='text-center'>{{ $res->work_level }}</td>
                                                        <td class='text-center'>{{ $res->total_req_seats }}</td>
                                                        <td class='text-center'>{{ $res->open_seats }}</td>
                                                        <td class='text-center'>{{ $res->mahila_seats }}</td>
                                                        <td class='text-center'>{{ $res->janajati_seats }}</td>
                                                        <td class='text-center'>{{ $res->madheshi_seats }}</td>
                                                        <td class='text-center'>{{ $res->dalit_seats }}</td>
                                                        <td class='text-center'>{{ $res->apanga_seats }}</td>
                                                        <td class='text-center'>{{ $res->remote_seats }}</td>
                                                    </tr>
                                                    <?php $is_first += 1; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                @endif
                            </div>
                        @endif
            </div>
        </div>
    </div>
@endsection
