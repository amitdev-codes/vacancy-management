@extends('vendor.crudbooster.admin_template')
@section('content')
    <style>
        .swal2-title {
            font-family: kalimati;
            src: url('/fonts/kalimati.ttf');
            font-size: 12px;
        }

        .sweet-alert p,
        h2 {
            font-size: 1.6rem !important;
            font-family: kalimati;
        }
    </style>
    <div class="panel panel-success nepali_td">
        <div class="panel-heading">
            <h3 class="panel-title">Applicant Details</h3>
        </div>
        <form role="form" action="{{ route('sajilopayProcessPayment') }}" method="POST">
            {!! csrf_field() !!}
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">Applicant Name:</label>
                    <input type="text" class="form-control" id="name" value="{{ $name_en }}" readonly>
                </div>
                <div class="form-group">
                    <label for="pwd"><b>Token No:</b></label>
                    <input type="text" class="form-control" id="pwd" value="{{ $token }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email"><b>Advertisement No:</b></label>
                    <input type="text" class="form-control" id="email" value="{{ $ad_no }}" readonly>
                </div>

                <div class="form-group">
                    <label for="email"><b>Applied Post:</b></label>
                    <input type="text" class="form-control" id="email" value="{{ $designation_en }}" readonly>
                </div>

                <div class="form-group">
                    <label for="email"><b>Applied Date:</b></label>
                    <input type="text" class="form-control" id="email"
                        value="{{ $applied_date_ad }}--{{ $applied_date_bs }}" readonly>
                </div>

                <div class="form-group">
                    <label for="email"><b>Total Amount:</b></label>
                    <input type="text" class="form-control" id="amount" value="{{ $amt }}" readonly>
                </div>

                <input value="{{ $amt }}" readonly name="amt" type="hidden">
                <input value="0" name="txAmt" type="hidden">
                <input value="0" name="psc" type="hidden">
                <input value="0" name="pdc" type="hidden">
                <input value="{{ $merchant_code }}" name="scd" type="hidden">
                <input value="{{ $transactionid }}" name="pid" type="hidden">
                <input value="{{ $amt }}" name="tAmt" type="hidden">


                <div class="form-check">
                    <input class="form-check-input accept" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        यो {{ $taxtype_name }} निर्धारण मैले {{ Session::get('client_name') }} कार्यालयमा पेश गरेको
                        विवरणको आधारमा
                        भएको ब्यहोरामा म जानकार छु । पछि मेरो विवरण तथा सूचनामा संसोधन हुन गई थप रकम निर्धारण हुन गएमा सो को
                        भुक्तानीको लागि म सहमत छु ।
                    </label>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="submitbutton"onclick="return checkbox();"
                    style='border: none;  padding: 0px;'>
                    <img src="{{ asset('images/sajilopay.png') }}" style="width:100px"></button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        function checkbox() {
            $('.accept').val();
            if ($('.accept').is(":checked")) {
                return true;
            } else {
                swal({
                    title: "कृपया भुक्तानी सम्बन्धी शर्त स्वीकार गर्नुहोस् !!",
                });
                return false;
            }
        }
    </script>
@endsection
