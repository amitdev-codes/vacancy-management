<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style type = "text/css">
        @font-face {
            font-family: "Kalimati";
            src: url({{ URL::asset("fonts/kalimati.ttf")}}) format("truetype");
        }

        body {
            font-family: "Kalimati";
            margin: 0 auto;
        }
        .nepali_td{
              font-family: "Kalimati";
        }

        table#tokentbl td {
            border: none;
        }

        .headertop h3 {
            line-height: 1.5;
        }

        tr {
            page-break-inside: avoid
        }
        .img-logo{float: left; clear: right; margin-left: 20%;margin-right: 20px;}
        .heading-report{padding: 10px;}
    </style>
</head>

<body class="main">
    <section class="invoice">
        <div class="box">
            <div class="heading-report">
                <img src="{{asset('/images/logo.png')}}"  height="90" width="90" class="img-circle img-logo">
                {{-- <img src="ntc-logo.jpg"  height="90" width="90" class="img-circle img-logo"> --}}
                <div class="" style="float: left; text-align: center;clear: right;">
                    <h3><b>नेपाल दूरसंचार कम्पनी लिमिटेड</b></h3>
                    <h5><b>केन्द्रीय कार्यालय</b> </h5>
                </div>
            </div>
      
            <div class="intro" style="margin-left:10px;margin-top:20px;clear: both;">
                <table border="0" id="tokentbl" width="100%">
                    <tbody>
                        <tr>
                            <td><label class=' pull-left'><b>रसिद नं(TXN ID): </b></label><span
                                    class='pull-left'>&nbsp;{{$receipt}}</span></td>
                            <td style="float: right;">
                                <label class='pull-left'><b>मिति: </b></label>
                                <span class='pull-left'>{{$receipt_date}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- start of personal information -->
            <div class="intro" style="margin-left:10px;">
                <table border="0" id="tokentbl" width="100%">
                    <h4 style="text-align: center;"> <b>नगदी रसिद</b> </h4>
                    <tbody>
                        <tr>
                            <td><label class=' pull-left'><b>Token No.: </b></label><span
                                    class='pull-left'>&nbsp;{{$token_number}}</span></td>
                            <td style="float: right;"><label class=' pull-left'><b>Applicant ID: </b></label><span
                                    class='pull-left'>{{$applicant_id}}</span></td>
                        </tr>
                        <tr>
                            <td><label class='pull-left'><b>Applicants name: </b></label><span
                                    class='pull-left'>{{$applicant_name}}
                                    </span></td>
                        </tr>
                        <tr>
                            <td><label class=' pull-left'><b>Applied post : </b></label><span class='pull-left'>
                                    {{$Designation}}</span></td>
                        </tr>
                        <tr>
                            <td><label class=' pull-left'><b>Adv No. : </b></label><span class='pull-left'>
                                    {{$adv_no}}</span></td>
                        </tr>

                        <tr>
                            <td><label class=' pull-left'><b>Payment Types: </b></label><span
                                    class='pull-left'>&nbsp;Online({{$psp_mode}})</span></td>
                            <td style="float: right;"><label class=' pull-left'><b>Total Amount: Rs. </b></label><span
                                    class='pull-left'>{{$amount}}</span></td>
                        </tr>

                        <tr>
                            <td><label class=' pull-left'><b>Internal Competition: </b></label>
                                <span class='pull-left'>
                                    <input type="checkbox" value="" id="flexCheckDefault">
                                </span>
                            </td>
                            <td style="float: right;"><label class='pull-left'><b>Open Competition: </b></label>
                                <span class='pull-left'>
                                    @if(!empty($is_open))
                                    <input type="checkbox" value="1" id="flexCheckDefault" checked>
                                    @endif
                                </span>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="remarks"></label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="seniority" style="margin-left:10px;margin-right:10px;">
                <table border="1" style="border-collapse: collapse;background-color: #f1f1c1;" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center">Group</th>
                            <th style="text-align:center">Amount (NRs)</th>
                        </tr>
                    </thead>
                    <tbody>
                          <tr>
                              <td width="30%">Open</td>
                              @if(!empty($is_open))
                              <td>{{$amount_for_job}}</td>
                              @endif
                          </tr>

                          <tr>
                            <td>Mahila</td>
                            @if(!empty($is_female))
                            <td>{{'200'}}</td>
                            @endif
                          </tr>
                          <tr>
                            <td>AAdiwasi/janjati</td>
                            @if(!empty($is_janajati))
                            <td>{{'200'}}</td>
                            @endif
                          </tr>
                          <tr>
                            <td>Madhesi</td>
                            @if(!empty($is_madhesi))
                            <td>{{'200'}}</td>
                            @endif
                          </tr>
                          <tr>
                            <td>Dalit</td>
                            @if(!empty($is_dalit))
                            <td>{{'200'}}</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Disabled</td>
                            @if(!empty($is_handicapped))
                            <td>{{'200'}}</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Remote</td>
                          @if(!empty($is_remote_village))
                            <td>{{'200'}}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><b>Total exam fee</b></td>
                            <td><b>{{$amount}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>