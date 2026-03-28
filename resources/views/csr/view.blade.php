<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->


<div class="alert alert-primary" role="alert">
<h2>Total CSR Collection: Rs.
@foreach($total as $t)
{{$t->total_collection}}
@endforeach</h2>
</div>


<table class='table table-striped table-bordered table-responsive'>
  <thead>
      <tr>
        <th>#</th>
        <th>Token No.</th>
        <th>Applicant</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Designation</th>
        <th>Amount</th>
        <th>Receipt No.</th>
       </tr>
  </thead>
  <tbody>
@foreach($result as $row)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$row->token_number}}</td>
        <td>{{$row->fname}} {{$row->mname}} {{$row->lname}}</td>
        <td>{{$row->mobile_no}}</td>
        <td>{{$row->email}}</td>
        <td>{{$row->designation}}</td>
        <td>{{$row->total_amount}}</td>
        <td>{{$row->paid_receipt_no}}</td>
      </tr>
@endforeach

  </tbody>
</table>

@endsection
