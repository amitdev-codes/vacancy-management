<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>

    <style>
        table {
            width: 100%;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid #000;
            border-collapse: collapse;
        }
    </style>

</head>

<body>
    <?php
     dd($candidate_data);
    ?>
    <header style="margin-left:94px;">
        <div class="heading">
            <h2>नेपाल टेलिकम</h2>
            <br>
            <h2 style="margin-top: -20px;">पदपूर्ति सचिबालय</h2>
        </div>
        <div class="left header">
            <h5>विज्ञापन: {{$intro_data[0]->ad_title_en}} </h5>
            <h5>पद: {{$intro_data[0]->designation}} </h5>
            <h5 style="margin-top: -25px;
    margin-left: 30%;">तह: {{$intro_data[0]->work_level}}</h5>
            <h5>पद संख्या: {{$intro_data[0]->total_req_seats}} </h6>
                <h5 style="margin-top: -25px;
    margin-left: 10%;">खुल्ला: {{$intro_data[0]->open_seats}} </h5>
                <h5 style="margin-top: -25px;
    margin-left: 20%;">महिला: {{$intro_data[0]->mahila_seats}} </h5>
                <h5 style="margin-top: -25px;
    margin-left: 30%;">दलित: {{$intro_data[0]->dalit_seats}} </h5>
                <h5 style="margin-top: -25px;
    margin-left: 40%;">पिछडीएको क्षेत्र: {{$intro_data[0]->remote_seats}} </h5>
                <h5 style="margin-top: -25px;
    margin-left: 60%;">जनजाती : {{$intro_data[0]->janajati_seats}} </h5>
        </div>
        <p>खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</p>
    </header>
    <table class="table-responsive">
        <thead>
            <tr>
                <th rowspan="2">Applicant ID</th>
                <th rowspan="2">नाम</th>
                <th rowspan="2">Name</th>
                <th colspan="2">All/Designation</th>
                <th rowspan="2">बुबा / आमा</th>
                <th rowspan="2">बाजे</th>
                <th rowspan="2">योग्यता</th>
                <th rowspan="2">तालिम</th>
                <th colspan="3"="2">अनुभब</th>
            </tr>
            <tr>
                <th>D.O.B.</th>
                <th>Address</th>
                <th>From</th>
                <th>To</th>
                <th>Org/Office</th>
            </tr>
        </thead>
        <tbody>
            @if($data) @foreach($data['candidate_data'] as $value)
            <tr>
                <td>{{$value->id}}</td>
                <td>{{$value->applicant_name}}</td>
                <td></td>
                <td>{{$value->birth_date}}</td>
                <td>{{$value->address}}</td>
                <td>{{$value->father_mother}}</td>
                <td>{{$value->grand_father}}</td>
                <td>{{$value->edu_degree}},{{$value->edu_major}}</td>
                <td>{{$value->training}}</td>
                <td>{{$value->date_from_bs}}</td>
                <td>{{$value->date_to_bs}}</td>
                <td>{{$value->working_office}}</td>
            </tr>
            @endforeach @endif
        </tbody>
    </table>
</body>

</html>