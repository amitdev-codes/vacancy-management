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
                <div class="form-group row" >
                    <div class="col-md-2">
                      <label for="token_no" class="col-sm-12 col-form-label">Token No.</label>
                      <input name="token_no" type="text" class="form-control" placeholder="token_no " value="{{Request::input('token_no')}}">
                    </div>
       
                    <div class="col-md-2">
                       <label for="applicant_id" class="col-sm-12 col-form-label">Applicant Id </label>
                       <input name="applicant_id" type="text" class="form-control" placeholder="applicant_id" value="{{Request::input('applicant_id')}}">
                    </div>
       
                    <div class="col-md-2">
                       <label for="mobile" class="col-sm-12 col-form-label">Mobile</label>
                       <input name="mobile" type="text" class="form-control" placeholder="mobile" value="{{Request::input('mobile')}}">
                    </div>
       
       
       
                    <div class="col-md-4">
                       <label for="inputEmail3" class="col-sm-12 col-form-label">Designation</label>
                       <select class="form-control select2" name="designation"  style="width: 100%;">
                        <option selected disabled style="font-weight:bold;">Select Designation </option>
                        @foreach(Session::get('designation') as $y)
                        <option class="form-control nepali_td" {{ app('request')->input('designation') == $y->code ? 'selected' : '' }} value="{{ $y->code }}">{{ $y->name_en }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-info btn-sm btn-search" style="margin-top:24px;"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search</button>
                      </div>

                </div>



                <div class="form-group row" >
                    <div class="col-md-2">
                        <label for="psp" class="col-sm-12 col-form-label">PSP</label>
                        <select class="form-control select2" name="epay"  style="width: 100%;">
                            <option selected disabled style="font-weight:bold;">Select psp </option>
                            @foreach(Session::get('epaysource') as $epay)
                            <option class="form-control nepali_td" {{ app('request')->input('epay') == $epay->counter_id ? 'selected' : '' }} value="{{ $epay->counter_id }}">{{ $epay->name_en }}</option>
                            @endforeach
                         </select>
                     </div>
       
                     <div class="col-md-2">
                        <label for="status" class="col-sm-12 col-form-label">Payment Status</label>
                        <select class="form-control select2" name="status"  style="width: 100%;">
                                <option selected disabled style="font-weight:bold;" class="nepali_td">Select Status </option>
                                <option value="0" class="nepali_td">PSP Failed </option>
                                <option value="1" class="nepali_td">PSP PAID</option>
                                <option value="2" class="nepali_td">PSP VERIFIED</option>
                                <option value="3" class="nepali_td">PAYMENT SUCCESS</option>
                         </select>
                     </div>
       
                    <div class="col-md-2">
                       <label for="inputEmail3" class="col-sm-12 col-form-label">Email</label>
                       <input name="email" type="text" class="form-control" placeholder="email" value="{{Request::input('email')}}">
                    </div>
       
       
                    <div class="col-md-2">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Payment Date From</label>
                        <input name="from_date_bs" type="text" id="from_date_bs" class="form-control"  placeholder="Select Nepali Date" value="{{Request::input('from_date_bs')}}">
                     </div>

                     <input name="from_date_ad" type="hidden" id="from_date_ad" name="from_date_ad" class="form-control" placeholder="Select  Date" value="{{Request::input('from_date_ad')}}">

                     <div class="col-md-2">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Payment Date To</label>
                        <input name="to_date_bs" id="to_date_bs" type="text" class="form-control" placeholder="Select Nepali Date" value="{{Request::input('to_date_bs')}}">
                     </div>

                     <input name="to_date_ad" type="hidden" id="to_date_ad" name="to_date_ad" class="form-control" placeholder="Select  Date" value="{{Request::input('to_date_ad')}}">

                    <div class="col-md-1 pl-0 pr-0">
                      <a href="{{url('/app/web_payment_log')}}" type="reset" class="btn btn-warning btn-sm btn-search" style="margin-top: 20px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{asset("js/jquery-1.9.1.min.js")}}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
    $('#from_date_bs').nepaliDatePicker({
        ndpEnglishInput: 'from_date_ad'
    });

    $('#to_date_bs').nepaliDatePicker({
        ndpEnglishInput: 'to_date_ad'
    });
});
</script>


