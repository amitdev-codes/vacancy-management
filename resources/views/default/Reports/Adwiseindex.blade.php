@extends('layouts.admin_template')

@section('content')

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

  <?php
    if($ad_id==0){
      $combo_title='विज्ञापन';
    }
    else{
        foreach($advertisement as $ad){
          if($ad->id==$ad_id){
            $combo_title=$ad->ad_title_en;
          
            $combo_title=$combo_title.'-'.$ad->name_np;
            

          }
        }
    }
  ?>
  <?php
    if($md_id==0){
      $combo_title_designation='पद';
    }
    else{
        foreach($designation as $md){
          if($md->id==$md_id){
            $combo_title_designation=$md->name_np;
          }
        }
    }
  ?>

  <?php
    if($opening_type_id==0){
      $combo_title_ot='Opening Type';
    }
    else{
        foreach($opening_types as $ot){
          if($ot->id==$opening_type_id){
            $combo_title_ot=$ot->name_np;
          }
        }
    }
  ?>

    <!-- @if(g('return_url'))
   <p><a href='{{g("return_url")}}'><i class='fa fa-chevron-circle-{{ trans('crudbooster.left') }}'></i> &nbsp; {{trans('crudbooster.form_back_to_list',['module'=>urldecode(g('label'))])}}</a></p>
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
    @endif -->

    <div class="box">
      <div class="box-header">
          
        <?php $lastEl =  $advertisement->last();?>
        <div class="box-tools pull-left" style="position: relative;margin-top: -5px;margin-left:20px">
           <div class="dropdown">
           @if($isApplicant!='true')
                  <!-- combo ad -->
                  <button class="btn btn-default dropdown-toggle" style="padding-left:20px;padding-right:20px;color:darkblue;font-size:15px;" type="button" id="menu1" data-toggle="dropdown">{{$combo_title}}
                  <span class="caret"></span></button>
            
                  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  @foreach($advertisement as $ad)
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{CRUDBooster::mainpath()}}?ad={{$ad->id}}">{{$ad->ad_title_en."-".$ad->name_np."-".$ad->last_date_for_application_bs}}</a></li>
                  @endforeach
                   </ul>  
            @endif

              @if($isApplicant=='true')
                  <button class="btn btn-default dropdown-toggle" style="padding-left:20px;padding-right:20px;color:darkblue;font-size:15px;" type="button" id="menu1" data-toggle="dropdown">{{$combo_title_ot}}
                  <span class="caret"></span></button>
            
             <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  @foreach($opening_types as $ot)
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{CRUDBooster::mainpath()}}?ot={{$ot->id}}">{{$ot->name_np}}</a></li>
                  @endforeach
              </ul>
              @endif
            </div>
          </div>
   <!-- combo designation -->
                  
                   <div class="box-tools pull-left" style="position: relative;margin-top: -5px;margin-left:20px">
                    <div class="dropdown">
                    @if($isApplicant!='true')
                    @if(isset($designation))
                    <button class="btn btn-default dropdown-toggle" style="color:darkblue;font-size:15px;" type="button" id="menu2" data-toggle="dropdown">{{$combo_title_designation}}
                    <span class="caret"></span></button>
              
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu2">
                    @foreach($designation as $md)
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="{{CRUDBooster::mainpath()}}?md={{$md->id}}&&ad={{$md->vacancy_ad_id}}">{{$md->name_np}}</a></li>
                    @endforeach
                     </ul>
                     @endif
                     @endif
                     </div>
                   </div>


      <div class="box-tools pull-{{ trans('crudbooster.left') }}" style="position: relative;margin-top: 10px;margin-left: 15px">

              @if($button_filter)
              <a style="margin-top:-23px" href="javascript:void(0)" id='btn_advanced_filter' data-url-parameter='{{$build_query}}' title='{{trans('crudbooster.filter_dialog_title')}}' class="btn btn-sm btn-default {{(Request::get('filter_column'))?'active':''}}">
                <i class="fa fa-filter"></i> {{trans("crudbooster.button_filter")}}
              </a>
              @endif

            
        </div>


        <br style="clear:both"/>
        </div>
      

      <div class="box-body table-responsive no-padding">
        @include("default.Reports.table")
      </div>

    </div>

   @if(!is_null($post_index_html) && !empty($post_index_html))
       {!! $post_index_html !!}
   @endif

@endsection
