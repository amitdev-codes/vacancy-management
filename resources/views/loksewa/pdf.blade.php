<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 PDF File Download using JQuery Ajax Request Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
        <div class="panel panel-primary">
            <div class="panel-body">
                    <div class="box box-solid box-primary">
                        <table class="table-responsive table-striped table-bordered table nepali_td">
                                <thead>
                                <tr>
                                    <th>S.NO</th>
                                    <th>Roll</th>
                                    <th>Applicant Name</th>
                                    <th>Gender</th>
                                    <th>Photo</th>
                                    <th>Signature</th>
                                    <th>Token No.</th>
                                    <th>Applicant ID</th>
                                    <th>Citizenship No/District</th>
                                    <th colspan="7">Privileged group</th>
                                    </th>
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
                                    <th>Open</th>
                                    <th>Female</th>
                                    <th>Janajati</th>
                                    <th>Madhesi</th>
                                    <th>Dalit</th>
                                    <th>Handicapped </th>
                                    <th>Remote</th>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidate_data as $value)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$value->exam_roll_no}}</td>
                                            <td>{{$value->full_name}}</td>
                                            <td>{{$value->gender}}</td>
                                            <td><image src="{{asset($value->photo)}}"></image></td>
                                            <td><image src="{{asset($value->signature)}}"></image></td>
                                            <td>{{$value->token_number}}</td>
                                            <td>{{$value->applicant_id}}</td>
                                            <td>{{$value->citizenship_no}}/{{$value->citizenship_district}}</td>
                                            <td>{{$value->is_open}}</td>
                                            <td>{{$value->is_female}}</td>
                                            <td>{{$value->is_janajati}}</td>
                                            <td>{{$value->is_madhesi}}</td>
                                            <td>{{$value->is_dalit}}</td>
                                            <td>{{$value->is_handicapped}}</td>
                                            <td>{{$value->is_remote_village}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
        </div>
</body>
</html>