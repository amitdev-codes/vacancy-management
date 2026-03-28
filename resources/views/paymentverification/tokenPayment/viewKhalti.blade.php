@extends('crudbooster::admin_template')
@section('content')
<div class="col-md-12">
 <div class="panel panel-primary">
     <div class="panel-heading">Check khalti verification</div>
     <form role="form" method="post" action="{{route('khalti_token_verification')}}">
        @csrf
         <div class="panel-body">
            <div class="form-group">
                <label for="productid">PSP REFERENCE TOKEN</label>
                <input type="text" class="form-control" id="productid" name="productid" value="{{ $pid}}" >
              </div>

         </div>
         <div class="panel-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
     </form>
 </div>
</div>

@if($data)
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">Verification Response</div>
        <form role="form">
            <div class="panel-body">
                <table class="table table-bordered table-striped table-responsive">
                    <tbody>
                        <tr>
                            <td>Transaction Id&nbsp;<br></td>
                            <td>{{$data['transaction_idx']}}</td>
                        </tr>
                        <tr>
                            <td>Total Paid Amount(Rs.)<br></td>
                            <td>NPR:{{$data['total_amount']/100}}</td>
                        </tr>
                        <tr>
                            <td>Mobile<br></td>
                            <td>{{$data['user']['mobile']}}</td>
                        </tr>
                        <tr>
                            <td>Paid Date<br></td>
                            <td>{{$data['created_on']}}</td>
                        </tr>
                        <tr>
                            <td>Name<br></td>
                                <td>{{$data['user']['name']}}</td>
                        </tr>
                        <tr>
                            <td>Transaction state<br></td>
                            <td>{{$data['status']}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
   </div>
@endif
@endsection