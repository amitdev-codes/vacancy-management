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
              <th></th>
              <th>Full Name</th>
              <th>Ad No</th>
              <th>photo</th>
              <th>Designation</th>
              <th>Token Number</th>
              <th>Exam Roll No</th>
              <th>Action</th>
             </tr>
        </thead>
        <tbody>
          @foreach($result as $row)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$row->full_name}}</td>
              <td>{{$row->ad_no}}</td>
              {{-- <td>{{CRUDBooster::mainpath().'/'.$row->photo}}</td> --}}

              <td><img src="{{ url($row->photo) }}" height="40px;" width="40px;"></td>
              <td>{{$row->designation}}</td>
              <td>{{$row->token_number}}</td>
              <td>{{$row->exam_roll_no}}</td>
              <td>
                <!-- To make sure we have read access, wee need to validate the privilege -->
                @if(CRUDBooster::isUpdate() && $button_edit)
                <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("edit/$row->id")}}'>Edit</a>
                @endif
                
                @if(CRUDBooster::isDelete() && $button_edit)
                <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("delete/$row->id")}}'>Delete</a>
                @endif
              </td>
             </tr>
          @endforeach
        </tbody>
      </table>
    </form>
      {{-- <p>{!! urldecode(str_replace("/?","?",$result->appends(Request::all())->render())) !!}</p> --}}
      <div class="col-md-8">{!! urldecode(str_replace("/?","?",$result->appends(Request::all())->render())) !!}</div>
    </div>
</div>

<!-- ADD A PAGINATION -->

@endsection