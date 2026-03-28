<div>
    @php
        $prefix = config('crudbooster.ADMIN_PATH');
        $ap_id=Hashids::encode($applicantID);
        $query = "?applicant_id=$ap_id";

    @endphp

    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li role="presentation" class="@if($page_title==='Edit Applicant Profile'|| $page_title==='Applicant Profile') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_profile/edit/{{$ap_id}}"><i class='fa fa-user'></i> - Profile</a></li>
            <li role="presentation" class="@if($page_title==='Edit Applicant Family Information'||$page_title==='Applicant Family Information') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_family_info/edit/{{ $ap_id}}/{{$query}}"><i class='fa fa-group'></i> - Family Details</a></li>
            <li role="presentation" class="@if($page_title==='Education Information') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_edu_info/{{$query}}"><i class='fa fa-graduation-cap'></i> - Education</a></li>
            <li role="presentation" class="@if($page_title==='Training Information') {{ 'active' }} @endif"><a href="/{{$prefix}}/user_training_info{{$query}}"><i class='fa fa-cogs'></i> - Training</a></li>
            <li role="presentation" class="@if($page_title==='Applicant Experience') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_exp_info{{$query}}"><i class='fa fa-book'></i> - Experience</a></li>
            <li role="presentation" class="@if($page_title==='Applicant Council Certificate') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_council_certificate{{$query}}"><i class='fa fa-institution'></i> - Council</a></li>
            <li role="presentation" class="@if($page_title==='Applicant Privilege Group Certificate') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_privilege_certificate{{$query}}"><i class='fa fa-user-secret'></i> - Privilege Group</a></li>
            @if($checkNtStaff===true)
{{--                 <li role="presentation" class="@if($page_title==='Applicant Leave Details') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_leave_detail{{$query}}"><i class='fa fa-plane'></i> - Leave Details</a>
                </li> --}}
                <li role="presentation" class="@if($page_title==='Applicant Service History') {{ 'active' }} @endif"><a href="/{{$prefix}}/applicant_service_history{{$query}}"><i class='fa fa-folder'></i> - Service History</a></li>
            @endif
        </ul>
    </div>
</div>

