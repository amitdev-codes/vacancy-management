@extends('crudbooster::admin_template')
@section('content')
<?php use Carbon\Carbon;
$today = Carbon::now(new DateTimeZone('Asia/Kathmandu'))->format('Y-m-d');
?>
<div class='panel panel-default'>
  <div class='panel-heading'>Exam Schedule</div>

  <div class="panel-body">
    <div class="container-fluid">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
            <label>Vacancy Notice No.</label>
            <input type="text" name="notice_no" id="notice_no" class="form-control input-lg" placeholder="Notice No." disabled value="{{$vacancy_data->ad_no}}">
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
            <label>Ad Title</label>
            <input type="text" name="ad_title" id="ad_title" class="form-control input-lg" placeholder="Ad Title" disabled value="{{$vacancy_data->ad_title}}">
          </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
            <label>Vacancy Post</label>
            <input type="text" name="vacancy_post" id="vacancy_post" class="form-control input-lg" placeholder="Post" disabled value="{{$vacancy_data->post}}">
          </div>
        </div>

        <!-- <div class="row"> -->

        <div class="col-xs-3 col-sm-3 col-md-3">
          <div class="form-group">
            <label>Published Date BS</label>
            <input type="text" name="published_date_bs" id="published_date_bs" class="form-control input-lg" placeholder="Published Date BS"
              disabled value="{{$vacancy_data->publish_date_bs}}">
          </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
          <div class="form-group">
            <label>Published Date AD</label>
            <input type="text" name="published_date_ad" id="published_date_ad" class="form-control input-lg" placeholder="Published Date AD"
              disabled value="{{$vacancy_data->publish_date_ad}}">
          </div>
        </div>

        <form method="post" action="/app/update_exam">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
              <label>Roll No. Prefix</label>
              <input type="text" value="{{$exam_details_data->roll_prefix}}" name="roll_prefix" id="roll_prefix" class="form-control input-lg"
                placeholder="Roll No. Prefix">
            </div>
          </div>

          <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
              <label>Roll No. Start</label>
              <input type="number" value="{{$exam_details_data->roll_start_value}}" name="roll_start" id="roll_start" class="form-control input-lg"
                placeholder="Roll No. Start">
            </div>
          </div>

      </div>
    </div>
  </div>

  <div class="panel-footer">
    <div class="row">
      <input type="hidden" name="post_id" id="post_id" value="{{$vacancy_data->id}}" />
      <div class="col-xs-6 col-md-3">
        <a href="{{ route('roll.new')}}">
          <button type="submit" name="submit" id="submit" class="btn btn-success btn-block btn-lg">Generate Roll No.</button>
        </a>
      </div>
    </form>

    @php
      // dd($vacancy_data->id);
    @endphp
    <div class="col-xs-6 col-md-3">
      <a href="{{ route('admitcard.generate', ['id' => $vacancy_data->id,'exam_group_id'=>$exam_group_id])}}">
        <button type="button" class="btn btn-warning btn-block btn-lg">Generate Admit Card</button>
      </a>
    </div>
  </div>
  </div>





@endsection

@section('script')
<script type="text/javascript">
  $(function () {
    var i = $('#getid').attr('data-id');

    $(".js-date").datepicker({
      changeMonth: true,
      changeYear: true
    });
    var adids = [];
    var bsids = [];

    for (var n = 0; n < i; n++) {
      var dateid = "#exam_date_ad_" + n;
      adids.push(dateid);
    }

    for (var j = 0; j < i; j++) {
      var bsdate = "#exam_date_bs_" + j;
      bsids.push(bsdate);
    }
    $(bsids).each(function (i, item) {
      $(adids).each(function (index, item2) {
        $(item2).change(function () {
          var dateTime = $(item2).val();
          dateTime = moment(dateTime).format('YYYY-MM-DD');
          if (i == index) {
            $(item).val(AD2BS(dateTime));
          }
        });
      });
    });
  });
</script>
@endsection