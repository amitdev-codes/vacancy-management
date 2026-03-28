@extends('crudbooster::admin_template')
@section('content')
<div class='panel panel-default'>
    <div class='panel-heading'>
        <h3>Edit Vacancy Application</h3>
    </div>

    <div class="panel-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 ">
                    <form method="post" action="{{CRUDBooster::mainpath('edit-save/'.$vacancy_details->id)}}"
                        id="vacancy_apply_form">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <input type="hidden" name="is_cancelled" id="is_cancelled" value="0">
                        <input type="hidden" name="is_rejected" id="is_rejected" value="0">

                        <input type="hidden" name="id" value="{{$vacancy_details->id}}">
                        <input type="hidden" name="applicant_id" value="{{$vacancy_details->applicant_id}}">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Applicant's Name</label>
                                    <input type="text" name="applicant_name" id="applicant_name"
                                        class="form-control input-lg" placeholder="Applicant's Name" readonly
                                        value="{{$vacancy_details->fullname}}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Token No. </label>
                                    <input type="text" name="token_number" id="token_number"
                                        class="form-control input-lg" placeholder="Token Number" readonly
                                        value="{{$vacancy_details->token_number}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Notice No.</label>
                                    <input type="text" name="add_title" id="add_title" class="form-control input-lg"
                                        placeholder="Advertisement" readonly value="{{$vacancy_details->ad_title}}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Advertisement No.</label>
                                    <input type="text" name="add_title" id="add_title" class="form-control input-lg"
                                        placeholder="Advertisement" readonly value="{{$vacancy_details->ad_no}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Applied Post</label>
                            <input type="text" name="designation" id="designation" class="form-control input-lg"
                                placeholder="Designation" readonly value="{{$vacancy_details->post}}">
                            <input type="hidden" name="designation_id" value="{{$vacancy_details->post_id}}">
                            <input type="hidden" name="vacancy_post_id" value="{{$vacancy_details->vacancy_post_id}}">
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Applied Date[A.D]</label>
                                    <input type="text" name="applied_date_ad" id="applied_date_ad"
                                        class="form-control input-lg" placeholder="mm/dd/yyyy" readonly
                                        value="{{$vacancy_details->applied_date_ad}}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Date on [B.S]</label>
                                    <input type="text" name="applied_date_bs" id="applied_date_bs"
                                        class="form-control input-lg" placeholder="mm/dd/yyyy" readonly
                                        value="{{$vacancy_details->applied_date_bs}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <p style="font-size:18px;text-decoration:underline;color:blue">आफुले दरखास्त भर्न चाहेको खुला तथा समावेशी समुहमा √ लगाउनु होला । </p>

                            @if($vacancy_details->open_seats > 0)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_open'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_open" id="is_open"
                                    value='1' @if( $vacancy_details->is_open == 1) checked @endif/>
                                <label class="chkLabel">खुला</label>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="chkLabel" id="previlageLbl" style="text-decoration:underline">समावेशी समुह
                                तर्फ</label>
                            @if($vacancy_details->mahila_seats > 0 && $vacancy_details->gender_id == 2 )
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_female' readonly>
                                <input type="checkbox" class="checkbox customchkBox" name="is_female" id="is_female"
                                    value='1' @if( $vacancy_details->is_female == 1) checked @endif/>
                                <label class="chkLabel">महिला </label>
                            </span>
                            @endif @if($vacancy_details->janajati_seats > 0)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_janajati' readonly>
                                <input type="checkbox" class="checkbox customchkBox" name="is_janajati" id="is_janajati"
                                    value='1' @if( $vacancy_details->is_janajati == 1) checked @endif/>
                                <label class="chkLabel">आदिवासी / जनजाती </label>
                            </span>
                            @endif @if($vacancy_details->madheshi_seats > 0)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_madhesi' readonly>
                                <input type="checkbox" class="checkbox customchkBox" name="is_madhesi" id="is_madhesi"
                                    value='1' @if( $vacancy_details->is_madhesi == 1) checked @endif/>
                                <label class="chkLabel">मधेसी</label>
                            </span>
                            @endif @if($vacancy_details->dalit_seats > 0)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_dalit' readonly>
                                <input type="checkbox" class="checkbox customchkBox" name="is_dalit" id="is_dalit"
                                    value='1' @if( $vacancy_details->is_dalit == 1) checked @endif/>
                                <label class="chkLabel">दलित </label>
                            </span>
                            @endif @if($vacancy_details->apanga_seats > 0)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_handicapped' readonly>
                                <input type="checkbox" class="checkbox customchkBox" name="is_handicapped"
                                    id="is_handicapped" value='1' @if( $vacancy_details->is_handicapped == 1) checked
                                @endif/>
                                <label class="chkLabel">अपाङ्ग</label>
                            </span>
                            @endif @if($vacancy_details->remote_seats > 0)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_remote_village'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_remote_village"
                                    id="is_remote_village" value='1' @if( $vacancy_details->is_remote_village == 1)
                                checked @endif />
                                <label class="chkLabel">पिछडिएको क्षेत्र</label>
                            </span>
                            @endif
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Exam Fee</label>
                                        <input type="text" name="amount_for_job" id="amount_for_job"
                                            class="form-control input-lg" readonly
                                            value="{{$vacancy_details->amount_for_job}}">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Additional Fee</label>
                                        <input type="text" name="amount_for_priv_grp" id="amount_for_priv_grp"
                                            class="form-control input-lg" readonly
                                            value="{{$vacancy_details->amount_for_priv_grp}}">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Total Fee</label>
                                        <input type="text" name="total_amount" id="total_amount"
                                            class="form-control input-lg" readonly
                                            value="{{$vacancy_details->total_amount}}">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <label>Token No. </label>
                                <input type="text" name="token_number" id="token_number" class="form-control input-lg" placeholder="Token Number" readonly
                                    value="{{$vacancy_details->token_number}}">
                            </div> -->
                        </div>
                        <div class="row">

                            <div class="form-group">
                                <input type='hidden' value='0' name='i_agree'>
                                <input type="checkbox" class="checkbox" name="i_agree" id="i_agree" onchange="iAgree()"
                                    value='1' checked onclick="return false;" />
                                <label>I agree to Terms of Service agreement.</label>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <input type="submit" name="submit" id="submit" value="Save"
                                        class="btn btn-success btn-block btn-lg"
                                        onclick="return confirm('Are you sure you want to save data?')">
                                </div>
                                <!-- <div class="col-xs-6 col-md-6"><a href="#" class="btn btn-success btn-block btn-lg">Apply</a></div> -->
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
<input type="hidden" name="open_seats" id="open_seats" value="{{$vacancy_details->open_seats}}">

<input type="hidden" name="exam_fee" id="exam_fee" value="{{$vacancy_details->fee}}">
<input type="hidden" name="priv_fee" id="privilege_fee" value="{{$vacancy_details->privilege_fee}}">
<input type="hidden" name="mahila_seats" id="mahila_seats" value="{{$vacancy_details->mahila_seats}}">
<input type="hidden" name="janajati_seats" id="janajati_seats" value="{{$vacancy_details->janajati_seats}}">
<input type="hidden" name="madheshi_seats" id="madheshi_seats" value="{{$vacancy_details->madheshi_seats}}">
<input type="hidden" name="dalit_seats" id="dalit_seats" value="{{$vacancy_details->dalit_seats}}">
<input type="hidden" name="apanga_seats" id="apanga_seats" value="{{$vacancy_details->apanga_seats}}">
<input type="hidden" name="is_applied_before" id="is_applied_before" value="{{$is_applied_before->applied_count}}">
<input type="hidden" name="max_token" id="max_token" value="">
<input type="hidden" name="gender_id" id="gender_id" value="{{$vacancy_details->gender_id}}"> 
@endsection