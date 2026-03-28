 <html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
    th {text-align: center;}
    thead {background-color: #3B72A0 !important;color: #fff;display: table-header-group}
    tfoot { display: table-row-group }
    tr { page-break-inside: avoid }
    tbody {background-color: #d0d0d0;color: black;}
    /* @font-face { font-family: "mangal";  src: url({{ storage_path('app/fonts/mangal.ttf') }})  format("truetype"); } */
    body {  font-family: "mangal"; font-size: 36px; text-align: justify; }
</style>
</head>
<body class="main">
      <div class="box">
        <div class="box-header nepali_td"><p><b>जेष्ठता,भौगोलिक,का. प्र. तथा योग्यता वापतको अंक गणनाको विवरण (अवधि @php
            echo $fiscal_year[0]->code;
            @endphp आषाढ़ मसान्तसम्म)</b></p>
        </div>
    <div class="box box-solid box-primary" style="overflow-x:auto;">
        <table class="table-responsive table-striped table-bordered table" id="candidates">
            <thead>
                <tr>
                <th>सि.नं.</th>
                <th>Service/Education</th>
                <th>Report</th>
                <th>टोकन नं.</th>
                <th>क.द.नं.</th>
                <th>लिंग</th>
                <th>कर्मचरीको नाम</th>
                <th>जेष्ठता मिति (yyyy/mm/dd)</th>
                <th>जेष्ठता बापतको अंक </th>
                <th>भौगलिक अंक</th>
                <th>का.प्र.बापतको अंक</th>
                <th>शैक्षिक योग्यताको अंक</th>
                <th>जम्मा अंक</th>
                <th colspan="2">न्युनतम शैक्षिक योग्यता</th>
                <th colspan="2">थप शैक्षिक योग्यता</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>उपाधि</th>
                <th>श्रेणी</th>
                <th>उपाधि </th>
                <th>श्रेणी</th>
            </tr>
            </thead>

            <tbody>
                @if($candidate_data)
                 @foreach ($candidate_data as $key=>$value)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->status}}</td>
                    <td><a class="btn btn-xs btn-primary"
                            href="/app/individual_evaluation/{{$value->token_number}}?sn={{$value->rn}}"><i
                                class="fa fa-eye"></i>
                        </a></td>
                    <td>{{$value->token_number}}</td>
                    <td>{{$value->nt_staff_code}}</td>
                    <td>{{$value->gender}}</td>
                    <td>{{$value->applicant_name_np}}</td>
                    <td>{{$value->seniority_date_bs}}</td>
                    <td>{{$value->seniority_marks}}</td>
                    <td>{{$value->geographical_marks}}</td>
                    <td>{{$value->incharge_marks}}</td>
                    <td>{{$value->qualification_marks}}</td>
                    <td>{{$value->total_marks}}</td>
                    <td>{{$value->minimum_qualification_degree}}</td>
                    <td>{{$value->minimum_qualification_division}}</td>
                    <td>{{$value->additional_qualification_degree}}</td>
                    <td>{{$value->additional_qualification_division}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="17" style="color:#0035ff;"align="center"><b>!!! कुनै पनि तथायंक फेला परेन !!!! </b>
                </tr>
             @endif
            </tbody>
            </tbody>
        </table>
    </div>

</body>
</html>