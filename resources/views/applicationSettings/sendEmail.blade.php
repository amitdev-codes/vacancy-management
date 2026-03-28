@extends('crudbooster::admin_template')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @include('filter.customapplicants')
    <div class="panel panel-success">
        <div class="panel-header">

        </div>
        <div class="panel-body">
            <div class="box-body table-responsive no-padding">
                <form id='form-table' action="{{ route('sendEmail') }}" method="get">
                    <table id='table_dashboard' class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr class="active">
                            <th style="width:auto">{{ cbLang('no') }}</th>
                            <th><input type='checkbox' id='checkall'/></th>
                            <th style="width:auto"><a href="#">Full Name</a></th>
                            <th style="width:auto"><a href="#">Applicant Id</a></th>
                            <th style="width:auto"><a href="#">Token Number</a></th>
                            <th style="width:auto"><a href="#">Mobile</a></th>
                            <th style="width:auto"><a href="#">Email</a></th>
                            <th style="width:auto"><a href="#">Designation </a></th>
                            <th style="width:auto"><a href="#">Vacancy Post</a></th>
                            <th style="width:auto"><a href="#">Gender</a></th>
                        </tr>
                        </thead>
                        <tbody>
                      @if(!empty($data))
                        @foreach($data as $row)
                            <tr>
                                <td>{{($data->currentPage()-1) * $data->perPage() + $loop->iteration}}</td>
                                <td>
                                    <input type="checkbox" class="checkbox" name="checkbox[]" value="{{$row->email}}">
                                    <input type="hidden" class="mobilecheckbox" name="mobileCheckbox[]" value="{{$row->mobile}}">
                                </td>
                                <td>{{$row->applicant_name_en}}</td>
                                <td>{{$row->ap_id}}</td>
                                <td>{{$row->token_number}}</td>
                                <td>{{$row->mobile}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->designation_name}}</td>
                                <td>{{$row->ad_no}}</td>
                                <td>{{$row->genderName}}</td>
                            </tr>
                        @endforeach
                      @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th style="width:auto">-</th>
                            <th>-</th>
                            <th style="width:auto">Full Name</th>
                            <th style="width:auto">Applicant Id</th>
                            <th style="width:auto">Token Number</th>
                            <th style="width:auto">Mobile</th>
                            <th style="width:auto">Email</th>
                            <th style="width:auto">Designation </th>
                            <th style="width:auto">Vacancy Post</th>
                            <th style="width:auto">Gender</th>
                        </tr>
                        </tfoot>
                    </table>
                    @if(!empty($data)){{ $data->links() }}@endif
                    <div class="form-group row">
                        <div class="form-group col-sm-12">
                            <label for="email"><b>Message:</b></label>
                            <textarea  style="width:100%;border-radius: 10px;border-color: powderblue" class="form-control message" id="message" name="message"></textarea>
                        </div>
                    </div>
{{--                    <button type="submit" class="btn btn-info btn-sm btn-search" style="width:20%;border-radius: 10px;border-color: powderblue;">Send Email</button>---}}
                    <button type="submit" class="btn btn-info btn-sm btn-search" style="width:20%;border-radius: 10px;border-color: powderblue;" name="action" value="sendEmail">Send Email</button>
                    <button type="submit" class="btn btn-success btn-sm btn-search"  style="width:20%;border-radius: 10px;border-color: powderblue;" name="action" value="sendSms">Send Sms</button>
                </form>
            </div>
        </div>
        <div class="panel-footer">
        </div>
    </div>
    @push('bottom')
        <script>
            $(function () {
                $("#table_dashboard .checkbox").click(function () {
                    const is_any_checked = $("#table_dashboard .checkbox:checked").length;
                    if (is_any_checked) {
                        $(".btn-delete-selected").removeClass("disabled");
                    } else {
                        $(".btn-delete-selected").addClass("disabled");
                    }
                })
                $("#table_dashboard #checkall").click(function () {
                    const is_checked = $(this).is(":checked");
                    $("#table_dashboard .checkbox").prop("checked", !is_checked).trigger("click");
                    $("#table_dashboard .mobilecheckbox").prop("checked", !is_checked).trigger("click");
                })
                // $("#sendAll").click(function () {
                //     $('input:checkbox').prop('checked', true);
                // })
            });
        </script>
    @endpush
@endsection