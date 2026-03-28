<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Helpers\VAARS;
use Bsdate;
use Carbon\Carbon;
use CRUDBooster;
use DateTime;
use DateTimeZone;
use DB;
use Exception;

use Schema;
use Session;
use Vinkla\Hashids\Facades\Hashids;

use Illuminate\Http\Request;

class AdminInsertAppliedApplicantDetailController extends Controller
{
    public function insertdata($id,$applicant_id)
    {

        //  dd($id,$applicant_id);
         $checkif_exist=DB::table('applied_applicant_profile')->where([['user_id',$applicant_id],['vacancy_apply_id',$id]])->first();
        //  if($checkif_exist){
        //     CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_applicants', trans("Applicant Data already existed"), 'info'); 
        //  }



         DB::beginTransaction();
          try {
            $this->take_applicant_snapshot($id,$applicant_id);
            DB::commit();
            $success = true;
            CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_applicants', trans("crudbooster.alert_update_data_success"), 'success');
           } catch (Exception $e) {
            $success = false;
            DB::rollback();
           }
           
    }

    public function take_applicant_snapshot($id,$applicant_id){
                #get applied_applicant profile data
                DB::table('applied_applicant_profile')->where([['user_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
                try {
                    $app_profile_id = DB::table('applied_applicant_profile')->insertGetId(['vacancy_apply_id' => $id]);
                    $profile = DB::table('applicant_profile')->where('id', $applicant_id)->first();

                    // dd($profile);
                    foreach ($profile as $key => $item) {
                        $value = $item;
                        $keys = $key;
                        if ($key != 'id') {
                            DB::table('applied_applicant_profile')
                                ->where('id', $app_profile_id)
                                ->update([$key => $item]);
                        }
                    }
        
                } catch (Exception $e) {
                    return false;
                }
        

  
                //cloning family info
           DB::table('applied_applicant_family_info')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
           try {
               $family = DB::table('applicant_family_info')->where('applicant_id', $applicant_id)->first();
               if ($family) {
                   $family_id = DB::table('applied_applicant_family_info')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
                   foreach ($family as $key => $item) {
                       $value = $item;
                       $keys = $key;
                       if ($key != 'id') {
                           DB::table('applied_applicant_family_info')
                               ->where('id', $family_id)
                               ->update([$key => $item]);
                       }
                   }
               }
         
           } catch (Exception $e) {
               return false;
           }
           //cloning education info
                  DB::table('applied_applicant_edu_info')->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $id]])->delete();
                  try {
                      $education = DB::table('applicant_edu_info')->where([['is_deleted',false],['applicant_id', $applicant_id]])->get();
                      if ($education) {
                          $count = DB::table('applicant_edu_info')->where([['is_deleted',false],['applicant_id', $applicant_id]])->count();
                          for ($i = 0; $i < $count; $i++) {
                              $edu = $education[$i];
                              $edu_level_id = $edu->edu_level_id;
                              $edu_degree_id = $edu->edu_degree_id;
                              $edu_id = DB::table('applied_applicant_edu_info')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id, 'edu_level_id' => $edu_level_id, 'edu_degree_id' => $edu_degree_id]);
                
                              foreach ($edu as $key => $item) {
                                  $value = $item;
                                  $keys = $key;
                                  if ($key != 'id') {
                                      DB::table('applied_applicant_edu_info')
                                          ->where('id', $edu_id)
                                          ->update([$key => $item]);
                                  }
                              }
                          }
                      }
                
                  } catch (Exception $e) {
                      return false;
                  }
         
           // //cloning experience info
                //   $experience = DB::table('applicant_exp_info')->where('applicant_id', $applicant_id)->get();
                
                //   if ($experience) {
                //       DB::table('applied_applicant_exp_info')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
                //       $count = DB::table('applicant_exp_info')->where('applicant_id', $applicant_id)->count();
                //       for ($i = 0; $i < $count; $i++) {
                //           $exp = $experience[$i];
                //           $exp_id = DB::table('applied_applicant_exp_info')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
                //           foreach ($exp as $key => $item) {
                //               $value = $item;
                //               $keys = $key;
                //               if ($key != 'id') {
                //                   DB::table('applied_applicant_exp_info')
                //                       ->where('id', $exp_id)
                //                       ->update([$key => $item]);
                //               }
                //           }
                //       }
                //   }
                
           // //cloning training certificate

                      // //cloning training info
                      $training = DB::table('applicant_training_info')->where('applicant_id', $applicant_id)->get();
  
                
                      if ($training) {
                          DB::table('applied_applicant_training_info')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
                          $count = DB::table('applicant_training_info')->where('applicant_id', $applicant_id)->count();
                          for ($i = 0; $i < $count; $i++) {
                              $exp = $training[$i];
                              $exp_id = DB::table('applied_applicant_training_info')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
                              foreach ($exp as $key => $item) {
                                  $value = $item;
                                  $keys = $key;
                                  if ($key != 'id') {
                                      DB::table('applied_applicant_training_info')
                                          ->where('id', $exp_id)
                                          ->update([$key => $item]);
                                  }
                              }
                          }
                      }
                //    
      
          $council = DB::table('applicant_council_certificate')->where('applicant_id', $applicant_id)->get();
        
          if ($council) {
              DB::table('applied_applicant_council_certificate')->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $id]])->delete();
              $count = DB::table('applicant_council_certificate')->where('applicant_id', $applicant_id)->count();
              for ($i = 0; $i < $count; $i++) {
                  $cert = $council[$i];
                  $council_id = $cert->council_id;
                  $registration_type = $cert->registration_type;
                  $council_id = DB::table('applied_applicant_council_certificate')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id, 'council_id' => $council_id, 'registration_type' => $registration_type]);
                  foreach ($cert as $key => $item) {
                      $value = $item;
                      $keys = $key;
                      if ($key != 'id') {
                          DB::table('applied_applicant_council_certificate')
                              ->where('id', $council_id)
                              ->update([$key => $item]);
                      }
                  }
              }
          }
      
         // //cloning priv_grp certificate
       
          $priv_grp = DB::table('applicant_privilege_certificate')->where('applicant_id', $applicant_id)->get();
          if ($priv_grp) {
              DB::table('applied_applicant_privilege_certificate')->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $id]])->delete();
              $count = DB::table('applicant_privilege_certificate')->where('applicant_id', $applicant_id)->count();
              for ($i = 0; $i < $count; $i++) {
                  $priv_cert = $priv_grp[$i];
                  $privilege_group_id = $priv_cert->privilege_group_id;
                  $priv_grp_id = DB::table('applied_applicant_privilege_certificate')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id, 'privilege_group_id' => $privilege_group_id]);
                  foreach ($priv_cert as $key => $item) {
                      $value = $item;
                      $keys = $key;
                      if ($key != 'id') {
                          DB::table('applied_applicant_privilege_certificate')
                              ->where('id', $priv_grp_id)
                              ->update([$key => $item]);
                      }
                  }
              }
          }
          // // //cloning service history

         $service_history = DB::table('applicant_service_history')->where('applicant_id', $applicant_id)->get();
         if ($service_history) {
             DB::table('applied_applicant_service_history')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
             $count = DB::table('applicant_service_history')->where([['is_deleted',false],['applicant_id', $applicant_id]])->count();
             for ($i = 0; $i < $count; $i++) {
                 $service = $service_history[$i];
                 $serv_hist_id = DB::table('applied_applicant_service_history')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
                 foreach ($service as $key => $item) {
                     $value = $item;
                     $keys = $key;
                     if ($key != 'id') {
                         DB::table('applied_applicant_service_history')
                             ->where('id', $serv_hist_id)
                             ->update([$key => $item]);
                     }
                 }
             }
         }
      
         // //     //cloning leave details
        //    $leave_detail = DB::table('applicant_leave_details')->where('applicant_id', $applicant_id)->get();
        //    if ($leave_detail) {
        //        DB::table('applied_applicant_leave_details')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
        //        $count = DB::table('applicant_leave_details')->where('applicant_id', $applicant_id)->count();
        //        for ($i = 0; $i < $count; $i++) {
        //            $leave = $leave_detail[$i];
        //            $apleave_id = DB::table('applied_applicant_leave_details')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
        //            foreach ($leave as $key => $item) {
        //                $value = $item;
        //                $keys = $key;
        //                if ($key != 'id') {
        //                    DB::table('applied_applicant_leave_details')
        //                        ->where('id', $apleave_id)
        //                        ->update([$key => $item]);
        //                }
        //            }
        //        }
        //    }
    }
}