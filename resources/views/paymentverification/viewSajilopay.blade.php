@extends('crudbooster::admin_template')
@section('content')
    <div class="col-md-12">
        @if (\Session::has('info'))
            @include('message.info')
        @endif
        <div class="panel panel-primary">
            <div class="panel-heading">Check Sajilopay verification</div>
            <form role="form" method="get" action="{{ route('verify_payment_sajilopay') }}">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label for="productid">Product Id</label>
                        <input type="text" class="form-control" id="productid" name="productid"
                            value="{{ $pid }}">
                    </div>

                    <div class="form-group">
                        <label for="amount">Paid Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount"value="{{ $amount }}">
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    @if ($data)
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Verification Response</div>
                <form role="form">
                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive">
                            <tbody>
                                <tr>
                                    <td>Product Id(Reference code)&nbsp;<br></td>
                                    <td>{{ $data['process_id'] }}</td>
                                </tr>
                                <tr>
                                    <td>Product Name<br></td>
                                    <td>{{ $data['title'] }}</td>
                                </tr>
                                <tr>
                                    <td>Total Paid Amount(Rs.)<br></td>
                                    <td>NPR:{{ $data['amount'] }}</td>
                                </tr>
                                <tr>
                                    <td>Transaction ID<br></td>
                                    <td>{{ $data['transaction_id'] }}</td>
                                </tr>
                                <tr>
                                    <td>Paid Date<br></td>
                                    <td>{{ $data['date'] }}</td>
                                </tr>

                                <tr>
                                    <td>Sajilopay Status<br></td>
                                    <td>{{ $data['status'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
