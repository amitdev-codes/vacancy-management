@extends('layouts.applicant_admin_template')
@section('content')
<div>

    <div class="panel panel-default">
     <x-applicant :component_name="$page_title" :checkNtStaff="$isNtStaff" :applicantID="$applicant_id"></x-applicant>

    <div class="panel-body" style="padding:20px 0px 0px 0px">
      @if($index_statistic)
      <div id='box-statistic' class='row'>
      @foreach($index_statistic as $stat)
          <div  class="{{ ($stat['width'])?:'col-sm-3' }}">
              <div class="small-box bg-{{ $stat['color']?:'red' }}">
                <div class="inner">
                  <h3>{{ $stat['count'] }}</h3>
                  <p>{{ $stat['label'] }}</p>
                </div>
                <div class="icon">
                  <i class="{{ $stat['icon'] }}"></i>
                </div>
              </div>
          </div>
      @endforeach
      </div>
    @endif

   @if(!is_null($pre_index_html) && !empty($pre_index_html))
       {!! $pre_index_html !!}
   @endif

    @if($parent_table)
    <div class="box box-default">
      <div class="box-body table-responsive no-padding">
        <table class='table table-bordered'>
          <tbody>
            <tr class='active'>
              <td colspan="2"><strong><i class='fa fa-bars'></i> {{ ucwords(urldecode(g('label'))) }}</strong></td>
            </tr>
            @foreach(explode(',',urldecode(g('parent_columns'))) as $c)
            <tr>
              <td width="25%"><strong>
               @if(urldecode(g('parent_columns_alias')))
              {{explode(',',urldecode(g('parent_columns_alias')))[$loop->index]}}
              @else
              {{  ucwords(str_replace('_',' ',$c)) }}
               @endif
              </strong></td><td> {{ $parent_table->$c }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    <div class="box">
        <div class="box-header">
            @if($isApplicant===true)
                @if($table!="applicant_training_info")
                    <a href="{{CRUDBooster::adminPath()}}/{{$table}}/add" id="btn_add_new_data" class="btn btn-sm btn-success col-sm-1" title="Add Data" style="margin-left: 2px;margin-right:5px;">
                        <i class="fa fa-plus-circle"></i> Add Data
                    </a>
                @else
                    <a href="{{CRUDBooster::adminPath()}}/user_training_info/add" id="btn_add_new_data" class="btn btn-sm btn-success" title="Add Data">
                        <i class="fa fa-plus-circle"></i> Add Data
                    </a>
                @endif
                 <h5 class="nepali_td"><strong>नोट:एक भन्दा बढी कार्यालयको अनुभव भएमा Add Data गर्दै प्रतेक कार्यालयको विवरण भर्नु पर्ने छ!</strong></h5>
            @endif

            <br style="clear:both"/>
        </div>
        <div class="box-body table-responsive no-padding">
            <form id='form-table' method='post' action='{{CRUDBooster::mainpath("action-selected")}}'>
                <table id='table_dashboard' class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr class="active">
                        <th style="width:auto">{{ cbLang('no') }}</th>
                        <th style="width:auto"><a href="#">Working Office</a></th>
                        <th style="width:auto"><a href="#">Designation</a></th>
                        <th style="width:auto"><a href="#">Date From(B.S.)</a></th>
                        <th style="width:auto"><a href="#">Date To(B.S.)</a></th>
                        <th style="width:auto"><a href="#">Job Category</a></th>
                        <th style="width:auto"><a href="#">Appointment </a></th>
                        <th style="width:auto"><a href="#">Termination</a></th>
                        <th style="width:auto"><a href="#">Duration(days)</a></th>
                        <th style="width:100px"><a href="#">Action</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($applicant_exp_info))
                        <tr class='warning'>
                             @if($button_bulk_action && $show_numbering):
                            <td colspan='{{count($columns)+3}}' align="center">
                             @elseif( ($button_bulk_action && ! $show_numbering) || (! $button_bulk_action && $show_numbering) ):
                            <td colspan='{{count($columns)+2}}' align="center">
                            @else:
                            <td colspan='{{count($columns)+1}}' align="center">
                            @endif;
                                <i class='fa fa-search'></i> {{cbLang("table_data_not_found")}}
                            </td>
                        </tr>
                    @endif
                    @foreach($applicant_exp_info as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->working_office}}</td>
                            <td>{{$row->designation}}</td>
                            <td>{{$row->date_from_bs}}</td>
                            <td>{{$row->date_to_bs}}</td>
                            <td>{{$row->job_category}}</td>
                            <td>
                                <a data-lightbox="roadtrip" rel="group_{applicant_exp_info}" title="Appointment: 10672" href="{{asset($row->appointment_doc)}}"><img width="40px" height="40px" src="{{asset($row->appointment_doc)}}"></a>
                            </td>
                            <td>
                                <a data-lightbox="roadtrip" rel="group_{applicant_exp_info}" title="Appointment: 10672" href="{{asset($row->termination_doc)}}"><img width="40px" height="40px" src="{{asset($row->termination_doc)}}"></a>
                            </td>
                            <td>{{Helper::diff_in_days($row->date_from_ad,$row->date_to_ad)}}</td>
                            <td>
                                <div class="button_action" style="text-align:right">
                                    <a class="btn btn-xs btn-primary btn-detail" title="Detail Data" href="{{CRUDBooster::mainpath("detail/$row->id")}}"><i class="fa fa-eye"></i></a>
                                    @if(CRUDBooster::isUpdate() && $button_edit)
                                        <a class="btn btn-xs btn-success btn-edit" title="Edit Data" href="{{CRUDBooster::mainpath("edit/$row->id")}}"><i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if(CRUDBooster::isDelete() && $button_edit)
                                        <a class="btn btn-xs btn-warning btn-delete" title="Delete" href='{{CRUDBooster::mainpath("delete/$row->id")}}'><i class="fa fa-trash"></i></a>
                                    @endif
                                </div></td>
                        </tr>
                        @php
                            /* @var $row */
                             /* @var $days */
                               $values=Helper::diff_in_days($row->date_from_ad,$row->date_to_ad);
                               $days+=$values;
                        @endphp
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total:</strong></td>
                        <td><strong>{{Helper::daysInPeriod($days)}}</strong></td>
                        <td></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>&nbsp;</th>
                        <th style="width:auto">Working Office</th>
                        <th style="width:auto">Designation</th>
                        <th style="width:auto">Date From BS</th>
                        <th style="width:auto">Date To BS</th>
                        <th style="width:auto">Job Category</th>
                        <th style="width:auto">Appointment</th>
                        <th style="width:auto">Termination</th>
                        <th> -</th>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>

   @if(!is_null($post_index_html) && !empty($post_index_html))
       {!! $post_index_html !!}
   @endif

    </div>
  </div>
</div>
@endsection
