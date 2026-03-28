@extends('crudbooster::admin_template')
@section('content')
<script src="{{ asset('/js/check-privileges.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php use Carbon\Carbon;
    $is_nt_staff =  $applicant_name->is_nt_staff;
    $today = Carbon::now(new DateTimeZone('Asia/Kathmandu'))->format('Y-m-d');
    $last_date = Carbon::parse($vacancy_details->last_date_ad)->format('Y-m-d');
?>



<div class='panel panel-default nepali_td'>
    <div class='panel-heading'>
        @if($vacancy_details->opening_type_id==1)
        <h3>खुला तथा समावेशी</h3>
        @endif
        @if($vacancy_details->opening_type_id==2)
        <h3>आन्तरिक प्रतियोगितात्मक</h3>
        @endif
        @if($vacancy_details->opening_type_id==3)
        <h3>आन्तरिक मूल्यांकन बढुवा</h3>
        @endif
    </div>

 
    <div class="panel-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <form method="post" action="{{CRUDBooster::mainpath('add-save')}}" id="vacancy_apply_form">
                        {{-- <form method="post" action="#" id="vacancy_apply_form" > --}}
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <input type="hidden" name="is_cancelled" id="is_cancelled" value="0">
                        <input type="hidden" name="is_rejected" id="is_rejected" value="0">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Applicant's Name</label>
                                <input type="text" name="applicant_name" id="applicant_name" class="form-control input-lg"
                                    placeholder="Applicant's Name" readonly value="{{$applicant_name->fullname}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>Notice No.</label>
                                    <input type="text" name="add_title" id="add_title" class="form-control input-lg"
                                        placeholder="Advertisement" readonly value="{{$vacancy_details->ad_title}}">
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>Advertisement No.</label>
                                    <input type="text" name="add_title" id="add_title" class="form-control input-lg"
                                        placeholder="Advertisement" readonly value="{{$vacancy_details->ad_no}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Applied Post</label>
                                <input type="text" name="designation" id="designation" class="form-control input-lg"
                                    placeholder="Designation" readonly value="{{$vacancy_details->post}}">
                                <input type="hidden" name="designation_id" value="{{$vacancy_details->post_id}}">
                                <input type="hidden" name="vacancy_post_id" value="{{$vacancy_details->vacancy_post_id}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>Applied Date [B.S]</label>
                                    <input type="text" name="applied_date_bs" id="applied_date_bs" class="form-control input-lg"
                                        placeholder="mm/dd/yyyy" readonly>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>Applied Date [A.D]</label>
                                    <input type="text" name="applied_date_ad" id="applied_date_ad" class="form-control input-lg"
                                        placeholder="mm/dd/yyyy" readonly value="<?php echo $today;?>">
                                </div>
                            </div>
                        </div>


                        @if($vacancy_details->opening_type_id==1)
                        <div class="form-group">
                            <p style="font-size:18px;text-decoration:underline;color:blue"> * आफुले दरखास्त भर्न चाहेको
                                खुला तथा समावेशी समुहमा <span style="font-family: Arial Unicode MS, Lucida Grande">&#10003;</span> लगाउनु होला । </p>
                                <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_open'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_open" id="is_open" value='1' />
                                <label class="chkLabel">खुला</label>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="chkLabel" id="previlageLbl" style="text-decoration:underline">समावेशी समुह
                                तर्फ</label>
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_female'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_female" id="is_female"
                                    value='1' />
                                <label class="chkLabel">महिला </label>
                            </span>

                            @if($tribal==1)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_janajati'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_janajati" id="is_janajati"
                                    value='1' />
                                <label class="chkLabel">आदिवासी / जनजाती </label>
                            </span>
                            @else
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_janajati'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_janajati" id="is_janajati"
                                    value='1' onclick="myFunction()" />
                                <label class="chkLabel">आदिवासी / जनजाती</label>
                            </span>
                            @endif

                           @if($madhesi==1)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_madhesi'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_madhesi" id="is_madhesi"
                                    value='1' />
                                <label class="chkLabel">मधेसी </label>
                            </span>
                            @else
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_madhesi'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_madhesi" id="is_madhesi"
                                    value='1' onclick="myFunction()"/>
                                <label class="chkLabel">मधेसी </label>
                            </span>
                            @endif

                            @if($dalit==1)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_dalit'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_dalit" id="is_dalit"
                                    value='1' />
                                <label class="chkLabel">दलित </label>
                            </span>
                           @else
                           <span class="button-checkbox">
                            <input type='hidden' value='0' name='is_dalit'>
                            <input type="checkbox" class="checkbox customchkBox" name="is_dalit" id="is_dalit"
                                value='1' onclick="myFunction()"/>
                            <label class="chkLabel">दलित </label>
                         </span>
                           @endif

                           @if($handicapped==1)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_handicapped'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_handicapped" id="is_handicapped"
                                    value='1' />
                                <label class="chkLabel">अपाङ्ग </label>
                            </span>
                         @else
                         <span class="button-checkbox">
                            <input type='hidden' value='0' name='is_handicapped'>
                            <input type="checkbox" class="checkbox customchkBox" name="is_handicapped" id="is_handicapped"
                                value='1' onclick="myFunction()" />
                            <label class="chkLabel">अपाङ्ग </label>
                        </span>
                         @endif

                         @if($remote==1)
                            <span class="button-checkbox">
                                <input type='hidden' value='0' name='is_remote_village'>
                                <input type="checkbox" class="checkbox customchkBox" name="is_remote_village" id="is_remote_village"
                                    value='1' />
                                <label class="chkLabel">पिछडिएको क्षेत्र </label>
                            </span>
                        @else
                        <span class="button-checkbox">
                            <input type='hidden' value='0' name='is_remote_village'>
                            <input type="checkbox" class="checkbox customchkBox" name="is_remote_village" id="is_remote_village"
                                value='1' onclick="myFunction()"/>
                            <label class="chkLabel">पिछडिएको क्षेत्र </label>
                        </span>
                        @endif
                        @endif
                            @if($vacancy_details->opening_type_id==1)
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Exam Fee</label>
                                        <input type="text" name="amount_for_job" id="amount_for_job" class="form-control input-lg"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Additional Fee</label>
                                        <input type="text" name="amount_for_priv_grp" id="amount_for_priv_grp" class="form-control input-lg"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Total Fee</label>
                                        <input type="text" name="total_amount" id="total_amount" class="form-control input-lg"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($vacancy_details->opening_type_id==2)
                            @if($today > $last_date)
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-6">
                                    <div class="form-group">
                                        <label>Exam Fee</label>
                                        <input type="text" name="amount_for_job" id="amount_for_job" class="form-control input-lg"
                                            readonly value="<?php echo $vacancy_details->fine;?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-6">
                                    <div class="form-group">
                                        <label>Total Fee</label>
                                        <input type="text" name="total_amount" id="total_amount" class="form-control input-lg"
                                            readonly value="<?php echo $vacancy_details->fine;?>">
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4 col-md-6">
                                        <div class="form-group">
                                            <label>Exam Fee</label>
                                            <input type="text" name="amount_for_job" id="amount_for_job" class="form-control input-lg"
                                                readonly value="<?php echo $vacancy_details->fee;?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-6">
                                        <div class="form-group">
                                            <label>Total Fee</label>
                                            <input type="text" name="total_amount" id="total_amount" class="form-control input-lg"
                                                readonly value="<?php echo $vacancy_details->fee;?>">
                                        </div>
                                    </div>
                                    @endif
                                    @endif

                                    <div class="col-xs-4 col-sm-4 col-md-12">
                                        <input type='hidden' value='0' name='i_agree'>
                                        <input type="checkbox" class="checkbox customchkBox" name="i_agree" id="i_agree"
                                            onchange="iAgree()" value='1' />
                                            <label class="chkLabel">
                                            अनलाइनमा मैंले भरेका सबै विवरण सही छन्, मैंले यहाँ अपलोड गरेका सबै कागजात सक्कल बमोजिम दुरुस्त छन् भनी प्रमाणित गर्दछु। अन्यथा भएमा कानून बमोजिम सहुँला बुझाउँला र आवेदन रद्द गरेमा मेरो मञ्जुरी हुनेछ
                                            </label>
                                            <!-- <label class="chkLabel">
                                            मैले यस दरखास्त फाराममा भरेको विवरण ठिक साँचो हो। यसमा कुनै कुरा ढाँटेको वा
                                            लुकाएको ठहरेमा प्रचलित कानून बमोजिम सहुँला बुझाउला।</label> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3">
                                            <button type="button" class="btn btn-warning btn-block btn-lg" onclick="window.location='{{ URL::previous() }}'">Cancel</button>

                                        </div>
                                        <div class="col-xs-3 col-md-3">
                                <input type="submit" name="submit"  id="submit" value="Apply" class="btn btn-success btn-block btn-lg">
                                        </div>
                            </div>
                    </form>

         </div>

      </div>
        </div>
    </div>
</div>



@if ($vacancy_details->opening_type_id==2)
@if($today > $last_date)
<input type="hidden" name="exam_fee" id="exam_fee" value="{{$vacancy_details->fine}}">
@else
<input type="hidden" name="exam_fee" id="exam_fee" value="{{$vacancy_details->internal_fee}}">

@endif
@else
@if($today > $last_date)
<input type="hidden" name="exam_fee" id="exam_fee" value="{{$vacancy_details->fine}}">
<input type="hidden" name="priv_fee" id="privilege_fee" value="{{$vacancy_details->priv_fine}}">
@else
<input type="hidden" name="exam_fee" id="exam_fee" value="{{$vacancy_details->fee}}">
<input type="hidden" name="priv_fee" id="privilege_fee" value="{{$vacancy_details->privilege_fee}}">
@endif
@endif
<input type="hidden" name="open_seats" id="open_seats" value="{{$vacancy_details->open_seats}}">
<input type="hidden" name="mahila_seats" id="mahila_seats" value="{{$vacancy_details->mahila_seats}}">
<input type="hidden" name="janajati_seats" id="janajati_seats" value="{{$vacancy_details->janajati_seats}}">
<input type="hidden" name="madheshi_seats" id="madheshi_seats" value="{{$vacancy_details->madheshi_seats}}">
<input type="hidden" name="dalit_seats" id="dalit_seats" value="{{$vacancy_details->dalit_seats}}">
<input type="hidden" name="apanga_seats" id="apanga_seats" value="{{$vacancy_details->apanga_seats}}">
<input type="hidden" name="remote_seats" id="remote_seats" value="{{$vacancy_details->remote_seats}}">
<input type="hidden" name="is_cancelled" id="is_cancelled" value="{{$is_cancelled->cancelled_count}}">
<input type="hidden" name="is_applied_before" id="is_applied_before" value="{{$is_applied_before->applied_count}}">
<input type="hidden" name="is_cancelled" id="is_cancelled" value="{{$is_cancelled->cancelled_count}}">
<input type="hidden" name="gender_id" id="gender_id" value="{{$applicant_name->gender_id}}">
<input type="hidden" name="opening_type" id="opening_type" value="{{$vacancy_details->opening_type_id}}">
@endsection
