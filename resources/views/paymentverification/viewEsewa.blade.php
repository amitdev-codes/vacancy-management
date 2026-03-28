@extends('crudbooster::admin_template')
@section('content')
<div class="col-md-12">
    @if (\Session::has('info'))
    @include('message.info')
    @endif
 <div class="panel panel-primary">
     <div class="panel-heading">Check Esewa verification</div>
     <form role="form" method="get" action="{{route('verify_payment_esewa')}}">
        @csrf
         <div class="panel-body">
            <div class="form-group">
                <label for="productid">Product Id</label>
                <input type="text" class="form-control" id="productid" name="productid" value="{{ $pid}}" >
              </div>
   
              <div class="form-group">
               <label for="amount">Paid Amount</label>
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
                            <td>Product Id(Reference code)&nbsp;<br></td>
                            <td>{{$results[0]['productId']}}</td>
                        </tr>
                        <tr>
                            <td>Product Name<br></td>
                            <td>{{$results[0]['productName']}}</td>
                        </tr>
                        <tr>
                            <td>Total Paid Amount(Rs.)<br></td>
                            <td>NPR:{{$results[0]['totalAmount']}}</td>
                        </tr>
                        <tr>
                            <td>Code<br></td>
                            <td>{{$results[0]['code']}}</td>
                        </tr>
                        <tr>
                            <td>Message<br></td>
                            <td>{{$results[0]['message']['technicalSuccessMessage']}}</td>
                        </tr>
                        <tr>
                            <td>Paid Date<br></td>
                            <td>{{$results[0]['transactionDetails']['date']}}</td>
                        </tr>
                        <tr>
                            <td>Esewa Unique Code<br></td>
                            <td>{{$results[0]['transactionDetails']['referenceId']}}</td>
                        </tr>
                        <tr>
                            <td>Esewa Status<br></td>
                            <td>{{$results[0]['transactionDetails']['status']}}</td>
                        </tr>
                        <tr>
                            <td>Merchant Name<br></td>
                            <td>{{$results[0]['transactionDetails']['status']}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
   </div>
@endif
@endsection