@extends('layouts.applicant_admin_template')
@section('content')

<div>
 @if($isApplicant!='true')
  	@if(CRUDBooster::getCurrentMethod() != 'getProfile' && $button_cancel)
  		@if(g('return_url'))
  			<p><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
  		@else
  			<p><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
  		@endif
      @endif
 @endif
     <!-- <x-applicant-tabs :component_name="$page_title" :checkNtStaff="$isNtStaff"></x-applicant-tabs> -->
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
            @if($isApplicant=='true')
              @if($table!="applicant_training_info")

            <a href="{{CRUDBooster::adminPath()}}/{{$table}}/add" id="btn_add_new_data" class="btn btn-sm btn-success" title="Add Data">
                <i class="fa fa-plus-circle"></i> Add Data
            </a>
            @else
            <a href="{{CRUDBooster::adminPath()}}/user_training_info/add" id="btn_add_new_data" class="btn btn-sm btn-success" title="Add Data">
                <i class="fa fa-plus-circle"></i> Add Data
            </a>
            @endif
            @endif
            <br style="clear:both"/>
        </div>
        <div class="box-body table-responsive no-padding">
            @include("crudbooster::default.table")
        </div>
    </div>

   @if(!is_null($post_index_html) && !empty($post_index_html))
       {!! $post_index_html !!}
   @endif

    </div>
  </div>
</div>
<!--END AUTO MARGIN-->

@endsection
