<html>
<head >
    <link href="{{asset('css/custom/tabledesign.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .heading-report {
            text-align: -webkit-right;
            margin-right: 45%;
        }


        h5 {
            font-size: 19px;
            font-weight: 700;
        }

        h6 {
            line-height: 15px;
            font-size: 14px !important;
            font-weight: 600;
        }

        p {
            text-align: center;
            font-weight: 700;
            font-size: 18px;
        }
    </style>
    <link href="../../../css/rwd-table.min.css" rel="stylesheet">
    <script type="text/javascript" src="../../../js/jquery-1.9.1.min.js"></script>
</head>
    <body>
    <header style="width:1100px;">
        <div class="left header panel panel-primary nepali_td">
            <div clas="panel-body">
                <div class="heading-report">
                    <h5 class="nepali_td"><img src="{{asset('images/logo.png')}}" height="50px;" width="50px;"
                                               style="margin-right:20px;">नेपाल टेलिकम</h5>
                    <br>
                    <h5 style="margin-top: -35px; margin-right: -17px;" class="nepali_td">पदपूर्ति सचिवालय</h5>

                </div>
            </div>
            <div class='panel-footer'>
                <p class="nepali_td">खुला तथा समावेसी प्रतियोगितात्मक परीक्षाको लागि Online मार्फत दर्ता भएका आवेदन
                    सम्बन्धि विवरण </p>
            </div>
        </div>
    </header>
    <div class="container" style="width:1100px;">
        <div class="panel panel-primary">
            <div class="panel-body" style="overflow-x:auto;">
                <table class="table table-striped table-bordered table-responsive nepali_td"
                       id="candidates">
                    <thead>
                    <tr>
                        <th>{{__('क्रम संख्या')}}</th>
                        <th>{{__('तह')}}</th>
                        <th>{{__('पदको नाम')}}</th>
                        <th>{{__('टोकन नं ')}}</th>
                        <th>{{__('पुरा नाम')}}</th>
                        <th>{{__('फोटो')}}</th>
                        <th>{{__('मोबाईल नं ')}}</th>
                        <th>{{__('समावेसी समूह ')}}</th>
                        <th>{{__('जम्मा रकम')}}</th>
                        <th>{{__('आवेदन मिति')}}</th>
                        <th>{{__('रशिद नं')}}</th>
                        <th>{{__('क्रमचारी सङ्केत नं')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($open_candidates as $value)
                        <tr>
                            <td>{{($open_candidates->currentPage()-1) * $open_candidates->perPage() + $loop->iteration  }}</td>
                            <td>{{$value->work_level}}</td>
                            <td>{{$value->designation_np}}</td>
                            <td>{{$value->token_number}}</td>
                            <td>{{$value->name_np}}</td>
                            <td>
                                <image src="{{asset($value->photo)}}"
                                       onerror="this.onerror=null;this.src='/images/avatar.jpg';"
                                       style="height: 50px;"></image>
                            </td>
                            <td>{{$value->mobile_no}}</td>
                            <td><span class="label label-success">{{$value->applied_group}}</span></td>
                            <td><span class="label label-info">{{$value->total_paid_amount}}</span></td>
                            <td>{{$value->applied_date_bs}}</td>
                            <td>{{$value->paid_receipt_no}}</td>
                            <td>{{$value->nt_staff_code}}</td>
                        </tr>
                        <tr>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </body>
</html>
