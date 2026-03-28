<?php

namespace App\Traits;

use App\Models\VwVacancyPostApplicantProfile;
use Illuminate\Support\Facades\Request;

trait FilterTrait
{
  public function index(){
      $query=VwVacancyPostApplicantProfile::filter();
      $query->leftjoin('vacancy_post','vw_vacancy_post_applicant_profile.vp_id','vacancy_post.id')
            ->leftjoin('vacancy_ad','vacancy_post.vacancy_ad_id','vacancy_ad.id');
      if(Request::filled('designation')){
          $query->where('vw_vacancy_post_applicant_profile.designation_id',Request::input('designation'));
      }
      if(Request::filled('opening_type')){
          $query->where([['vacancy_ad.opening_type_id',Request::input('opening_type')],['vacancy_ad.is_deleted',false]]);
      }
      if(Request::filled('privilege_group')){
          switch (Request::input('privilege_group')){
              case(1):
                  $query->where('is_female',1);
                  break;
              case(2):
                  $query->where('is_janjati',1);
                  break;
              case(3):
                  $query->where('is_madhesi',1);
                  break;
              case(4):
                  $query->where('is_dalit',1);
                  break;
              case(5):
                  $query->where('is_handicapped',1);
                  break;
              case(6):
                  $query->where('is_remote_village',1);
                  break;
          }
      }
      if(Request::filled('fullname')){
          $query->where('applicant_name_en', 'LIKE', Request::input('fullname') . '%');
      }
      if(Request::filled('mobile')){
          $query->where('mobile', 'LIKE', Request::input('mobile') . '%');
      }
      if(Request::filled('email')){
          $query->where('email', 'LIKE', Request::input('email') . '%');
      }
      if(Request::filled('token_no')){
          $query->where('token_number',Request::input('token_no'));
      }
      if(Request::filled('applicant_id')){
          $query->where('ap_id',Request::input('applicant_id'));
      }
         return $query->leftjoin('mst_designation as md','vw_vacancy_post_applicant_profile.designation_id','md.id')
               ->leftjoin('mst_gender as mg','vw_vacancy_post_applicant_profile.gender','mg.id')
               ->select('applicant_name_en','ap_id','token_number','mobile','email','md.name_np as designation_name','mg.name_en as genderName','vacancy_post.ad_no')
               ->paginate(10)
               ->withQueryString();

  }
}