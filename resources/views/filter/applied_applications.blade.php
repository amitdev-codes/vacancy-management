<div class="box">
  <div class="box box-default collapsed box-solid">
    <div class="box-header with-border ">
      <h3 class="box-title">Search</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
      <form class="form-horizontal">
        <div class="form-group row">

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">OpeningType</label>
            <select class="form-control select2" name="opening_type" style="width: 100%;">
              <option selected disabled style="font-weight:bold;">Select OpeningType</option>
              @foreach(Session::get('opening_type') as $ot)
              <option class="form-control nepali_td"
                {{ app('request')->input('opening_type') == $ot->id ? 'selected' : '' }} value="{{ $ot->id }}">
                {{ $ot->ad_title_en }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Full Name</label>
            <input name="fullname" type="text" class="form-control" placeholder="Name"
              value="{{Request::input('fullname')}}">
          </div>

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Mobile</label>
            <input name="mobile" type="text" class="form-control" placeholder="mobile"
              value="{{Request::input('mobile')}}">
          </div>

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Email</label>
            <input name="email" type="text" class="form-control" placeholder="email"
              value="{{Request::input('email')}}">
          </div>

          <div class="col-md-2">
            <label for="taxpayer" class="col-sm-12 col-form-label">Token No.</label>
            <input name="token_no" type="text" class="form-control" placeholder="token_no "
              value="{{Request::input('token_no')}}">
          </div>

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Applicant Id </label>
            <input name="applicant_id" type="text" class="form-control" placeholder="applicantId"
              value="{{Request::input('applicant_id')}}">
          </div>
        </div>

        <div class="form-group row">

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">PrivilegeGroup</label>
            <select class="form-control select2" name="privilege_group" style="width: 100%;">
              <option selected disabled style="font-weight:bold;">Select privilegeGroup</option>
              @foreach(Session::get('privilege_group') as $pg)
              <option class="form-control nepali_td"
                {{ app('request')->input('privilege_group') == $pg->code ? 'selected' : '' }} value="{{ $pg->code }}">
                {{ $pg->name_en }}</option>
              @endforeach
            </select>
          </div>


          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Designation</label>
            <select class="form-control select2" name="designation" style="width: 100%;">
              <option selected disabled style="font-weight:bold;">Select Designation</option>
              @foreach(Session::get('designation') as $y)
              <option class="form-control nepali_td"
                {{ app('request')->input('designation') == $y->code ? 'selected' : '' }} value="{{ $y->code }}">
                {{ $y->name_en }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">PaymentStatus</label>
            <select class="form-control select2" name="paymentstatus" style="width: 100%;">
              <option selected disabled style="font-weight:bold;">Select Status</option>
              <option {{ app('request')->input('paymentstatus') == 1 ? 'selected' : '' }} value="1" class="nepali_td">
                Paid </option>
              <option {{ app('request')->input('paymentstatus') == 2 ? 'selected' : '' }} value="2" class="nepali_td">
                Not Paid</option>
            </select>
          </div>

          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Status</label>
            <select class="form-control select2" name="status" style="width: 100%;">
              <option selected disabled style="font-weight:bold;">Select Applied Status</option>
              <option {{ app('request')->input('status') == 1 ? 'selected' : '' }} value="1" class="nepali_td">Rejected
              </option>
              <option {{ app('request')->input('status') == 2 ? 'selected' : '' }} value="2" class="nepali_td">Cancelled
              </option>
              <option {{ app('request')->input('status') == 3 ? 'selected' : '' }} value="3" class="nepali_td">Applied
              </option>
            </select>
          </div>



          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Applied Date From</label>
            <input name="from_date_ad" type="date" id="from_date_ad" class="form-control" placeholder="Select  Date"
              value="{{Request::input('from_date_bs')}}">
          </div>


          <div class="col-md-2">
            <label for="inputEmail3" class="col-sm-12 col-form-label">Applied Date To</label>
            <input name="to_date_ad" id="to_date_ad" type="date" class="form-control" placeholder="Select  Date"
              value="{{Request::input('to_date_bs')}}">
          </div>





        </div>
        <div class="form-group row">
          <div class="col-md-1">
            <button type="submit" class="btn btn-info btn-sm btn-search" style="margin-top:24px;margin-left:-5px;"><i
                class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search</button>
          </div>
          <div class="col-md-1 pl-0 pr-0">
            <a href="{{url('/app/vacancy_applicants')}}" type="reset" class="btn btn-warning btn-sm btn-search"
              style="margin-top: 20px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>