@extends('crudbooster::admin_template')
@section('content')
<style>
  .swal2-title {
    font-family: kalimati; src: url('/fonts/kalimati.ttf');
    font-size: 12px;
  
  }
  .sweet-alert p,h2{
  font-size: 1.6rem !important;
  font-family: kalimati;
}
  </style>
<div class="panel panel-success nepali_td">
  <div class="panel-heading">
    <h3 class="panel-title">Applicant Details</h3>
  </div>
  <!-- form start -->
  <form role="form" action="{{$merchant['URL']}}" target="_blank" method="POST">
    {!! csrf_field() !!}
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
          <label for="email"><b>Total Amount:(paisa)</b></label>
          <input type="text" class="form-control" id="amount" value="{{$merchant['TXNAMT']}}" readonly>
        </div>
  
      <input value="{{$merchant['MERCHANTID']}}" id="MERCHANTID" name="MERCHANTID" type="hidden" readonly>
      <input value="{{$merchant['APPID']}}" id="APPID" name="APPID" type="hidden" readonly>
      <input value="{{$merchant['APPNAME']}}" id="APPNAME" name="APPNAME" type="hidden" readonly>
      <input value="{{$merchant['TXNID']}}" id="TXNID" name="TXNID" type="hidden" readonly>
      <input value="{{$merchant['TXNDATE']}}" id="TXNDATE" name="TXNDATE" type="hidden" readonly>
      <input value="{{$merchant['TXNCRNCY']}}" id="TXNCRNCY" name="TXNCRNCY" type="hidden" readonly>
      <input value="{{$merchant['TXNAMT']}}" id="TXNAMT" name="TXNAMT" type="hidden" readonly>
      <input value="{{$merchant['REFERENCEID']}}" id="REFERENCEID" name="REFERENCEID" type="hidden" readonly>
      <input value="{{$merchant['REMARKS']}}" id="REMARKS" name="REMARKS" type="hidden" readonly>
      <input value="{{$merchant['PARTICULARS']}}" id="PARTICULARS" name="PARTICULARS" type="hidden" readonly>
      <input value="{{$merchant['TOKEN']}}" id="TOKEN" name="TOKEN" type="hidden" readonly>
      <input type="hidden" name="su" value="{{route('ipsConnectSuccess')}}" />
      <input type="hidden" name="fu" value="{{route('ipsConnectFailure')}}" />

      <div class="form-check">
        <input class="form-check-input accept" type="checkbox" value="" id="defaultCheck1">
         <label class="form-check-label" for="defaultCheck1">
           यो निर्धारण मैले {{Session::get('client_name')}} कार्यालयमा पेश गरेको विवरणको आधारमा
           भएको ब्यहोरामा म जानकार छु । पछि मेरो  विवरण तथा सूचनामा संसोधन हुन गई थप रकम निर्धारण हुन गएमा सो को
           भुक्तानीको लागि म सहमत छु ।
         </label>
        </div>

    </div>
    <!-- /.box-body -->
    <div class="panel-footer">
      <button type="submit" class="submitbutton" onclick="return checkbox();" style='border: none;  padding: 0px;'>
        <img src="{{ asset('images/ipsconnect.png') }}" style="width:100px"></a></button>
    </div>
  </form>
</div>

<script type="text/javascript">
function checkbox()
{
  $('.accept').val();
  if($('.accept').is(":checked")){
    return true;
  }else{
    swal({ 
      title:"कृपया भुक्तानी सम्बन्धी शर्त स्वीकार गर्नुहोस् !!"
     });
     return false;
  }
}
</script>

@endsection