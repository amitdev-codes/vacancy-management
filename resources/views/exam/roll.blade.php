<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template') @section('content')

<!-- Your html goes here -->
<div class='panel panel-default'>
  <div class='panel-heading'>Add Form</div>
  <div class='panel-body'>
    <form method='post' action='{{CRUDBooster::mainpath(' add-save ')}}'>
      <div class='form-group'>
        <label>Label 1</label>
        <input type='text' name='label1' required class='form-control' />
      </div>

      <!-- etc .... -->

    </form>
  </div>
  <div class='panel-footer'>
    <input type='submit' class='btn btn-primary' value='Save changes' />
  </div>
</div>
<!-- Your custom  HTML goes here -->
<table class='table table-striped table-bordered'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Price</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($result as $row)
    <tr>
      <td>{{$row->designation_id}}</td>
      <td>{{$row->applicant_id}}</td>
      <td>{{$row->exam_roll_no}}</td>
      <td>
        <!-- To make sure we have read access, wee need to validate the privilege -->
        @if(CRUDBooster::isUpdate() && $button_edit)
        <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("edit/$row->id")}}'>Edit</a>
        @endif @if(CRUDBooster::isDelete() && $button_edit)
        <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("delete/$row->id")}}'>Delete</a>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<!-- ADD A PAGINATION -->
<p>{!! urldecode(str_replace("/?","?",$result->appends(Request::all())->render())) !!}</p>
@endsection