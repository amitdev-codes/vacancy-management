@extends('crudbooster::admin_template')
@section('content')
    <style>
        .swal2-title {
            font-family: kalimati;
            src: url('/fonts/kalimati.ttf');
            font-size: 12px;
        }

        .sweet-alert p, h2 {
            font-size: 1.6rem !important;
            font-family: kalimati;
        }</style>
    <link href="{{asset('css/custom/tabledesign.css') }}" rel="stylesheet" type="text/css"/>
    <div class="panel panel-success nepali_td">
        <div class="panel-heading">
            <h3 class="panel-title">Applicant Details</h3>
        </div>

        <div class="panel-body">
            <form method="GET" action="{{route('namastePayLogin')}}">
                <div class="form-group">
                    <label for="name">Applicant Name:</label>
                    <input type="text" class="form-control" id="name" value="{{$name_en}}" readonly>
                </div>
                <div class="form-group">
                    <label for="pwd"><b>Token No:</b></label>
                    <input type="text" class="form-control" id="pwd" value="{{$token}}" readonly>
                </div>
                <div class="form-group">
                    <label for="email"><b>Advertisement No:</b></label>
                    <input type="text" class="form-control" id="email" value="{{$ad_no}}" readonly>
                </div>

                <div class="form-group">
                    <label for="email"><b>Applied Post:</b></label>
                    <input type="text" class="form-control" id="email" value="{{$designation_en}}" readonly>
                </div>

                <div class="form-group">
                    <label for="email"><b>Applied Date:</b></label>
                    <input type="text" class="form-control" id="email"
                           value="{{$applied_date_ad}}--{{$applied_date_bs}}"
                           readonly>
                </div>

                <div class="form-group">
                    <label for="email"><b>Total Amount:</b></label>
                    <input type="text" class="form-control" id="amount" value="{{$amt}}" readonly>
                </div>
                <div class="form-check">
                    <input class="form-check-input accept" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                           यो निर्धारण मैले कार्यालयमा पेश गरेको विवरणको आधारमा भएको ब्यहोरामा म जानकार छु ।
               पछि मेरो  विवरण तथा सूचनामा संसोधन हुन गई थप रकम निर्धारण हुन गएमा सो को
           भुक्तानीको लागि म सहमत छु ।
                    </label>
                </div>
                <button type="submit" class="btn btn-default payment-button" style="background-color: transparent;border: none">
                    <img src="{{ asset('images/namastepay.png') }}" alt="Submit" class="submit-icon" style="width:100px">
                </button>
            </form>
        </div>
    </div>
@endsection
