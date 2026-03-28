<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{public_path('vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.css')}}" rel="stylesheet"
          type="text/css" />
    <link href="{{public_path('vendor/crudbooster/assets/adminlte/font-awesome/css/font-awesome.min.css')}}"
          rel="stylesheet" type="text/css" />
    <style>
        @font-face {font-family: "Mangal"; src: url({{asset("fonts/mangal.ttf")}}) format("truetype");}
        body {
            font-family: "Mangal";
        }
        .centered-wrapper {
            position: relative;
            text-align: center;
        }
        .form-info {
            text-align: center;
        }

        .notbold {
            font-weight: normal
        }

        th,
        td {
            line-height: 1.5;
            padding: 5px;
            text-align: center;
        }

        td b {
            font-size: 16px;
        }

        h3 {
            font-size: 18px;
        }

        table#tokentbl td {
            border: none;
        }

        .headertop h3 {
            line-height: 1.5;
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-row-group
        }

        tr {
            page-break-inside: avoid
        }
    </style>
</head>


<body class="main" style="font-family:Mangal">
<section class="invoice" style="font-family:Mangal">
    <div class="box" style="font-family:Mangal">
        <div id='headertop'>
            <h3 style="text-align:center;" class="nepali_td"><b>नेपाल टेलिकम</b></h3>
                <h3 style="text-align:center;margin-top:-20px;"><b>(नेपाल दूरसंचार कम्पनी लिमिटेड)</b></h3>
                    <h3 style="text-align:center;margin-top:-20px;"><b>पदपूर्ति सचिवालय</b> </h3>
                    <img src="{{ asset($apply_info->photo) }}" height="130" width="130" class="img-circle"
                         onerror="this.src= '{{ asset('/images/no-user-image.gif') }}'">
        </div>

        <div class="row main-header">
            <div class="col-md-12">
                <p>
                    <b>(उम्मेदवारको हस्थाक्षर): </b>
                    <img src="{!! asset($apply_info->signature_upload) !!}" height="100" width="100" class="img-circle"
                         onerror="this.src='{{ asset('/img/karki_sir.png') }}'">
                </p>

                <p>
                <h3 class="form-info"><b>अधिकृत तथा सहायक स्तरको पदमा आन्तरिक मुल्यांकन बढुवाको लागि विवरण फारम</b>
                </h3>
                </p>

            </div>

            <div class="col-sm-12 invoice-col">
                <div class="box">
                    <div class="box-body">
                        <div class="">
                            <table border="0" class='table' id="tokentbl">
                                <tbody>

                                <tr>
                                    <td><label class='col-md-4 pull-left'>
                                            <b>सूचना नं : </b>

                                        </label>
                                        <span class='pull-left nepali_td'> {{ $notice_no->notice_no }}</span>
                                    </td>

                                    <td><label class=' pull-left'>
                                            <b>बिज्ञापन नं : </b>

                                        </label>
                                        <span class='pull-left'> {{ $apply_info->ad_no }}</span>
                                        {{-- <span class='pull-left'> {{ $ad_no[0]->ad_title_en }}</span> --}}
                                    </td>

                                    <td><label class=' pull-left'>
                                            <b>टोकन नं : </b>

                                        </label>

                                        <span class='pull-left nepali_td'> {{ $apply_info->token_number }}</span>
                                    </td>
                                    <td><label class='col-md-4 pull-left'>
                                            <b>श्रेणी/तह : </b>

                                        </label>
                                        <span class='pull-left nepali_td'> {{ $apply_info->work_level }}</span>
                                    </td>

                                </tr>
                                <tr><td></td></tr>


                                <tr>
                                    <td><label class=' col-md-4 pull-left'>
                                            <b>बिज्ञापनको किसिम: </b>
                                        </label>
                                        <span class='pull-left'> {{ $ad_no[0]->ad_title_en }}</span></td>
                                    <td><label class='col-md-4 pull-left'>
                                            <b>समूह : </b>
                                        </label>
                                        <span class='pull-left'> {{ $apply_info->service_group }}</span></td>

                                    <td><label class='col-md-4 pull-left'>
                                            <b>उपसमूह : </b>

                                        </label>
                                        <span class='pull-left'> {{ $apply_info->sub_group }}</span></td>

                                    <td><label class='col-md-4 pull-left'>
                                            <b>बढुवा हुने पद : </b>

                                        </label>
                                        <span class='pull-left'> {{ $apply_info->designation_np }}</span></td>
                                </tr>

                                <tr>
                                    <td><label class=' pull-left'>
                                            <b>सेवा : </b>
                                        </label>
                                        <span class='pull-left'> {{ $apply_info->service_group }}</span></td>

                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <div>
                            <h3> <b>आवेदन पेश गरेको मिति(बि.सं.) : {{ $apply_info->applied_date_bs }}</b> </h3>
                            <table border="1" class='table nepali_td' style="border-collapse: inherit;">

                                <tr>
                                    <th style="text-align:left;">क.द.नं.:
                                        <span>{{ $apply_info->nt_staff_code }}</span>
                                    </th>
                                    <th style="text-align:left;" colspan="2">उम्मेदवारको नाम र थर:</th>
                                    <td style="width:50%;"> {{ $apply_info->name_np }}</td>

                                </tr>
                                <tr>
                                    <th style="text-align:left;height:60px" rowspan="2">ठेगाना: </th>

                                    <td>
                                        <b>स्थायी</b>
                                    </td>
                                    <td colspan="2">{{ $address[0]->perm_district }}, {{ $address[0]->perm_local_level }},
                                        {{ $address[0]->ward_no }},
                                        {{ $address[0]->tole_name }}
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <b>अस्थायी</b>
                                    </td>
                                    <td colspan="2">
                                        {{ $address[0]->temp_district }}, {{ $address[0]->temp_local_level }},
                                        {{ $address[0]->temp_ward_no }}, {{ $address[0]->temp_tole_name
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align:left;height:60px" rowspan="2" colspan="2">हालको:</th>
                                    <td>
                                        <b>पद : </b>{{ $current_position->designation }}</td>
                                    <td colspan="2">
                                        <b>श्रेणी/तह : </b>{{ $current_position->work_level }}</td>


                                </tr>
                                <tr>
                                    <td>
                                        <b>सेवा : </b>{{ $current_position->service_group }}</td>
                                    <td colspan="2">
                                        <b>समूह : </b>{{ $current_position->service_group }}</td>


                                </tr>


                                </tr>
                            </table>
                        </div>
                        <div>
                            <h3><b>१.</b></h3>
                            <table border="1" class='table' style="border-collapse: inherit;">
                                <tr>

                                    <th style="text-align:left;height:30px" colspan="4">
                                        हालको पदको जेष्ठता(seniority)मिति (बि.सं.):
                                        <span class='notbold'>{{ $current_position->seniority_date_bs }}</span>

                                    </th>


                                </tr>
                                <tr>
                                    <th style="text-align:left;height:30px" colspan="4">नागरिकता जारी भएको जिल्ला:
                                        <span class='notbold'>{{ $address[0]->citizenship_issued_district }}</span>
                                    </th>


                                </tr>


                            </table>
                        </div>

                        <div>
                            <h3> <b>२. शैक्षिक योग्यतासम्बन्धी विवरण: </b> </h3>
                            <table border="1" class='table' style="border-collapse: collapse;">
                                <thead>
                                <tr>
                                    <th>योग्यता</th>
                                    <th>डिग्री</th>
                                    <th>शिक्षण संस्था</th>
                                    <th>मुख्य विषय</th>
                                    <th>श्रेणी</th>
                                    <th>प्रमाणपत्र जारी मिति</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($education as $da)
                                    <tr>
                                        <td>{{ $da->name_en }}</td>
                                        <td>{{ $da->university }}</td>
                                        <td>{{ $da->specialization}}</td>
                                        <td>{{ $da->division }}</td>
                                        <td>{{ $da->passed_year_bs }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                        <div>
                            <h3> <b>३.भौगोलिक क्षेत्र:</b> </h3>
                            <table border="1" class='table' style="border-collapse: collapse;">
                                <thead>
                                <tr>
                                    <th rowspan="2">कार्यालयहरु</th>
                                    <th rowspan="2">जिल्ला</th>
                                    <th colspan="2">कार्यरत मिति</th>

                                </tr>
                                <tr>

                                    <td style="text-align:center">
                                        <b>देखि</b>
                                    </td>
                                    <td style="text-align:center">
                                        <b>सम्म</b>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($service_history as $sh)
                                    <tr>
                                        <td>{{ $sh->working_office }}</td>
                                        <td>{{ $sh->district }}</td>
                                        <td>{{ $sh->date_from_bs }}</td>
                                        <td>{{ $sh->date_to_bs }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>



                        <div>
                            <h3>
                                <b> ४.कार्यालय प्रमुख भएर कार्य गरेको अवधि: </b>
                            </h3>
                            <table border="1" style="border-collapse: collapse;" class='table'>
                                <thead>
                                <tr>
                                    <th rowspan="2">कार्यालयहरु</th>
                                    <th colspan="2">कार्यरत मिति</th>

                                </tr>
                                <tr>

                                    <td style="text-align:center">
                                        <b>देखि</b>
                                    </td>
                                    <td style="text-align:center">
                                        <b>सम्म</b>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($office_incharge as $oi)
                                    <tr>
                                        <td>{{ $oi->working_office }}</td>
                                        <td>{{ $oi->incharge_date_from_bs }}</td>
                                        <td>{{ $oi->incharge_date_to_bs }}</td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                        </div>



                        <div>
                            <h3>
                                <b> ५.असाधारण बिदा,गयल कट्टी र अध्यन बिदा सम्बन्धि विवरण (यदि भएमा): </b>
                            </h3>
                            <table border="1" style="border-collapse: collapse;" class='table'>
                                <thead>
                                <tr>
                                    <th rowspan="2">बिदाको किसिम</th>
                                    <th colspan="2">अवधि</th>

                                </tr>
                                <tr>

                                    <td style="text-align:center">
                                        <b>देखि</b>
                                    </td>
                                    <td style="text-align:center">
                                        <b>सम्म</b>
                                    </td>

                                </tr>

                                </thead>
                                <tbody>


                                @if(empty($office_incharge[0]->leave_letter))
                                    <tr>
                                        <td colspan="3" style="text-align:center">
                                            <b>No Records Found!!!</b>
                                        </td>
                                    </tr>
                                @else @foreach($office_incharge as $officei)
                                    <tr>
                                        <td style="height:8px">{{ $officei->name_en }}</td>
                                        <td style="height:8px">{{ $officei->name_en }}</td>
                                        <td style="height:8px">{{ $officei->name_en }}</td>
                                    </tr>
                                @endforeach @endif

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>