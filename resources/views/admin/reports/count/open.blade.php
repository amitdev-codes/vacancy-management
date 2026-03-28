@extends('crudbooster::admin_template')
@section('content')
    <link href="{{asset('css/custom/tabledesign.css') }}" rel="stylesheet" type="text/css"/>

    <div class="btn-group">
        @if($open_candidates)
            <a href="{{ route('open_candidates_report', ['action' => "excel"]) }}">
                <button class="btn btn-primary">Export to Excel</button>
            </a>
            <a href="{{ route('open_candidates_report', ['action' => "file"]) }}" target="_blank">
                <button class="btn btn-primary">Export to File</button>
            </a>
        @endif
    </div>
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
                <p class="nepali_td">खुला तथा समावेसी प्रतियोगितात्मक परीक्षाको लागि Online मार्फत दर्ता भएका आवेदन सम्बन्धि संख्यात्मक विवरण  </p>
            </div>
        </div>
    </header>
    <div class="container" style="width:1100px;">
        <div class="panel panel-primary">
            <div class="panel-body" style="overflow-x:auto;">
                <table class="table table-striped table-bordered  nepali_td"
                       id="candidates">
                    <thead>
                    <tr>
                        <th>{{__('क्रम संख्या')}}</th>
                        <th>{{__('बिज्ञापन नं ')}}</th>
                        <th>{{__('पदको नाम')}}</th>
                        <th>{{__('तह')}}</th>
                        <th>{{__('सेवा/समूह /उप समूह ')}}</th>
                        <th>{{__('रिक्त पद संख्या')}}</th>
                        <th>{{__('आवेदक संख्या ')}}</th>
                        <th>{{__('आवेदक स्वीकृत संख्या ')}}</th>
                        <th>{{__('आवेदक अस्वीकृत संख्या ')}}</th>
                        <th>{{__('दोहोरो परेको आवेदन हटाईएको')}}</th>
                        <th>{{__('टेस्ट आवेदन हटाईएको')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalApplied =$totalVacantSeats= $totalSelected = $totalCancelled = 0;
                    @endphp
                    @foreach ($open_candidates as $value)
                        @php
                              $totalVacantSeats += $value->vacant_seats;
                              $totalApplied += $value->applied_users;
                              $totalSelected += $value->accepted_applicants;
                              $totalCancelled += $value->cancelled_applicants;
                        @endphp
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$value->adv_name}}</td>
                            <td>{{$value->designation_name}}</td>
                            <td>{{$value->work_level}}</td>
                            <td>{{$value->service_group}}/{{$value->service_group_name}}</td>
                            <td>{{$value->vacant_seats}}</td>
                            <td>{{$value->applied_users}}</td>
                            <td><span class="label label-success">{{$value->accepted_applicants}}</span></td>
                            <td><span class="label label-danger">{{$value->cancelled_applicants}}</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>

                        </tr>
                    @endforeach
                    <tr style="font-weight: 800;color:white;background: #3B72A0">
                        <td colspan="5"><b><span style="text-align: center;">{{ __('जम्मा') }}</span></b></td>
                        <td>{{ $totalVacantSeats }}</td>
                        <td>{{ $totalApplied }}</td>
                        <td>{{ $totalSelected }}</td>
                        <td>{{ $totalCancelled }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
