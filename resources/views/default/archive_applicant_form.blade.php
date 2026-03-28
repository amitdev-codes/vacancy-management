@extends('layouts.archive_admin_template')
@section('content')
<div>
    <div class="panel panel-default">
         <x-applicant-tabs :component_name="$page_title" :checkNtStaff="$isNtStaff" :applicantID="$applicant_id" :vaID="$id"></x-applicant-tabs>
        <div class="panel-body" style="padding:20px 0px 0px 0px">
            <?php
                $action = (@$row)?CRUDBooster::mainpath("edit-save/$row->id"):CRUDBooster::mainpath("add-save");
                $return_url = ($return_url)?:g('return_url');
            ?>
            <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action='{{$action}}'>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type='hidden' name='return_url' value='{{ @$return_url }}' />
                <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}' />
                <input type='hidden' name='ref_parameter' value='{{urldecode(http_build_query(@$_GET))}}' />
                @if($hide_form)
                <input type="hidden" name="hide_form" value='{!! serialize($hide_form) !!}'>
                @endif
                <div class="box-body" id="parent-form-area">

                    @if($command == 'detail')
                    @include("crudbooster::default.form_detail")
                    @else
                    @include("crudbooster::default.form_body")
                    @endif
                </div><!-- /.box-body -->

                <div class="box-footer" style="background: #F5F5F5">

                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-10">
                            @if($isApplicant=='true')
                            @if(CRUDBooster::isCreate() || CRUDBooster::isUpdate())
                            @if($button_save && $command != 'detail')
                            <input type="submit" name="submit" value='{{trans("crudbooster.button_save")}}'
                                class='btn btn-success'>
                            @endif
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<!--END AUTO MARGIN-->

@endsection