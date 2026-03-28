@extends('crudbooster::admin_template')
@section('content')
<style>.swal2-title {font-family: kalimati; src: url('/fonts/kalimati.ttf');font-size: 12px;}.sweet-alert p,h2{
  font-size: 1.6rem !important;
  font-family: kalimati;
}</style>
<script src="{{asset('js/khalti-checkout.js') }}"></script>
<link href="{{asset('css/custom/tabledesign.css') }}" rel="stylesheet" type="text/css"/>

<form role="form" action="{{route('loadKhalti')}}"  method="POST">
    {!! csrf_field() !!}
 <div class="panel panel-success nepali_td">
   <div class="panel-heading">
    <h3 class="panel-title">Applicant Details</h3>
   </div>

   <!-- form start -->
     <div class="panel-body">
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
       <input type="text" class="form-control" id="email" value="{{$applied_date_ad}}--{{$applied_date_bs}}" readonly>
     </div>

     <div class="form-group">
       <label for="email"><b>Total Amount:</b></label>
       <input type="text" class="form-control" id="amount" name="amount" value="{{$amt}}" readonly>
         <input value="{{$transactionid}}" name="pid" id="product_identity" type="hidden">
         <input value="{{$amt}}" readonly name="amt" type="hidden">
     </div>


      <div class="form-check">
        <input class="form-check-input accept" type="checkbox" value="" id="defaultCheck1">
         <label class="form-check-label" for="defaultCheck1">
           यो निर्धारण मैले कार्यालयमा पेश गरेको विवरणको आधारमा भएको ब्यहोरामा म जानकार छु ।
           पछि मेरो  सम्बन्धी विवरण तथा सूचनामा संसोधन हुन गई रकम निर्धारणमा समेत संसोधन हुन गई थप रकम दायित्व सृजना भएमा सो को भुक्तानीको लागि म सहमत छु।
         </label>
       </div>
     </div>
     <div class="panel-footer">
       <button type="submit" class="payment-button" id="payment-button" style="border:none;" data-id = "{{$amt*100}}" >
         <img src="{{ asset('images/khalti2.png') }}" style="width:100px"></button>
     </div>
 </div>

<script>
    var btn = document.getElementById("payment-button");
    btn.onclick = function () {
        $(".accept").val();

        if ($(".accept").is(":checked")) {
            var amount = $(this).attr("data-id");
        } else {
            swal({
                title: "कृपया भुक्तानी सम्बन्धी शर्त स्वीकार गर्नुहोस् !!",
            });
            return false;
        }
    };
</script>
@endsection
