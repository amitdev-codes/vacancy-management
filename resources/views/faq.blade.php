@extends('welcome') @section('content')

<ol class="breadcrumb" style="margin-bottom: 20px;">
    <li>FAQ <i class="fa fa-question" aria-hidden="true"></i></li>
</ol>
@foreach($faqs as $faq )
<div class="panel-group" id="faqAccordion">
    <div class="panel panel-default ">
        <div class="panel-heading accordion-toggle question-toggle collapsed" data-toggle="collapse" data-parent="#faqAccordion"
            data-target="#{{$faq->id}}">
            <h4 class="panel-title">
                <a href="#" class="ing">Q: {{$faq->question}}</a>
            </h4>

        </div>
        <div id="{{$faq->id}}" class="panel-collapse collapse" style="height: 0px;">
            <div class="panel-body">
                <h5><span class="label label-primary">Answer</span></h5>

                <p>{!!$faq->answer!!}</p>
            </div>
        </div>
    </div>
</div>
@endforeach @endsection