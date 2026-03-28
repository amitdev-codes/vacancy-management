@extends('crudbooster::admin_template')
 @section('content')
<div class="container">
    <!-- <h2>Dynamic Tabs</h2>-->
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#application">Vacancy Application</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="application" class="tab-pane fade in active">
            <!-- <h3>HOME</h3>-->
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <h3>View Vacancy Application</h3>
                </div>
                <div class="panel-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-8">
                                <form method="post" action="{{CRUDBooster::mainpath('add-save')}}" onsubmit="tokenNumber();">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label>Applicant's Name</label>
                                                <input type="text" name="applicant_name" id="applicant_name" class="form-control input-lg"
                                                    placeholder="Applicant's Name" readonly value="{{$vacancy_details->fullname}}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label>Token No. </label>
                                                <input type="text" name="token_number" id="token_number" class="form-control input-lg"
                                                    placeholder="Token Number" readonly value="{{$vacancy_details->token_number}}">
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
                                                <input type="text" name="applied_date_ad" id="applied_date_ad" class="form-control input-lg"
                                                    placeholder="mm/dd/yyyy" readonly value="{{$vacancy_details->applied_date_ad}}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label>Date on [B.S]</label>
                                                <input type="text" name="applied_date_bs" id="applied_date_bs" class="form-control input-lg"
                                                    placeholder="mm/dd/yyyy" readonly value="{{$vacancy_details->applied_date_bs}}">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="payment" class="tab-pane fade">
            <div class='container'>
                <div clas='row'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3>View Payment Detail</h3>
                        </div>
                        <div class='panel-body'>
                            <div class='form-horizontal'>
                                <div class="form-group">
                                    <label class='control-label col-md-2'>Total Payable</label>
                                    <div class='col-sm-5'>
                                        <input type="text" class='form-control' readonly value='{{$vacancy_details->total_amount}}' />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class='control-label col-md-2'>Total Paid</label>
                                    <div class='col-md-5'>
                                        <input type="text" class='form-control' readonly value='{{$payment_details->amount_paid}}' />
                                        <!-- later change !-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='panel-footer'>
                            <table class="table table-responsive table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Token No.</th>
                                        <th>Receipt No.</th>
                                        <th>Receipt date</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$payment_details->token_number}}</td>
                                        <td>{{$payment_details->receipt_number}}</td>
                                        <td>{{$payment_details->receipt_date_ad}}</td>
                                        <td>{{$payment_details->amount_paid}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="exam" class="tab-pane fade">
            <div class='container'>
                <div clas='row'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3>View Exam Detail</h3>
                        </div>
                        <div class='panel-body'>
                            <div class='form-horizontal'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label class='control-label col-md-4'>Exam Date</label>
                                            <div class='col-sm-5'>
                                                <input type="text" class='form-control' readonly value='' />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class='control-label col-md-4'>Exam Center</label>
                                            <div class='col-md-5'>
                                                <input type="text" class='form-control' readonly value='' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label class='control-label col-md-2'>Roll No.</label>
                                            <div class='col-md-4'>
                                                <input type="text" class='form-control' readonly value='' />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class='control-label col-md-2'>Paper 1</label>
                                            <div class='col-md-4'>
                                                <input type="text" class='form-control' readonly value='' />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="interview" class="tab-pane fade">
            <div class='container'>
                <div clas='row'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                            <h3>View Interview Detail</h3>
                        </div>
                        <div class='panel-body'>
                            <div class='form-horizontal'>
                                <div class='row'>
                                    <div class='col-md-6'>

                                    </div>
                                    <div class='col-md-6'>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class='container'>
                <div class='row'>
                </div>
            </div>
        </div>

        <input type="hidden" name="privilege_fee" id="privilege_fee" value="{{$vacancy_details->privilege_fee}}">
        <input type="hidden" name="mahila_seats" id="mahila_seats" value="{{$vacancy_details->mahila_seats}}">
        <input type="hidden" name="janajati_seats" id="janajati_seats" value="{{$vacancy_details->janajati_seats}}">
        <input type="hidden" name="madheshi_seats" id="madheshi_seats" value="{{$vacancy_details->madheshi_seats}}">
        <input type="hidden" name="dalit_seats" id="dalit_seats" value="{{$vacancy_details->dalit_seats}}">
        <input type="hidden" name="apanga_seats" id="apanga_seats" value="{{$vacancy_details->apanga_seats}}">
        <input type="hidden" name="max_token" id="max_token" value="">
        <input type="hidden" name="gender_id" id="gender_id" value="{{$applicant_name->gender_id}}">@endsection