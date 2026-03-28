@extends('crudbooster::admin_template')
@section('content')
    <link href="{{ asset('css/custom/tabledesign.css') }}" rel="stylesheet" type="text/css" />
    @if ($ad_id)
        @foreach ($adno_data as $ad)
            @if ($ad->id == $id)
                @php
                    $combo_title = $ad->ad_title_en;
                @endphp
            @endif
        @endforeach
    @else
        @php
            $combo_title = 'विज्ञापन';
        @endphp
    @endif

    <!-- Single button -->

    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle nepali_td" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">{{ $combo_title }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            @if ($adno_data)
                @foreach ($adno_data as $ad)
                    <li><a class="dropdown-item nepali_td"
                            href="{{ route('loksewaexport', ['id' => $ad->id]) }}">{{ $ad->ad_title_en }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>

    @if (!empty($id))
        @foreach ($designation_data as $md)
            @if ($md->designation->id == $designation_id)
                @php
                    $combo_title_designation_en = $md->designation->name_en;
                    $combo_title_designation_np = $md->designation->name_np;
                @endphp
            @endif
        @endforeach
    @else
        @php
            $combo_title_designation_en = 'पद';
        @endphp
    @endif

    <div class="btn-group">
        <button type="button" class="btn btn-success dropdown-toggle nepali_td" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">{{ $combo_title_designation_en }}--{{ $combo_title_designation_np }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            @if ($designation_data)
                @foreach ($designation_data as $value)
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('loksewaexport', ['id' => $vacancy_ad_id, 'designation_id' => $value->designation->id]) }}">{{ $value->designation->name_en }}-{{ $value->designation->name_np }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>


    <div class="btn-group">
        @if ($candidate_data)
            <a href="{{ route('loksewaExportExcel', ['id' => $ad_id, 'designation_id' => $designation_id]) }}"><button
                    class="btn btn-primary">Export to Excel</button></a>
            {{--            <a href="{{route('loksewaExportpdf',['id'=>$ad_id,'designation_id'=>$designation_id])}}"><button class="btn btn-primary">Export to PDF</button></a> --}}
        @endif
    </div>
    @if (CRUDBooster::isSuperadmin())
        <div class="btn-group">
            @if ($candidate_data)
                <a href="{{ route('loksewaExportReport', ['id' => $ad_id, 'designation_id' => $designation_id]) }}"><button
                        class="btn btn-danger">Export to LokSewa</button></a>
            @endif
        </div>
    @endif
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
    <header>
        <div class="left header panel panel-primary nepali_td">
            <div clas="panel-body">
                <div class="heading-report">
                    <h5 class="nepali_td"><img src="{{ asset('images/logo.png') }}" height="50px;" width="50px;"
                            style="margin-right:20px;">नेपाल टेलिकम</h5>
                    <br>
                    <h5 style="margin-top: -35px; margin-right: -17px;" class="nepali_td">पदपूर्ति सचिवालय</h5>

                </div>
                @if (!empty($id) && !empty($designation_id))
                    <h6 class="nepali_td">विज्ञापन: {{ $candidate_data[0]->ad_no }} </h6>
                    <h6 class="nepali_td">पद: {{ $candidate_data[0]->designation }} </h6>
                @endif
            </div>
            <div class='panel-footer'>
                <p class="nepali_td">खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</p>
            </div>
        </div>
    </header>
    <form method='get' id='form-limit-paging' style="display:inline-block" action='{{ Request::url() }}'>
        {!! CRUDBooster::getUrlParameters(['limit']) !!}
        <div class="input-group">
            <select onchange="$('#form-limit-paging').submit()" name='limit' style="width: 56px;"
                class='form-control input-sm'>
                <option {{ $limit == 5 ? 'selected' : '' }} value='5'>5</option>
                <option {{ $limit == 10 ? 'selected' : '' }} value='10'>10</option>
                <option {{ $limit == 20 ? 'selected' : '' }} value='20'>20</option>
                <option {{ $limit == 25 ? 'selected' : '' }} value='25'>25</option>
                <option {{ $limit == 50 ? 'selected' : '' }} value='50'>50</option>
                <option {{ $limit == 100 ? 'selected' : '' }} value='100'>100</option>
                <option {{ $limit == 200 ? 'selected' : '' }} value='200'>200</option>
                <option {{ $limit == 500 ? 'selected' : '' }} value='500'>500</option>
                <option {{ $limit == 1000 ? 'selected' : '' }} value='1000'>1000</option>
            </select>
        </div>
    </form>
    <div class="box box-solid box-primary" style="overflow-x:auto;">
        <form id='form-table' method='post'>
            <table class="table-responsive table-striped table-bordered table nepali_td" id="candidates">
                <thead>
                    <tr>
                        <th>S.NO</th>
                        <th>Roll</th>
                        <th>Applicant Name</th>
                        <th>Gender</th>
                        <th>Photo</th>
                        <th>Signature</th>
                        <th>Token No.</th>
                        <th>Applicant ID</th>
                        <th>Citizenship No/District</th>
                        <th colspan="7">Privileged group</th>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Open</th>
                        <th>Female</th>
                        <th>Janajati</th>
                        <th>Madhesi</th>
                        <th>Dalit</th>
                        <th>Handicapped </th>
                        <th>Remote</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($candidate_data)
                        @foreach ($candidate_data as $value)
                            <tr>
                                <td>{{ ($candidate_data->currentPage() - 1) * $candidate_data->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $value->exam_roll_no }}</td>
                                <td>{{ $value->full_name_np }}<br />{{ $value->full_name }}</td>
                                <td>{{ $value->gender }}</td>
                                <td>
                                    <image src="{{ asset($value->photo) }}"
                                        onerror="this.onerror=null;this.src='/images/avatar.jpg';" style="height: 50px;">
                                    </image>
                                </td>
                                <td>
                                    <image src="{{ asset($value->signature) }}"
                                        onerror="this.onerror=null;this.src='/images/logo.png';" style="height: 50px;">
                                    </image>
                                </td>
                                <td>{{ $value->token_number }}</td>
                                <td>{{ $value->applicant_id }}</td>
                                <td>{{ $value->citizenship_no }}/{{ $value->citizenship_district }}</td>
                                <td>
                                    @if ($value->is_open == true)
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($value->is_female == true)
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($value->is_janajati == true)
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($value->is_madhesi == true)
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($value->is_dalit == true)
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($value->is_handicapped == true)
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($value->is_remote_village == true)
                                        <i class="fa fa-check" aria-hidden="true"></i>@else{{ '-' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </form>
        <div class="col-md-8">{!! urldecode(str_replace('/?', '?', $candidate_data->appends(Request::all())->render())) !!}</div>
        @php
            $from = $candidate_data->count()
                ? $candidate_data->perPage() * $candidate_data->currentPage() - $candidate_data->perPage() + 1
                : 0;
            $to =
                $candidate_data->perPage() * $candidate_data->currentPage() -
                $candidate_data->perPage() +
                $candidate_data->count();
            $total = $candidate_data->total();
        @endphp
        <div class="col-md-4"><span class="pull-right">{{ cbLang('filter_rows_total') }}
                : {{ $from }} {{ cbLang('filter_rows_to') }} {{ $to }} {{ cbLang('filter_rows_of') }}
                {{ $total }}</span>
        </div>
    </div>
@endsection
