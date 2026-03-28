@extends("layouts.register")
@section('content')
<div class="register-box" style="width:500px !important;">
    <div class="login-logo">
    <a href="{{url('/')}}">
        <img title='{!!(CRUDBooster::getSetting('appname') == 'CRUDBooster')?"<b>CRUD</b>Booster":CRUDBooster::getSetting('appname')!!}' src='{{ CRUDBooster::getSetting("logo")?asset(CRUDBooster::getSetting('logo')):asset('\images\nt-logo-4.png') }}' style='max-width: 100%;max-height:170px'/>
    </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <span>Hi {{ Session::get('name') }}, </span>
        <br/>
        <br/>
        <span>User has been registered with following details : </span>
        <br/>
        <br/>
        <table>
            <tr>
                <th><div style="width:150px">Name</style></th>
                <td>{{ @Session::get('name') }}</td>
            </tr>
            <tr>
                <th>Email / UserName</th>
                <td>{{ @Session::get('email') }}</td>
            </tr>
            <tr>
                <th>Password</th>
                <td>{{ @Session::get('password') }}</td>
            </tr>
        </table>
        <br/>
        <br/>
        <span>Please use above details to perform <a href="{{ App::make('url')->to('/login')}}">Login </a></span>
        <br/>
        <br/>
        Thank you
        <br/>
        Nepal Telecom
        </pre>
    </div><!-- /.login-box-body -->

</div><!-- /.login-box -->
@endsection