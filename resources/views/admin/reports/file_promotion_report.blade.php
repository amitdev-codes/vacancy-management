<html>

<head>
    <meta charset="utf-8" />
    <style>
        @font-face {
            font-family: 'Kalimati';
            src: url({{ asset('fonts/kalimati.ttf') }}) format('truetype');
            font-weight: normal;
        }

        .engnepfont {
            font-family: 'Kalimati', serif;
            text-align: justify;
        }

        body {
            margin: 0 auto;
            font-size: 13px;
            font-family: Kalimati, serif;
            padding: 15px 15px 15px 25px;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .govlogo {
            float: left;
            height: 98px;
            width: 80px;
            clear: right;
        }

        .head {
            text-align: center;
            margin-left: 20%;
            float: left;
            clear: right;
            height: 90px;
            margin-top: 10px;
            line-height: 24px;
        }

        .source {
            margin-top: 5px;
            float: right;
            text-align: right;
            /*height: 90px;*/
            font-size: 11px;
        }

        .source p {
            line-height: 16px;
        }

        table {
            border-collapse: collapse;
            table-layout: auto;
        }

        table thead tr th {
            vertical-align: top;
            /*height: 30px;*/
        }

        thead tr th {
            font-size: 12px;
            white-space: normal;
            word-wrap: break-word;
            white-space: nowrap;
            border-collapse: collapse;
        }

        tr th {
            font-size: 12px;
            white-space: normal;
            word-wrap: break-word;
            white-space: nowrap;
            border-collapse: collapse;
            padding: 1px;
        }

        table tr td {
            border-collapse: collapse;
            position: relative;
            font-size: 12px;
            white-space: normal;
            word-wrap: break-word;
            white-space: nowrap;
            vertical-align: top;
            padding: 1px;
        }

        /*thead { display: table-row-group; }
        tr { page-break-inside: avoid !important;}*/
        /*	thead {  page-break-inside: avoid !important;page-break-after: auto !important;}
            tr, div{ page-break-inside: avoid !important; page-break-after: auto !important*/


        .border-right {
            border-right: 1px solid #000;
        }

        .watermark {
            position: fixed;
            margin-left: 5%;
            z-index: 0;
            margin-top: 10%;
            display: block;
        }

        .watermark-text,
        .watermark-img {
            color: #e8e8e8;
            font-size: 80px;
            font-weight: bold;
            margin-left: 50px;
            transform: rotate(-30deg);
            -webkit-transform: rotate(-30deg);
            opacity: 0.3;
        }

        .watermark-img {
            opacity: 0.2;
        }

        .width1 {
            width: 420px !important;
        }

        .width2 {
            width: 420px !important;
        }

        .pleft {
            padding-left: 30px;
        }

        .rowborder {
            border-bottom: 1px solid #000;
        }

        .break tr td,
        .wbreak {
            white-space: normal;
        }
    </style>
</head>

<body>
    <header>
        <div class="govlogo">
            <img src="{{ asset('/images/logo.png') }}" width="80" height="80" alt="" />
        </div>
        <div class="head">
            <span><b>नेपाल टेलिकम</b></span><br />
            <span style="padding-bottom:4px;border-bottom:1px solid #000;"><b>(नेपाल दूरसंचार कम्पनी
                    लिमिटेड)</b></span><br />
            <span><b>पदपूर्ति सचिवालय</b></span><br />
            <span style="padding-bottom:4px;"><b>अधिकृत तथा सहायक स्तरको पदमा आन्तरिक मुल्यांकन बढुवाको लागि उम्मेदवारको
                    विवरण फारम</b></span>
        </div>
        <div class="source">
            <p>श्रोत : नेपाल टेलिकम</p>
            <p>Province 3,Kathmandu Nepal</p>
            <p>फोन: 01-4511222</p>
            <p>फ्याक्स नं: 501041</p>
        </div>
    </header>


    <div>
        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #000;clear: both;">
            <tr>
                <td width="250">सूचना नं: <span class="engnepfont">{{ $notice_no }}</span></td>
                <td width="250">बिज्ञापन नं: {{ $vacancy_ad_no }}</td>
                <td width="320">टोकन नं: {{ $token_no }}</td>
                <td>बिज्ञापनको किसिम: {{ $ad_title_en }}</td>
                <td>सेवा: <span class="engnepfont">{{ $service_group }}</span></td>
            </tr>
            <tr>
                <td width="320">श्रेणी/तह : {{ $work_level }}</td>
                <td style="font-family: Arial, Helvetica, sans-serif;">समूह: {{ $service_group }}</td>
                <td>उपसमूह: <span class="engnepfont">{{ $service_group }}</span></td>
                <td>बढुवा हुने पद: <span class="engnepfont">{{ $designation_np }}</span></td>

            </tr>
        </table>
    </div>
    {{-- #personal details --}}
    <div style="border: 1px solid #000;clear: both;">
        <tr>
            <td class="border-right"><b>व्यक्तिगत विवरण</b></td>
        </tr>
        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #000;clear: both;">
            <tr>
                <td width="150">कर्मचारी संकेत नं: <span class="engnepfont">{{ $nt_staff_code }}</span></td>
                <td width="250">पुरा नाम: {{ $name_np }}</td>
                <td width="320">आवेदन पेश गरेको मिति(बि.सं.): {{ $applied_date_bs }}</td>
                <td rowspan="2">
                    <img src="{{ asset($photo) }}" width="70" height="70" style="padding: 3px;"
                        alt="{{ asset('/images/user.png') }}" />
                </td>
            </tr>
            <tr>
                <td colspan="2">हालको पदको जेष्ठता(seniority)मिति (बि.सं.):
                    {{ $current_position->seniority_date_bs }}</td>
                <td colspan="1">नागरिकता जारी भएको जिल्ला: {{ $address->citizenship_issued_district }}</td>
                <td>(उम्मेदवारको हस्थाक्षर):
                    <img src="{{ asset($signature_upload) }}" width="20" height="20"
                        alt="{{ asset('/images/no-user-image.gif') }}" />
                </td>
            </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #000;">
            <tr>
                <td class="width2"><b> हालको ठेगाना</b></td>
                <td class="border-right width1"><b>साबिकको ठेगाना</b></td>
            </tr>
            <tr>
                <td class="border-right">
                    जिल्ला:{{ $address->temp_district }}
                    <span class="pleft">गा.वि.स./न.पा.:{{ $address->temp_local_level }} </span>
                </td>
                <td class="border-right1">
                    जिल्ला:{{ $address->perm_district }}
                    <span class="pleft">गा.वि.स./न.पा.:{{ $address->perm_local_level }} </span>
                </td>
            </tr>
            <tr class="rowborder">
                <td class="border-right">
                    वार्ड नं:{{ $address->temp_ward_no }}
                    <span class="pleft"> टोल नाम:{{ $address->temp_tole_name }}</span>
                </td>
                <td class="border-right1">
                    वार्ड नं:{{ $address->ward_no }}
                    <span class="pleft"> टोल नाम:{{ $address->tole_name }}</span>
                </td>
            </tr>

            {{-- current working --}}
            <tr>
                <td class="border-right width1"><b>हाल कार्यरत कार्यालय </b></td>
                <td class="width2"><b>हालको पदको नियुक्ति मिति</b></td>
            </tr>
            <tr>
                <td class="border-right">{{ $current_position->working_office }}</td>
                <td class="border-right"></td>
                {{-- <td class="wbreak">
                    <span style="padding-left: 20px;">हालको पदको नियुक्ति मिति :
                        {{ $current_position->date_from_bs }}</span>
                </td> --}}
            </tr>
        </table>
    </div>

    {{-- #working office details --}}
    <table border="1" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 10px;" class="break">
        <thead>
            <tr>
                <th colspan="7" align="left"><b>भौगोलिक क्षेत्र</b></th>
            </tr>
            <tr>
                <th>क्र.सं.</th>
                <th>कार्यालयहरु</th>
                <th>भौगोलिक वर्ग </th>
                <th>कार्यरत मिति देखि</th>
                <th>कार्यरत मिति सम्म</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applicant_service_history as $sh)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $sh->working_office }}</td>
                    <td>{{ $sh->varga }}</td>
                    <td>{{ $sh->date_from_bs }}</td>
                    <td>{{ $sh->date_to_bs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br />
    <br />
    {{-- #education details --}}
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
        <thead>
            <tr>
                <th colspan="8" align="left"><b>शैक्षिक योग्यता विवरण</b></th>
            </tr>
            <tr>
                <th>सि.नं.</th>
                <th>तह</th>
                <th>संकाय</th>
                <th>अध्ययन संस्था</th>
                <th>उतिर्ण गरेको साल</th>
                <th>श्रेणी</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($education as $da)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $da->level }}</td>
                    <td>{{ $da->edu_degree }}</td>
                    <td>{{ $da->university }}</td>
                    <td>{{ $da->passed_year_bs }}</td>
                    <td>{{ $da->division }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br />
    {{-- #training details --}}
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
        <!--<thead>-->
        <tr>
            <th colspan="8" align="left"><b>तालिमको विवरण</b></th>
        </tr>
        <tr>
            <th>सि.नं.</th>
            <th>तालिम</th>
            <th>निकाय</th>
            <th>तालिम संस्था </th>
            <th>तालिमको विवरण</th>
            <th>सुरुवाती बर्ष</th>
            <th>अवधि</th>
        </tr>
        <tbody>

            @foreach ($training_details as $td)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $td->training_title }}</td>
                    <td>{{ $td->training }}</td>
                    <td>{{ $td->institute_name }}</td>
                    <td>{{ $td->training_major }}</td>
                    <td>{{ $td->year_bs }}</td>
                    <td>{{ $td->duration_period }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br />

    {{-- #leave details --}}
    <table border="1" cellspacing="0" cellpadding="0" width="100%">
        <thead>
            <tr>
                <th colspan="8" align="left"><b>विदाको विवरण</b></th>
            </tr>
            <tr>
                <th>सि.नं.</th>
                <th>बिदाको किसिम </th>
                <th>बाट</th>
                <th>सम्म</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leave_details as $ld)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $ld->leave_type }}</td>
                    <td>{{ $ld->date_from_bs }}</td>
                    <td>{{ $ld->date_to_bs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
</body>

</html>
