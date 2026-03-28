@extends('crudbooster::admin_template')
@section('content')
<div class="box">
    <div class="box-header">
        @if($button_bulk_action && ( ($button_delete && CRUDBooster::isDelete()) || $button_selected) )
            <div class="pull-{{ cbLang('left') }}">
                <div class="selected-action" style="display:inline-block;position:relative;">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                                class='fa fa-check-square-o'></i> {{cbLang("button_selected_action")}}
                        <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu">
                        @if($button_delete && CRUDBooster::isDelete())
                            <li><a href="javascript:void(0)" data-name='delete' title='{{cbLang('action_delete_selected')}}'><i
                                            class="fa fa-trash"></i> {{cbLang('action_delete_selected')}}</a></li>
                        @endif

                        @if($button_selected)
                            @foreach($button_selected as $button)
                                <li><a href="javascript:void(0)" data-name='{{$button["name"]}}' title='{{$button["label"]}}'><i
                                                class="fa fa-{{$button['icon']}}"></i> {{$button['label']}}</a></li>
                            @endforeach
                        @endif

                    </ul><!--end-dropdown-menu-->
                </div><!--end-selected-action-->
            </div><!--end-pull-left-->
        @endif
        <div class="box-tools pull-{{ cbLang('right') }}" style="position: relative;margin-top: -5px;margin-right: -10px">

            @if($button_filter)
                <a style="margin-top:-23px" href="javascript:void(0)" id='btn_advanced_filter' data-url-parameter='{{$build_query}}'
                   title='{{cbLang('filter_dialog_title')}}' class="btn btn-sm btn-default {{(Request::get('filter_column'))?'active':''}}">
                    <i class="fa fa-filter"></i> {{cbLang("button_filter")}}
                </a>
            @endif

            <form method='get' style="display:inline-block;width: 260px;" action='{{Request::url()}}'>
                <div class="input-group">
                    <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control input-sm pull-{{ cbLang('right') }}"
                           placeholder="{{cbLang('filter_search')}}"/>
                    {!! CRUDBooster::getUrlParameters(['q']) !!}
                    <div class="input-group-btn">
                        @if(Request::get('q'))
                            <?php
                            $parameters = Request::all();
                            unset($parameters['q']);
                            $build_query = urldecode(http_build_query($parameters));
                            $build_query = ($build_query) ? "?".$build_query : "";
                            $build_query = (Request::all()) ? $build_query : "";
                            ?>
                            <button type='button' onclick='location.href="{{ CRUDBooster::mainpath().$build_query}}"'
                                    title="{{cbLang('button_reset')}}" class='btn btn-sm btn-warning'><i class='fa fa-ban'></i></button>
                        @endif
                        <button type='submit' class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>


            <form method='get' id='form-limit-paging' style="display:inline-block" action='{{Request::url()}}'>
                {!! CRUDBooster::getUrlParameters(['limit']) !!}
                <div class="input-group">
                    <select onchange="$('#form-limit-paging').submit()" name='limit' style="width: 56px;" class='form-control input-sm'>
                        <option {{($limit==5)?'selected':''}} value='5'>5</option>
                        <option {{($limit==10)?'selected':''}} value='10'>10</option>
                        <option {{($limit==20)?'selected':''}} value='20'>20</option>
                        <option {{($limit==25)?'selected':''}} value='25'>25</option>
                        <option {{($limit==50)?'selected':''}} value='50'>50</option>
                        <option {{($limit==100)?'selected':''}} value='100'>100</option>
                        <option {{($limit==200)?'selected':''}} value='200'>200</option>
                    </select>
                </div>
            </form>

        </div>

        <br style="clear:both"/>

    </div>
    <div class="box-body table-responsive no-padding">
    <form id='form-table' method='post' action='{{CRUDBooster::mainpath("action-selected")}}'>
        <input type='hidden' name='button_name' value=''/>
        <input type='hidden' name='_token' value='{{csrf_token()}}'/>
      <table id='table_dashboard' class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
              <th>No.</th>
              <th>Action</th>
              <th>Ad No</th>
              <th>Designation</th>
              <th>Published Date(B.S.)</th>
              <th>Last Date(B.S.)</th>
              <th>Applicant Id</th>
              <th>Photo</th>
              <th>Name</th>
              <th>Mobile</th>
              <th>Applied Date</th>
              <th>Token Number</th>
              <th>Total Amount</th>
              <th>Paid Receipt No</th>
              <th>Is Handicapped</th>
              <th>Is Dalit</th>
              <th>Is Janjati</th>
              <th>Is Madhesi</th>
              <th>Is Remote Village</th>
              <th>Applied Group</th>
              <th>Is Rejected</th>
              <th>Is Cancelled</th>
             </tr>
        </thead>
        <tbody>
          @foreach($result as $row)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>
                <div class="button_action" style="text-align:left">

                <a class="btn btn-xs btn-danger" href="javascript:;" title="" onclick="
                swal({
                title: &quot;Reject&quot;,
                text: &quot;Are you sure you want to reject?&quot;,
                type: &quot;warning&quot;,
                showCancelButton: true,
                confirmButtonColor: &quot;#DD6B55&quot;,
                confirmButtonText: &quot;Yes!&quot;,
                cancelButtonText: &quot;No&quot;,
                closeOnConfirm: true, },
                function(){
                 @php
                 $id=$row->token_number;
                 @endphp
                 location.href = '{{CRUDBooster::mainpath('../vacancy_rejection/edit'.'/'.$id)}}';
                  });" ><i class="fa fa-ban"></i> </a>&nbsp;


                <a class="btn btn-xs btn-warning" href="javascript:;" title="" onclick="
                swal({
                title: &quot;Cancel&quot;,
                text: &quot;Are you sure you want to cancel?&quot;,
                type: &quot;warning&quot;,
                showCancelButton: true,
                confirmButtonColor: &quot;#DD6B55&quot;,
                confirmButtonText: &quot;Yes!&quot;,
                cancelButtonText: &quot;No&quot;,
                closeOnConfirm: true, },
                function(){
                 @php
                 $id=$row->token_number;
                 @endphp
                 location.href = '{{CRUDBooster::mainpath('../vacancy_apply_cancelation/edit'.'/'.$id)}}';
                });" ><i class="fa fa-remove"></i></a>&nbsp;
                
                <a class="btn btn-xs btn-info" href="javascript:;" title="" onclick="
                swal({
                title: &quot;Edit&quot;,
                text: &quot;Are you sure you want to edit record?&quot;,
                type: &quot;warning&quot;,
                showCancelButton: true,
                confirmButtonColor: &quot;#DD6B55&quot;,
                confirmButtonText: &quot;Yes!&quot;,
                cancelButtonText: &quot;No&quot;,
                closeOnConfirm: true, },
                function(){
                @php
                $id=$row->token_number;
                 @endphp
                 location.href = '{{CRUDBooster::mainpath('../vacancy_apply/edit'.'/'.$id)}}';
                });" ><i class="fa fa-pencil"></i></a>&nbsp;
                <a class="btn btn-xs btn-primary" title="" onclick="" href="{{URL::to('/admin/vacancy_applicants/../vacancy_apply/view/'.$row->token_number)}}"><i class="fa fa-eye"></i> </a>&nbsp;
                <a class="btn btn-xs btn-success" title="" onclick="" href="{{URL::to('/admin/vacancy_applicants/../applicant_profile/archive/'.$row->token_number)}}"><i class="fa fa-user"></i> </a>&nbsp;
                </div>
              </td>
              <td>{{$row->ad_no}}</td>
              <td>{{$row->designation_en}}</td>
              <td>{{$row->published_date_bs}}</td>
              <td>{{$row->last_date_bs}}</td>
              <td>{{$row->applicant_id}}</td>
              <td>{{$row->photo}}</td>
              <td>{{$row->name_en}}</td>
              <td>{{$row->mobile_no}}</td>
              <td>{{$row->applied_date_bs}}</td>
              <td>{{$row->token_number}}</td>
              <td>{{$row->total_amount}}</td>
              <td>{{$row->paid_receipt_no}}</td>
              <td>{{$row->is_handicapped}}</td>
              <td>{{$row->is_dalit}}</td>
              <td>{{$row->is_janajati}}</td>
              <td>{{$row->is_madhesi}}</td>
              <td>{{$row->is_remote_village}}</td>
              <td>{{$row->applied_group}}</td>
              <td>{{$row->is_rejected}}</td>
              <td>{{$row->is_cancelled}}</td>
             </tr>
          @endforeach
        </tbody>
      </table>
    </form>
      <div class="col-md-8">{!! urldecode(str_replace("/?","?",$result->appends(Request::all())->render())) !!}</div>
    </div>
</div>
@endsection