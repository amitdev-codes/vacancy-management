<div class="box box-solid box-primary" style="overflow-x:auto;">


    <table class="table-responsive table-striped table-bordered table nepali_td" id="candidates">
        <thead>
        <tr>
            <th colspan="17" style="text-align:center"><b>नेपाल टेलिकम</b></th>
        </tr>
        <tr>
            <th colspan="17" style="text-align:center"><b>पदपूर्ति सचिबालय</b></th>
        </tr>
        <tr>
            <th colspan="17" ><b>विज्ञापन: {{$intro_data[0]->ad_no}}</b></th>
        </tr>
        <tr>
            <th colspan="7" ><b>पद: {{$intro_data[0]->designation}}</b></th>
            <th colspan="10"><b>तह: {{$intro_data[0]->work_level}}</b></th>
        </tr>
        <tr>
            <th colspan="2"><b>पद संख्या: {{$intro_data[0]->total_req_seats}}</b></th>
            <th colspan="2"><b>खुल्ला:{{$intro_data[0]->open_seats}}</b></th>
            <th colspan="2"><b>महिला:{{$intro_data[0]->mahila_seats}}</b></th>
            <th colspan="2"><b>जनजाती : {{$intro_data[0]->janajati_seats}}</b></th>
            <th colspan="2"><b>मधेशी :{{$intro_data[0]->madheshi_seats}}</b></th>
            <th colspan="2"><b>दलित:{{$intro_data[0]->dalit_seats}}</b></th>
            <th colspan="2"><b>अपाङ्ग :{{$intro_data[0]->apanga_seats}}</b></th>
            <th colspan="2"><b>पिछडीएको क्षेत्र:{{$intro_data[0]->remote_seats}}</b></th>
        </tr>
        <tr>
            <th colspan="17" style="text-align:center"><b>खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली</b></th>
        </tr>
        <tr>
            <th>S.NO</th>
            <th>Roll</th>
            <th>Applicant ID</th>
            <th>Nt Staff Code</th>
            <th class="nepali_td">नाम</th>
            <th>Name</th>
            <th>D.O.B.</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Father/ Mother</th>
            <th class="nepali_td">बुबा / आमा</th>
            <th class="nepali_td">GrandFather</th>
            <th class="nepali_td">बाजे</th>
            <th>योग्यता</th>
            <th>अनुभब</th>
            <th>तालिम</th>
            <th>NT Staff</th>
            <th>खुल्ला</th>
            <th>महिला</th>
            <th>मधेशी</th>
            <th>जनजाती</th>
            <th>दलित</th>
            <th>पिछडिएको</th>
            <th>Token No.</th>
            <th>Total Amount</th>
            <th>Paid Amount</th>
            <th>Receipt no</th>
            <th>Paid Date(AD)</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Remarks</th>
        </tr>

        </thead>
        <tbody>
        @forelse($applicantData->chunk(100) as  $apdata)
            @foreach($apdata as $value)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->roll}}</td>
                    <td>{{$value->ap_id}}</td>
                    <td>{{$value->nt_staff_code}}</td>
                    <td class="nepali_td">{{$value->applicant_name_np}}</td>
                    <td>{{$value->applicant_name_en}}</td>
                    <td>{{$value->date_of_birth}}</td>
                    <td>{{$value->gender}}</td>
                    <td>{{$value->address}}</td>
                    <td class="nepali_td">{{$value->father_mother}}</td>
                    <td class="nepali_td">{{$value->father_mother_np}}</td>
                    <td class="nepali_td">{{$value->grand_father}}</td>
                    <td class="nepali_td">{{$value->grand_father_np}}</td>
                    <td>
{{--                        @foreach($educationData[$value->ap_id] as $key=>$ap_edu_data)--}}
{{--                            @php--}}
{{--                                $merged_data=$ap_edu_data->edu_degree;--}}
{{--                                $applicant_edu_data[]=	$merged_data;--}}
{{--                                echo nl2br($merged_data."\n");--}}
{{--                            @endphp--}}
{{--                        @endforeach--}}
                    </td>

                        <td>
{{--                            @php--}}
{{--                                for($i=0; $i<count($expereince_data[$value->ap_id]); $i++){--}}
{{--                                  echo $expereince_data[$value->ap_id][$i].'</br>';--}}
{{--                              }--}}
{{--                            @endphp--}}
                        </td>
                    <td>{{$training_data[$value->ap_id]}}</td>
                    <td>{{($value->nt_staff==true)?'YES':'NO'}}</td>
                    <td>{{($value->is_open==true)?'YES':'NO'}}</td>
                    <td>{{($value->is_female==true)?'YES':'NO'}}</td>
                    <td>{{($value->is_madhesi==true)?'YES':'NO'}}</td>
                    <td>{{($value->is_janajati==true)?'YES':'NO'}}</td>
                    <td>{{($value->is_dalit==true)?'YES':'NO'}}</td>
                    <td>{{($value->is_remote_village==true)?'YES':'NO'}}</td>
                    <td>{{($value->token_number)?$value->token_number:'NA'}}</td>
                    <td>{{($value->total_amount)?$value->total_amount:'NA'}}</td>
                    <td>{{($value->total_paid_amount)?$value->total_paid_amount:'NA'}}</td>
                    <td>{{$value->paid_receipt_no}}</td>
                    <td>{{($value->paid_date_ad)?$value->paid_date_ad:'NA'}}</td>
                    <td>{{($value->email)?$value->email:'NA'}}</td>
                    <td>{{($value->mobile)?$value->mobile:'NA'}}</td>
                    <td></td>
                </tr>
            @endforeach
        @empty
            <p>No users</p>
        @endforelse
        </tbody>
    </table>
</div>
