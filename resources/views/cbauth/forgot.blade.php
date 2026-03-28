@extends("welcome")
@section('content')
<div class="panel panel-default row" style='margin:auto; width:50%;' >
    <div class="login-box-body">
    <div class='panel-heading advertisement'>{{trans("crudbooster.forgot_message")}}</div>
    @if ( Session::get('message') != '' )
            <div class='alert alert-warning'>
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                {{ Session::get('message') }}
            </div>
        @endif
    <div  class='panel-body' style='margin:auto; width:90%;'>
    <form action="{{ route('postForgot') }}" method="post">
		  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name='email' required placeholder="Email Address"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              {{trans("crudbooster.forgot_text_try_again")}} <a class='gologin' href='{{route("applicantLogin")}}'><b>{{trans("crudbooster.click_here")}}</b></a>                          
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">{{trans("crudbooster.button_submit")}}</button>
            </div><!-- /.col -->
          </div>
        </form>

    </div>

    <br/>
    <!--a href="#">I forgot my password</a-->

    </div><!-- /.login-box-body -->

</div><!-- /.login-box -->
<style>
.closebtn {
  margin-left: 15px;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

a.gologin {
    color: #337ab7;
    text-decoration: none;
}

a.gologin:hover {
    color: #9ebef9;
    /* font-size: 16px; */
    text-decoration: none;
}
 .panel-default { margin-bottom: 10px !important;}
</style>
@endsection