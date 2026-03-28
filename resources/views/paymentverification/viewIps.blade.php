@extends('crudbooster::admin_template')
@section('content')
<div class="col-md-12">
 <div class="panel panel-primary">
     <div class="panel-heading">Check Ips verification</div>
     <form role="form" method="get" action="{{route('verify_payment_ips')}}">
        @csrf
         <div class="panel-body">
            <div class="form-group">
                <label for="productid">Reference Id</label>
                <input type="text" class="form-control" id="productid" name="productid" value="{{ $pid}}" >
              </div>
   
              <div class="form-group">
               <label for="amount">Paid Amount(पैसामा )</label>
               <input type="text" class="form-control" id="amount" name="amount"value="{{ $amount}}">
             </div>
         </div>
         <div class="panel-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
     </form>
 </div>
</div>

@if($results)
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">Verification Response</div>
        <form role="form">
            <div class="panel-body">
                <table class="table table-bordered table-striped table-responsive">
                    <tbody>
                        <tr>
                            <td>Applicant  Id&nbsp;<br></td>
                            <td>{{$results['remarks']}}</td>
                        </tr>
                        
                        <tr>
                            <td>Reference Id&nbsp;<br></td>
                            <td>{{$results['referenceId']}}</td>
                        </tr>
                        <tr>
                            <td>Merchant Id<br></td>
                            <td>{{$results['merchantId']}}</td>
                        </tr>
                        <tr>
                            <td>APP Id<br></td>
                            <td>{{$results['appId']}}</td>
                        </tr>
                        <tr>
                            <td>Transaction Id<br></td>
                            <td>{{$results['txnId']}}</td>
                        </tr>
                        <tr>
                            <td>Total Paid Amount(Rs.)<br></td>
                            <td>NPR:{{$results['txnAmt']}}</td>
                        </tr>
                        <tr>
                            <td>Code<br></td>
                            <td>{{$results['code']}}</td>
                        </tr>
                        <tr>
                            <td>Message<br></td>
                            <td>{{$results['statusDesc']}}</td>
                        </tr>
                        <tr>
                            <td>Paid Date<br></td>
                            <td>{{$results['txnDate']}}</td>
                        </tr>
                        <tr>
                            <td>IPS Unique Code<br></td>
                            <td>{{$results['refId']}}</td>
                        </tr>
                        <tr>
                            <td>IPS Status<br></td>
                            <td>{{$results['status']}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </form>
    </div>
   </div>
@endif
@endsection