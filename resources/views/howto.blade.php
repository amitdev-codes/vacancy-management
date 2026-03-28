 @extends('welcome') @section('content')
<ol class="breadcrumb" style="margin-bottom: 20px;">
    <li>HOW TO <i class="fa fa-question-circle-o" aria-hidden="true"></i></li>
</ol>
@foreach($howtos as $howto)
<div class="panel-group" id="faqAccordion">
    <div class="panel panel-default ">
        <div class="panel-heading accordion-toggle question-toggle collapsed" data-toggle="collapse" data-parent="#faqAccordion"
            data-target="#{{$howto->id}}">
            <h4 class="panel-title">
                <a href="#" class="ing">Q: {{$howto->question}}</a>
            </h4>

        </div>
        <div id="{{$howto->id}}" class="panel-collapse collapse" style="height: 0px;">
            <div class="panel-body">
                <h5><span class="label label-primary">Answer</span></h5>

                {!!$howto->answer!!}
                @if($howto->file_upload != null)
                <strong class="label label-primary"><a href="{{$howto->file_upload}}" target="_blank">View</strong> @endif
            </div>
        </div>
    </div>
</div>
@endforeach @endsection