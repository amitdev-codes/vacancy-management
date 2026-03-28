@extends('welcome') @section('content')
<div class="container  nepali_td">
    <div class="col-md-12 ">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>{{$notice_data->title}}</h3>
                <h5  class="pull-right text-success readMore" style="font-weight:200; margin-top: -20px;">Published Date: {{$notice_data->date_ad}}</h5></div>
                <div class="panel-body">
                    <article>
                        <p>{!!$notice_data->body!!}</p>
                        <p></p>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 gap10"></div>
@endsection