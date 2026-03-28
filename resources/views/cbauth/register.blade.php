@extends("welcome")
@section('content')
<div class="panel panel-default row" style='margin:auto; '>
  <div class="login-box-body ">
    <?php
    $request = Session::get('request');
    $name = $request["name"];
    $mobile_no = $request["mobile_no"];
    $email = $request["email"];
    ?>
    <div class='panel-heading advertisement'>
      {{trans("New User Registration")}}
    </div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @else
    @if ( Session::get('message') != '' )
    <div class='alert alert-warning'>
      {{ Session::get('message') }}
    </div>
    @endif
    @endif
    <div class='panel-body' style='margin:auto;'>
      <form autocomplete='off' action="{{ route('applicantPostRegister') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form-group has-feedback col-md-12">
          <!-- <label for="Full Name"><b>Full Name</b></label> -->
          <input autocomplete='off' type="text" class="form-control" name='name' required placeholder="Full Name"
            value="{{ $name }}" />
          <span class="glyphicon glyphicon-user form-control-feedback "></span>
        </div>
        <div class="form-group has-feedback col-md-12">
          <!-- <label for="Mobile No."><b>Mobile No.</b></label> -->
          <span class="countryCode form-control-feedback">+977 - </span>
          <input autocomplete='off' id='mob' type="number" class=" form-control" name='mobile_no' required
            placeholder="Mobile No." value="{{ $mobile_no }}" pattern="[9]{1}[0-9]{9}" />
          <span class="glyphicon glyphicon-phone form-control-feedback "></span>
        </div>
        <div id='errMob' class='col-md-12 '></div>

        <div class="form-group has-feedback col-md-12">
          <!-- <label for="email"><b>Email</b></label> -->
          <input autocomplete='off' type="email" class="form-control" id="getEmail" name='email' required
            placeholder="Email" value="{{ $email }}" />
          <span class="glyphicon glyphicon-envelope form-control-feedback "></span>
        </div>
        <div id='errEmail' class='col-md-12 '></div>

        <div class="form-group has-feedback col-md-12">
          <!-- <label for="Password"><b>Password</b></label> -->
          <input autocomplete='off' id='psw' type="password" class="form-control" name='password' required
            placeholder="Password" />
          <span class="glyphicon glyphicon-lock form-control-feedback "></span>
        </div>

        <div class="form-group has-feedback col-md-12">
          <!-- <label for="psw-repeat"><b>Repeat Password</b></label> -->
          <input autocomplete='off' id='rePsw' type="password" class="form-control" name='password_confirmation'
            required placeholder="Retype Password" />
          <span class="glyphicon glyphicon-lock form-control-feedback "></span>
        </div>
        <div id='register_bottom' class='form-group has-feedback col-md-12'>
          <!-- <p class='login-box-msg'>All fields are mandatory!<br/>Password must be at least 6 characters long and use a combination of these:</p> -->
          <div class='alert alert-danger'>

            <span id="letter" class="invalid">Small Letter</span>
            <span id="capital" class="invalid">Capital Letter</span>
            <span id="number" class="invalid">Number</span>
            <span id="symbol" class="invalid">Symbol</span>
            <span id="length" class="invalid">6 Characters</span>
            <span id="match" class="invalid">Match Password</span>

          </div>
        </div>
        <div class="form-group has-feedback col-md-12">
          <label>@captcha
          </label>
          <p><i>Note: Click Image to Refresh Captcha !!</i></p>
          <input autocomplete='off' style='width:180px' type="text" class="form-control" name='captcha' required
            placeholder="Enter Captcha" />

        </div>
        <div class="form-group has-feedback col-md-12">

          <button type="submit" class="btn btn-success btn-block btn-flat" id='RegButton'><i class='fa fa-check'></i>
            Register</button>

        </div>
      </form>

    </div>

  </div>
  <!-- /.login-box-body -->

</div>
<script  language="JavaScript" type="text/javascript" src="{{ asset ('js/register/checkuser.js')}}"></script>
<style>
  .panel-default {
    margin-bottom: 10px !important;
  }

  /* Full-width input fields */
  input[type=text],
  input[type=password] {
    background: #ddd;
  }

  input[type=text]:focus,
  input[type=password]:focus {
    background-color: #ddd;
    outline: none;
  }

  .alert {
    padding: 20px;
  }

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

  /* Add a green text color and a checkmark when the requirements are right */
  .valid {
    color: green;
    padding: 5px;
    /* color: #fff;
    background: green; */
    border-radius: 5px;
    margin: 5px;
  }

  .valid:before {
    position: relative;
    /* left: -5px; */
    content: "✔";
    margin-right: 5px;
  }

  /* Add a red text color and an "x" when the requirements are wrong */
  .invalid {
    color: red;
    padding: 5px;
    /* color: #fff;
    background: red; */
    border-radius: 5px;
    margin: 5px;
  }

  .invalid:before {
    position: relative;
    /* left: -5px; */
    content: "✖";
    margin-right: 5px;
  }

  #register_bottom ul li {
    float: left;
    font-size: 12px;
  }

  .alert span {
    display: inline-block;
  }

  .alert {
    padding: 5px;
  }

  #register_bottom,
  .err {
    display: none;
  }

  .form-control-feedback {
    position: absolute;
    top: 0;
    color: steelblue;
    right: 15px;
    z-index: 2;
    display: block;
    width: 34px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: none;
  }

  .err {
    color: #fff;
    background: red;
  }

  /* #mob { width: 91%;} */
  #mob {

    padding-left: 50px;

  }

  .countryCode {
    position: absolute;
    top: 0;
    color: steelblue;
    left: 20px;
    z-index: 3;
    display: block;
    width: 41px;
    height: 34px;
    line-height: 34px;
    text-align: left;
    pointer-events: none;
  }

  @media only screen and (min-width : 1224px) {

    /* Styles */
    .panel {
      width: 50%;
    }

  }
</style>

<script>
  var mobInput = document.getElementById("mob");
  var emailInput = document.getElementById("getEmail");
  var myInput = document.getElementById("psw");
  var rePsw = document.getElementById("rePsw");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");
  var symbol = document.getElementById("symbol");
  var match = document.getElementById("match");

  // When the user clicks on the password field, show the message box
  myInput.onfocus = function () {
    document.getElementById("register_bottom").style.display = "block";
  }

  // // When the user clicks outside of the password field, hide the message box
  // myInput.onblur = function() {
  //   document.getElementById("register_bottom").style.display = "none";
  // }

  // When the user clicks on the password field, show the message box
  rePsw.onfocus = function () {
    document.getElementById("register_bottom").style.display = "block";
  }

  // // When the user clicks outside of the password field, hide the message box
  // rePsw.onblur = function() {
  //   document.getElementById("register_bottom").style.display = "none";
  // }


  // When the user starts to type something inside the password field
  myInput.onkeyup = function () {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if (myInput.value.match(lowerCaseLetters)) {
      letter.classList.remove("invalid");
      letter.classList.add("valid");
      document.getElementById("RegButton").disabled = false;

    } else {
      letter.classList.remove("valid");
      letter.classList.add("invalid");
      document.getElementById("RegButton").disabled = true;

    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if (myInput.value.match(upperCaseLetters)) {
      capital.classList.remove("invalid");
      capital.classList.add("valid");
      document.getElementById("RegButton").disabled = false;

    } else {
      capital.classList.remove("valid");
      capital.classList.add("invalid");
      document.getElementById("RegButton").disabled = true;

    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if (myInput.value.match(numbers)) {
      number.classList.remove("invalid");
      number.classList.add("valid");
      document.getElementById("RegButton").disabled = false;

    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
      document.getElementById("RegButton").disabled = true;

    }
    // Validate Non-numeric
    var symbols = /[#?!@$%^&*-]/g;
    if (myInput.value.match(symbols)) {
      symbol.classList.remove("invalid");
      symbol.classList.add("valid");
      document.getElementById("RegButton").disabled = false;

    } else {
      symbol.classList.remove("valid");
      symbol.classList.add("invalid");
      document.getElementById("RegButton").disabled = true;

    }


    // Validate length
    if (myInput.value.length >= 6) {
      length.classList.remove("invalid");
      length.classList.add("valid");
      document.getElementById("RegButton").disabled = false;

    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
      document.getElementById("RegButton").disabled = true;

    }

    // Validate Retype password

    if (myInput.value == rePsw.value) {

      match.classList.remove("invalid");
      match.classList.add("valid");
      document.getElementById("RegButton").disabled = false;

    } else {

      match.classList.remove("valid");
      match.classList.add("invalid");
      document.getElementById("RegButton").disabled = true;

    }

  }
  rePsw.onkeyup = function () {
    // Validate Retype password
    var myInput = document.getElementById("psw");

    if (rePsw.value == myInput.value) {

      match.classList.remove("invalid");
      match.classList.add("valid");
      document.getElementById("RegButton").disabled = false;

    } else {

      match.classList.remove("valid");
      match.classList.add("invalid");
      document.getElementById("RegButton").disabled = true;

    }

  }

  // mobInput.onblur = function() {
  //   document.getElementById("errMob").style.display = "none";
  // }

  mobInput.onkeyup = function () {
    var div = document.getElementById('errMob');
    var numbers = /[0-9]/g;
    var symbols = /[#?!@$%^&*-]/g;
    var upperCaseLetters = /[A-Z]/g;
    var lowerCaseLetters = /[a-z]/g;

    if (isNaN(mobInput.value)) {
      div.style.display = "block";
      div.innerHTML =
      '<div class="alert alert-danger"> <strong>Whoops!</strong> Input Must be Numbers only!!. </div>';
      document.getElementById("RegButton").disabled = true;
    } else {
      // Validate length
      if (mobInput.value.length == 10) {
        div.style.display = "none";
        document.getElementById("RegButton").disabled = false;

      } else {
        div.style.display = "block";
        div.innerHTML =
        '<div class="alert alert-danger"> <strong>Whoops!</strong> Input Must be 10 Digits !!. </div>';
        document.getElementById("RegButton").disabled = true;

      }
    }
  }

  // emailInput.onblur = function() {
  //   document.getElementById("errEmail").style.display = "none";
  // }


  emailInput.onkeyup = function () {
    var div = document.getElementById('errEmail');
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (emailInput.value.match(mailformat)) {
      div.style.display = "none";
      document.getElementById("RegButton").disabled = false;

    } else {
      div.style.display = "block";
      div.innerHTML =
        '<div class="alert alert-danger"> <strong>Whoops!</strong> You have entered an invalid email address !!. </div>';
      document.getElementById("RegButton").disabled = true;

    }
  }
</script>

@endsection