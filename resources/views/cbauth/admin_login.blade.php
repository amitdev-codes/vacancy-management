@extends("welcome")
@section('content')
<div class="panel panel-default row" style='margin:auto; width:50%;'>
    <div class="login-box-body">
        <div class='panel-heading advertisement'>{{trans("crudbooster.login_message")}}</div>
        @if ( Session::get('message') != '' )
        <div class='alert alert-warning'>
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ Session::get('message') }}
        </div>
        @endif
        <div class='panel-body' style='margin:auto; width:90%;'>
            <form autocomplete='on' action="{{ route('adminPostLogin') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group has-feedback">
                    <label>Email Address :</label>
                    <input autocomplete='on' type="text" class="form-control" name='email' required
                        placeholder="Email" />
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <label>Password :</label>
                    <input autocomplete='off' type="password" class="form-control" name='password' required
                        placeholder="Password" />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div style="margin-bottom:10px" class='row'>
                    <div class='col-xs-12'>
                        <button type="submit" class="btn btn-success btn-block btn-flat"><i class='fa fa-unlock'></i>
                            {{trans("crudbooster.button_sign_in")}}</button>
                    </div>
                </div>

                <div style="margin-bottom:0px" class='row'>
                    <div class='col-xs-12' align="center">
                        <p><a class='btn btn-warning btn-block btn-flat' href='{{route("getForgot")}}'><i
                                    class="fa fa-key" aria-hidden="true"></i>
                                <b> {{trans("Forgot Password")}}</b></a></p>
                    </div>

                </div>
            </form>
        </div>
        <br />
    </div>
</div>
<link rel="stylesheet" type="text/css" href="{{asset('css/custom/applicantlogin.css')}}">
@endsection