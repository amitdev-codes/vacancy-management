@extends('crudbooster::admin_template')
@section('content')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Check NamastePay verification</div>
            <form role="form" method="get" action="{{route('verify_payment_namastepay')}}">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label for="productid">Eservice Transaction code(EXT REF ID)</label>
                        <input type="text" class="form-control" id="transactionId" name="transactionId" value="{{ $pid}}" >
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
                                <td>{{$data['transactionId']}}</td>
                            </tr>
                            <tr>
                                <td>Total Paid Amount(Rs.)<br></td>
                                <td>NPR:{{$data['transferValue']}}</td>
                            </tr>
                            <tr>
                                <td>Message<br></td>
                                <td>{{$data['transactionStatus']}}</td>
                            </tr>
                            <tr>
                                <td>Paid Date<br></td>
                                <td>{{$data['transferDate']}}</td>
                            </tr>
                            <tr>
                                <td>NamastePay Status<br></td>
                                    <td>{{$data['status']}}</td>
                            </tr>
                            <tr>
                                <td>Transaction Date<br></td>
                                <td>{{$data['transferDate']}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection