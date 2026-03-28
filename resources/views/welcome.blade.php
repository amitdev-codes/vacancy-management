<!DOCTYPE html>
<html class="no-js">
<head>
    <title>NT Vacancy</title>
    <meta name="mobile-web-app-capable" content="yes">
     <link href="{{asset('vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
     <link href="{{asset('fonts/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="{{asset('css/vacancy.css')}}">
    <script src="{{asset('vendor/crudbooster/assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    <script src="{{asset('vendor/crudbooster/assets/adminlte/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script> 
    <link rel="manifest" href="/mix-manifest.json">
    <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert.min.css')}}">
     <script src="{{asset('js/sweetalert.min.js')}}"></script>
     <style> @font-face { font-family: Kalimati; src: url('/fonts/Kalimati.ttf'); }.nepali_td {font-family: Kalimati;}</style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header">
                <div class="container logo">
                    <a href="/"><img src="{{asset('images/nt-logo-4.png')}}"><h3 class="hgroup">NT Vacancy </h3></a>
                </div>
            </div>
        </div>

    </header>

    <nav class="navbar navbar-default inner">
        <div class="container-fluid container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                    aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav ">
                    {{-- <li class="@if(URL::current() == URL::to('/')) active @endif"><a href="/"><span>Home</span></a></li>
                    <li class="@if(URL::current() == URL::to('/faq')) active @endif"><a href="/faq"><span>FAQ</span></a></li> 
                    <li class="@if(URL::current() == URL::to('/howto')) active @endif"><a href="/howto"><span>How To</span></a></li>
                    <li class="@if(URL::current() == URL::to('/relatedstaffs')) active @endif"><a href="/relatedstaffs"><span>Related Staff</span></a></li>
                    <li>
                        <a href="https://www.ntc.net.np/pages/view/nepal-telecom" target='_blank'>About Us</a>
                    </li>
                    <li>
                        <a href="https://www.ntc.net.np/pages/contact" target='_blank'>Contact Us</a>
                    </li>--}}

                </ul>
                <ul class="nav navbar-nav navbar-right">
                     <li>
                         @if(Request::segment(1)=="admin")
                          <a href="{{route('adminLogin')}}"> <i class="fa fa-unlock"></i> Sign In</a>
                         @else
                          <a href="{{route('applicantLogin')}}"> <i class="fa fa-unlock"></i> Sign In</a>
                         @endif
                    </li>
                    <li>
                        <a href="{{route('applicantRegister')}}"> <i class="fa fa-user"></i> Register</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->

    </nav>

    <div class="container">
        {{-- @if ( Session::get('message') != '' )
        <div class='alert alert-warning'>
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ Session::get('message') }}
        </div>
        @endif --}}

        @yield('content')
    </div>
    <footer id="footer" class="dark">
        <div id="copyrights">
            <div class="container clearfix">
                <div class="row">
                    <div class="col-md-12">
                        © Copyright <?php echo date("Y");?>,<a href="https://www.ntc.net.np/" target='_blank' class="parent">Nepal Doorsanchar Company Limited (Nepal Telecom)</a>, All Rights Reserved <br><small>No part of this website or any of its contents may be reproduced, copied, embed, modified or adapted, without the prior written consent of the company.</small>
                    </div>                   
                </div>
            </div>
        </div>
        </div>
        <!-- End Copyrights -->
    </footer>

    <!--/.fluid-container-->
     <script src="{{asset('vendor/crudbooster/assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    <script src="{{asset('vendor/crudbooster/assets/adminlte/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script> 
<script>
    $(function(){
        var acc = document.getElementsByClassName("accordion");
        for (i = 0; i < acc.length; i++)
         {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active1");

                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                }
                else {
                    panel.style.display = "block";
                }
            });
        }
    });

    </script>

<script>
$(function() {
        if('serviceWorker' in navigator) {
            navigator.serviceWorker
                        .register('js/sw.js')
                        .then(function() { console.log('Service Worker Registered'); });
            }
    });
</script>
</body>
</html>
