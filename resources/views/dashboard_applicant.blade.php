@extends('crudbooster::admin_template')
@section('content')
<div class="row well" style="margin-right:10px; margin-left:10px;">
      <h4>
          <b>Exam dates &nbsp &nbsp
            @if($roll_number[0]->name_np!='')
              <span class="badge">{{$applied_exams->count()}}</span>
            @endif 
         </b>
        </h4>
    <hr>

    @foreach($applied_exams as $ae)
    <div class="col-md-6">
        <div style="border-color:#fff;" class="panel panel-primary">
            <div style="background-color:#00909e" class="panel-heading">
                <h3 style="font-weight:bold;" class="panel-title">{{$ae->name}} ({{$ae->ad_no}})</h3>

            </div>
            @foreach($roll_number as $rn)
            @if($rn->post_id==$ae->post_id)
            <h5 style="color:darkred;margin-left:10px;"><b>Roll number :&nbsp &nbsp {{$rn->exam_roll_no}}</b></h5>
            @break
            @endif
            @endforeach

            <div class="pull-left">
                <a href="/admin/admit_card/user/{{$ae->token_number}}" target="_blank" style="margin-left:10px;"
                    class="btn btn-xs btn-info">E-Admit Card</a>
            </div>
            <table class="table table-inverse">
                <thead>
                    <tr>
                        <th>Paper Name</th>
                        <th>Exam Center</th>
                        <th>Exam Date Bs</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($degination_paper as $dp)
                    @foreach($roll_number as $rn)

                    @if($ae->post_id==$dp->post_id && $rn->paper_id==$dp->paper_id)
                    <tr>
                        <td class="nepali_td">{{$dp->name}}</td>
                        <td class="nepali_td">{{$rn->name_np}}</td>
                        <td class="nepali_td">{{$dp->date_bs}}</td>
                        <td class="nepali_td">{{$dp->time}}</td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
    <div class="alert alert-primary col-sm-12" role="alert">
        <strong class="nepali_td" style="font-size: 15px;">नोट:
        <p>1. माथि E -Admit Card मा Click गरि प्रवेश पत्र प्रिन्ट वा Download  गर्न सकिनेछ !</p>
        <p>2.परिक्षा हलमा जाँदा प्रवेश पत्र र आफ्नो नागरिकता वा नेपाल सरकारबाट जारी भएको फोटो समेतको कुनै परिचय पत्र अनिवार्य रुपमा लिई जानु हुन अनुरोध छ!</p>  </strong>
    </div>
</div>


@endsection
