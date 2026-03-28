@extends('welcome')
@section('content')

        @if (\Session::has('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        <ul>
        <li>{!! \Session::get('success') !!}</li>
        </ul>
        </div>
        <?php  Session::forget('success'); ?>
        @endif
        <div class="panel panel-default row nepali_td" style='margin:auto; width:50%;'>
            <div class="login-box-body">
                @if ( Session::get('message') != '' )
                <div class='alert alert-warning'>
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class='panel-body' style='margin:auto; width:90%;'>
                    <form autocomplete='off' method="post" class="otp_form" id="otp_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input id="user_id" name="user_id" type="hidden" value="{{ $encoded_id }}">
                        <div class="alert alert-primary" role="alert">
                            <h3>कृपया OTP को लागि तपाईको दर्ता गरिएको इमेल अथवा मोबाईलको एस.एम.एस. चेक गर्नुहोला</h3>
                            <p>तपाईको इमेल इनबक्समा प्राप्त नभएमा Junk/Spam मा चेक गरी प्रकृया अगाडी बढाउनु होला</p>
                        </div>
                        <div class="form-group has-feedback">
                            <input autocomplete='off' type="number" class="form-control" name='otp' id="otpcode" required placeholder="Enter Your OTP" />
                        </div>
                        <div class="form-group has-feedback" style="margin-bottom:5px">
                            <div class="register">
                                <input type="submit" name="submit" id="submit" value="पेश गर्नुहोस्" class="btn btn-primary btn-block btn-flat" />
                            </div>
                        </div>

                            <div class='form-group has-feedback' style="margin-bottom:5px">
                                <div class="resendotp">
                                    <a class='btn btn-warning btn-block btn-flat' href='{{route("resendOtp",['id'=>$encoded_id])}}'><i class="fa fa-refresh" aria-hidden="true"></i>
                                    <b>OTP Not Received?{{trans("Resend OTP")}}</b></a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
              $('#otp_form').on('submit', function (event) {
                  event.preventDefault();
                   var otpcode = document.getElementById('otpcode').value;
                   var user_id = document.getElementById('user_id').value;
          
                    if (otpcode)
                     {
                      $.ajax({
                        url: '{{ route("verifyotp") }}',
                        method: "POST",
                        data: {
                             '_token': '{{ csrf_token() }}',
                             'otpcode':otpcode,
                             'user_id':user_id,
                         },
                         dataType: 'json',
                        success: function (data) {
                            console.log(data);
                          if (data['status']==false){
                            swal({title: "Sorry!",text: "Inavlid Otp Code !!",icon: "warning"}).then( () => location.reload());
                               return false;
                          }else{
                            swal({title: "बधाई छ!",text: "Your Account was succesfully Activated!",icon: "success"}).then(function () {
                                window.location = "{{route('home')}}";
                                });
                               return true;
                             }
                        }
                      });
                      }else{
                          swal({title: "Sorry!",text: "Enter valid otp code!!",icon: "warning"}).then( () => location.reload()); 
                      }
                  });
                
                });
          </script>
@endsection