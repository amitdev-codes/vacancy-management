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
            <form class="form-horizontal" method="get">
                @csrf
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="openingType" class="col-sm-12 col-form-label">OpeningType</label>
                        <select class="form-control select2" name="opening_type" style="width:100%;border-radius: 10px;border-color: powderblue">
                            <option selected disabled style="font-weight:bold;">Select OpeningType</option>
                            @foreach(\App\Models\MstJobOpeningType::all() as $ot)
                                <option class="form-control nepali_td"
                                        {{ app('request')->input('opening_type') == $ot->id ? 'selected' : '' }} value="{{ $ot->id }}">
                                    {{ $ot->name_en }}-{{$ot->name_np}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Designation</label>
                        <select class="form-control select2" name="designation" style="width:100%;border-radius: 10px;border-color: powderblue">
                            <option selected disabled style="font-weight:bold;">Select Designation</option>
                            @foreach(\App\Models\MstDesignation::all() as $y)
                                <option class="form-control nepali_td"
                                        {{ app('request')->input('designation') == $y->code ? 'selected' : '' }} value="{{ $y->code }}">
                                    {{ $y->name_en }}-{{$y->name_np}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">PrivilegeGroup</label>
                        <select class="form-control select2" name="privilege_group" style="width:100%;border-radius: 10px;border-color: powderblue">
                            <option selected disabled style="font-weight:bold;">Select privilege</option>
                            @foreach(\App\Models\MstPrivilegeGroup::all() as $pg)
                                <option class="form-control nepali_td"
                                        {{ app('request')->input('privilege_group') == $pg->id ? 'selected' : '' }} value="{{ $pg->id }}">
                                    {{ $pg->name_en }}-{{$pg->name_np}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Mobile</label>
                        <input name="mobile" type="text" class="form-control" style="width:100%;border-radius: 10px;border-color: powderblue" placeholder="mobile" value="{{Request::input('mobile')}}">
                    </div>
                    <div class="col-md-2">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Email</label>
                        <input name="email" type="text" class="form-control" style="width:100%;border-radius: 10px;border-color: powderblue" placeholder="email"
                               value="{{Request::input('email')}}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="fullname" class="col-sm-12 col-form-label">Full Name</label>
                        <input name="fullname" type="text" style="width:100%;border-radius: 10px;border-color: powderblue" class="form-control" placeholder="Name" value="{{Request::input('fullname')}}">
                    </div>

                    <div class="col-md-3">
                        <label for="taxpayer" class="col-sm-12 col-form-label">Token No.</label>
                        <input name="token_no" type="text" class="form-control" style="width:100%;border-radius: 10px;border-color: powderblue" placeholder="token_no "
                               value="{{Request::input('token_no')}}">
                    </div>

                    <div class="col-md-2">
                        <label for="inputEmail3" class="col-sm-12 col-form-label">Applicant Id </label>
                        <input name="applicant_id" type="text" class="form-control" style="width:100%;border-radius: 10px;border-color: powderblue" placeholder="applicantId"
                               value="{{Request::input('applicant_id')}}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-sm btn-search" style="width:100%;border-radius: 10px;border-color: powderblue;margin-top:24px;margin-left:-5px;"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search</button>
                    </div>
                    <div class="col-md-2">
                        <button type="reset" class="btn btn-warning btn-sm btn-search" style="width:100%;border-radius: 10px;border-color: powderblue;margin-top:24px;margin-left:-5px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>