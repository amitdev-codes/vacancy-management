@extends('crudbooster::admin_template')
@section('content')
    <link href="{{asset('css/custom/tabledesign.css') }}" rel="stylesheet" type="text/css"/>

    <div class="btn-group">
        @if($open_candidates)
            <a href="{{ route('openCandidatesDesignationBasedReport', ['action' => "excel",'designation'=>request()->get('designation')]) }}">
                <button class="btn btn-primary">Export to Excel</button>
            </a>
            <a href="{{ route('openCandidatesDesignationBasedReport', ['action' => "file"]) }}" target="_blank">
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
                <p class="nepali_td">खुला तथा समावेसी प्रतियोगितात्मक परीक्षाको लागि Online मार्फत दर्ता भएका आवेदन
                    सम्बन्धि विवरण </p>
            </div>
        </div>
    </header>

    <div class="container" style="width:1100px;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <form method='get' id='form-limit-paging' style="display:inline-block"
                              action='{{Request::url()}}' >
                            {!! CRUDBooster::getUrlParameters(['limit']) !!}
                            <div class="input-group">
                                <select onchange="$('#form-limit-paging').submit()" name='limit' style="width: 56px;"
                                        class='form-control input-sm'>
                                    <option {{($limit==10)?'selected':''}} value='10'>10</option>
                                    <option {{($limit==20)?'selected':''}} value='20'>20</option>
                                    <option {{($limit==50)?'selected':''}} value='50'>50</option>
                                    <option {{($limit==100)?'selected':''}} value='100'>100</option>
                                    <option {{($limit==200)?'selected':''}} value='200'>200</option>
                                    <option {{($limit==500)?'selected':''}} value='500'>500</option>
                                    <option {{($limit==1000)?'selected':''}} value='1000'>1000</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <!-- Designation form -->
                    <div class="col-xs-6">
                        <form method="GET" action="{{route('openCandidatesDesignationBasedReport')}}" style="display:inline-block">
                            <select class="form-control select2-table" name="designation" id="designation" style=" display:inline-block;">
                                <option selected disabled>पद छान्नुहोस्</option>

                                @foreach($designations as $d)
                                    <option value="{{ $d->designation->id }}" {{ $d->designation->id == request()->get('designation')? 'selected' : '' }}>{{ $d->designation->name_np }}--{{ $d->designation->name_en }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-md btn-success">{{ __('Search') }}</button>
                            <a href="{{route('openCandidatesDesignationBasedReport')}}" type="button" class="btn btn-md btn-warning">{{ __('Reset') }}</a>
                        </form>
                    </div>
                </div>
            </div>
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
                        <th>{{__('लिङ्ग')}}</th>
                        <th>{{__('जन्म मिति')}}</th>
                        <th>{{__('शैक्षिक विवरण')}}</th>
                        <th>{{__('मोबाईल नं ')}}</th>
                        <th>{{__('समावेसी समूह ')}}</th>
                        <th>{{__('जम्मा रकम')}}</th>
                        <th>{{__('आवेदन मिति')}}</th>
                        <th>{{__('रशिद नं')}}</th>
                        <th>{{__('क्रमचारी सङ्केत नं')}}</th>
                        <th>{{__('फोटो')}}</th>
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
                            <td>{{$value->gender}}</td>
                            <td>{{$value->date_of_birth}}</td>
                            <td>{{$value->education_degrees}}</td>
                            <td>{{$value->mobile_no}}</td>
                            <td><span class="label label-success">{{$value->applied_group}}</span></td>
                            <td><span class="label label-info">{{$value->total_amount}}</span></td>
                            <td>{{$value->applied_date_bs}}</td>
                            <td>{{$value->paid_receipt_no}}</td>
                            <td>{{$value->nt_staff_code}}</td>
                            <td>
                                <image src="{{asset($value->photo)}}"
                                       onerror="this.onerror=null;this.src='/images/avatar.jpg';"
                                       style="height: 50px;"></image>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-8">{!! urldecode(str_replace("/?","?",$open_candidates->appends(Request::all())->render())) !!}</div>
                @php
                    $from = $open_candidates->count() ? ($open_candidates->perPage() * $open_candidates->currentPage() - $open_candidates->perPage() + 1) : 0;
                    $to = $open_candidates->perPage() * $open_candidates->currentPage() - $open_candidates->perPage() + $open_candidates->count();
                    $total = $open_candidates->total();
                @endphp
                <div class="col-md-4"><span class="pull-right">{{ cbLang("filter_rows_total") }}
            : {{ $from }} {{ cbLang("filter_rows_to") }} {{ $to }} {{ cbLang("filter_rows_of") }} {{ $total }}</span>
                </div>
            </div>

        </div>
    </div>
@endsection
