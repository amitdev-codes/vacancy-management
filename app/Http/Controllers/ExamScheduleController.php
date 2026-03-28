<?php

namespace App\Http\Controllers;

use DB;
use App;
use PDF;
use Schema;
use Request;
use Session;
use DateTime;
use App\Helpers;
use CRUDBooster;
use Carbon\Carbon;
use App\Models\VacancyPost;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ExamScheduleController extends BaseCBController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = false;
        $this->button_delete = true;
        $this->button_detail = false;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "vacancy_post";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        # END FORM DO NOT REMOVE THIS LINE
    }

    // public function getIndex()
    // {
    //     $this->cbLoader();
    //     $this->table = "vacancy_post";
    //     $this->alias = "vacancy_post";
    //     return parent::getIndex();
    // }

    // public function getAdd($ad_id)
    // {
    // }
    public function illuminatiColToArray($arr = [], $column_name)
    {

        $concatedID = "(";
        foreach ($arr as $arr) {
            $concatedID = $concatedID . $arr->$column_name . ',';
        }
        $concatedID = substr($concatedID, 0, -1) . ')';
        return $concatedID;

    }

    public function updateCenter($id)
    {
        ini_set('max_execution_time', 300);
        $vacancy_post = DB::table('exam_center_setting')
            ->select('vacancy_post_id')
            ->where('id', $id)
            ->first();
        $Group_id = DB::table('vacancy_exam_group_child')
            ->select('vacancy_exam_group_id')
            ->where('vacancy_post_id', $vacancy_post->vacancy_post_id)
            ->first();
        $Posts = DB::table('vacancy_exam_group_child')
            ->select('vacancy_post_id')
            ->leftjoin('vacancy_post', 'vacancy_post.id', '=', 'vacancy_exam_group_child.vacancy_post_id')
            ->where('vacancy_exam_group_id', $Group_id->vacancy_exam_group_id)
            ->orderBy('vacancy_post.ad_no')
            ->get();

        $group_post_id = $this->illuminatiColToArray($Posts, 'vacancy_post_id');

        if (count($Posts) > 1) {
            foreach ($Posts as $ps) {
                $center_setting = DB::table('exam_center_setting')
                    ->select('id', 'paper_id')
                    ->where('vacancy_post_id', $ps->vacancy_post_id)
                    ->get();
                foreach ($center_setting as $cs) {
                    $paper_exam_center = DB::table('paper_exam_centers')
                        ->where('esc_id', $cs->id)
                        ->get();
                    DB::table('vacancy_exam')
                        ->where('paper_id', $cs->paper_id)
                        ->update(['exam_center' => null]);
                    $paper_name = DB::table('vacancy_post_paper')
                        ->select('paper_name_en')
                        ->where('id', $cs->paper_id)->first();
                    foreach ($paper_exam_center as $pec) {
                        $center_id = $pec->center_id;
                        $candidate_number = $pec->max_candidates;
                        $vacancy_exam = DB::table('vacancy_exam')
                            ->where([['paper_id', $cs->paper_id], ['exam_center', null]])
                            ->limit($candidate_number)
                            ->get();
                        foreach ($vacancy_exam as $ve) {
                            $sql = "select * from vacancy_exam where applicant_id=" . $ve->applicant_id . " and vacancy_post_id in " . $group_post_id . " and exam_center is not null";
                            // if already assigned to group exam assigned the same exam center for first paper
                            $isAldreadyAssigned = DB::select(DB::raw($sql));
                            if ($isAldreadyAssigned) {
                                if (strpos($paper_name->paper_name_en, 'First') !== false || strpos($paper_name->paper_name_en, 'first') !== false) {
                                    DB::table('vacancy_exam')
                                        ->where('id', $ve->id)
                                        ->update(['exam_center' => $isAldreadyAssigned[0]->exam_center]);
                                } else {
                                    //check roll number lies in which center
                                    if (isset($pec->roll_start) && isset($pec->roll_end))
                                        $this->updateCenterAccordingToRoll($ve->id);
                                    else
                                        DB::table('vacancy_exam')->where('id', $ve->id)->update(['exam_center' => $center_id]);
                                }
                            } else {
                                if (isset($pec->roll_start) && isset($pec->roll_end))
                                    $this->updateCenterAccordingToRoll($ve->id);
                                else
                                    DB::table('vacancy_exam')->where('id', $ve->id)->update(['exam_center' => $center_id]);
                            }

                        }

                    }


                }

            }


            CRUDBooster::redirect(CRUDBooster::adminPath() . '/exam_center_setting', trans("Exam Center Updated."), 'success');
        } else {

            $AssignedCenters = DB::table('paper_exam_centers')
                ->where('esc_id', $id)
                ->get();
            $paper_id = DB::table('exam_center_setting')
                ->select('paper_id')
                ->where('id', $id)
                ->first();
            //updating vacancy exam exam center to null to the paper id
            DB::table('vacancy_exam')
                ->where('paper_id', $paper_id->paper_id)
                ->update(['exam_center' => null]);

            // assigning the center according to paper_exam_centers
            foreach ($AssignedCenters as $AC) {
                $center_id = $AC->center_id;
                $candidate_number = $AC->max_candidates;
                $vacancy_exam = DB::table('vacancy_exam')
                    ->where([['paper_id', $paper_id->paper_id], ['exam_center', null]])
                    ->limit($candidate_number)
                    ->get();
                foreach ($vacancy_exam as $ve) {
                    DB::table('vacancy_exam')
                        ->where('id', $ve->id)
                        ->update(['exam_center' => $center_id]);
                }
            }
            CRUDBooster::redirect(CRUDBooster::adminPath() . '/exam_center_setting', trans("Exam Center Updated."), 'success');
        }

    }

    public function updateCenterAccordingToRoll($ve_id)
    {
        $vacancy_exam = DB::table('vacancy_exam')->where('id', $ve_id)->first();
        $ecs_setting = DB::table('exam_center_setting')->where('paper_id', $vacancy_exam->paper_id)->first();
        $exam_centers = DB::table('paper_exam_centers')->where('esc_id', $ecs_setting->id)->get();
        foreach ($exam_centers as $ec) {
            if ($vacancy_exam->exam_roll_no >= $ec->roll_start && $vacancy_exam->exam_roll_no <= $ec->roll_end) {
                DB::table('vacancy_exam')->where('id', $ve_id)->update(['exam_center' => $ec->center_id]);
            }
        }
    }

    public function getSchedule($id)
    {

        $posts = DB::table('vacancy_exam_group_child')->select('vacancy_post_id')->whereVacancy_exam_group_id($id)->get();
        $count_post = $posts->count();

        // dd($count_post);

        if ($count_post > 1) {
            $vacancy_data = array();
            $exam_center_data = array();
            $exam_details_data = array();
            $designation_id = array();
            foreach ($posts as $p) {
                $vacancy_data[] = $this->getVacancyDetail($p->vacancy_post_id);
       
                $exam_center_data[] = DB::table('mst_exam_centre')->get();
                $exam_details_data[] = $this->getExamDetail($p->vacancy_post_id);
            }

            if (Session::get("is_applicant")) {
                CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
            } else {
                // dd($vacancy_data);
                $this->cbView('exam.schedulegroupwise', ['vacancy_data' => $vacancy_data,'exam_group_id'=>$id, 'paper_data' => $paper_data, 'exam_center_data' => $exam_center_data, 'exam_details_data' => $exam_details_data]);
            }
        } else {
            $vacancy_data = $this->getVacancyDetail($posts[0]->vacancy_post_id);
            $exam_center_data = DB::table('mst_exam_centre')->get();
            $exam_details_data = $this->getExamDetail($posts[0]->vacancy_post_id);
            $designation_id = $vacancy_data->post_id;
            $paper_data = $this->getExamPapers($designation_id);
            if (Session::get("is_applicant")) {
                CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
            } else {

                // dd($vacancy_data,$id,$paper_data);
                $this->cbView('exam.schedule', ['vacancy_data' => $vacancy_data,'exam_group_id'=>$id,  'paper_data' => $paper_data, 'exam_center_data' => $exam_center_data, 'exam_details_data' => $exam_details_data]);
            }
        }
    }


    public function getEdit($id)
    {

        // $roll = $this->generateRollNo($id);

        $data['page_title'] = 'Application Edit';

        $vacancy_data = $this->getVacancyDetail($id);

        // dd($vacancy_data);

        $exam_center_data = DB::table('mst_exam_centre')->get();

        $exam_details_data = $this->getExamDetail($id);

        // dd($exam_details_data);

        //$data = collect($vacancy_data);
        // dd();

        $designation_id = $vacancy_data->post_id;

        $paper_data = $this->getExamPapers($designation_id);

        //$data = $data->merge($paper_data)->all();

        // dd($paper_data);

        if (Session::get("is_applicant")) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        } else {
            $this->cbView('exam.schedule', ['vacancy_data' => $vacancy_data, 'paper_data' => $paper_data, 'exam_center_data' => $exam_center_data, 'exam_details_data' => $exam_details_data]);
        }
    }

    // public function cbView($template,$data) {
    //     $this->cbLoader();
    //     echo view($template,$data);
    // }

    public function postEditSave($id)
    {

        $data = $this->getVacancyDetail($id);
        $data['page_title'] = 'Application Edit';

        if (Session::get("is_applicant")) {
            return CRUDBooster::redirect(CRUDBooster::mainpath('edit/' . $id), trans('crudbooster.denied_access'));
        }
        return parent::postEditSave($id);
    }

    private function getVacancyDetail($id)
    {
        $vacancy_post_id = intval($id);
        $data = DB::table('vacancy_post as vp')
            ->select('vp.id', 'vp.mahila_seats', 'vp.janajati_seats', 'vp.madheshi_seats', 'vp.dalit_seats', 'vp.apanga_seats', 'vp.remote_seats', 'vp.ad_no', 'vp.roll_prefix', 'vp.roll_start_value', 'va.ad_title_en as ad_title', 'd.id as post_id', 'd.name_en as post',
                'vp.id as vacancy_post_id', 'va.date_to_publish_bs as publish_date_bs', 'va.date_to_publish_ad as publish_date_ad',
                'va.last_date_for_application_bs as last_date_bs', 'va.last_date_for_application_ad as last_date_ad',
                'va.vacancy_extended_date_bs as last_ext_date_bs', 'va.vacancy_extended_date_ad as last_ext_date_ad')
            ->leftJoin('vacancy_ad as va', 'va.id', '=', 'vp.vacancy_ad_id')
            ->leftJoin('mst_designation as d', 'd.id', '=', 'vp.designation_id')
            ->leftJoin('mst_work_level as wl', 'wl.id', '=', 'd.work_level_id')
            ->where([['vp.id', '=', $vacancy_post_id], ['vp.is_deleted', false]])
            ->first();
        return $data;
    }

    private function getExamPapers($designation_id)
    {
        // $vacancy_post_id = intval($id);
        //  $data = $this->getVacancyDetail($vacancy_post_id);
        //  $designation_id = $data->post_id;
        $data = DB::table('designation_paper')
            ->select('name_en as paper_name')
            ->where('designation_id', '=', $designation_id)
            ->get();
        return $data;
    }
    public function generateRollNoGroupwise($posts = [])
    {
        $vacancy_data = $this->getVacancyDetail($posts[0]->vacancy_post_id);
        $roll_prefix = $vacancy_data->roll_prefix;
    
        $group_posts = $posts->toArray();
        $combined_posts = array_column($group_posts, 'vacancy_post_id');
        // dd($internal_post_id,$external_post_id);
            // Get internal posts
            $internal_posts = VacancyPost::whereIn('id', $combined_posts)
                                        ->where('internal', 1)
                                        ->pluck('id');
            $external_posts = VacancyPost::whereIn('id', $combined_posts)
                                        ->whereNull('internal')
                                        ->pluck('id');
            $internal_post_id = $internal_posts->first();
            $external_post_id = $external_posts->first();

        foreach ($posts as $ps) {
            DB::table('vacancy_exam')->where('vacancy_post_id', '=', $ps->vacancy_post_id)->delete();
        }
    
        $query = DB::table('vw_vacancy_applicant as va')
            ->select(
                'va.applicant_id',
                'va.name_en as full_name_en',
                'va.vacancy_post_id',
                'va.designation_id',
                'vp.exam_centre_id',
                'va.id as vacancy_apply_id'
            )
            ->leftJoin('vacancy_post as vp', 'vp.id', '=', 'va.vacancy_post_id')
            ->where('va.is_paid', 1)
            // ->whereNull('va.is_rejected')
            ->whereIn('va.vacancy_post_id', $combined_posts)
            ->where('va.fiscal_year_id',Session::get('fiscal_year_id'))
            ->orderBy('va.ad_no')
            ->get();

            // dd($query,$combined_posts);
    
        // Categorize applicants
        $both_applicants = [];
        $internal_only = [];
        $external_only = [];
        $applicant_posts = [];
    
        foreach ($query as $value) {
            if (!isset($applicant_posts[$value->applicant_id])) {
                $applicant_posts[$value->applicant_id] = [];
            }
            $applicant_posts[$value->applicant_id][] = $value->vacancy_post_id;
        }

        // dd($applicant_posts);
    
        foreach ($applicant_posts as $applicant_id => $posts) {
            if (count($posts) > 1) {
                $both_applicants[] = $applicant_id;
            } elseif ($posts[0] == $internal_post_id) {
                $internal_only[] = $applicant_id;
            } else {
                $external_only[] = $applicant_id;
            }
        }

        // dd($external_only);
    
        // Generate roll numbers
        $applicantRollMap = [];
        $roll_start_value = 1;

        // Assign roll numbers to internal-only applicants
        // $internal_start = $combined_count + 1;
        // $internal_max = $combined_count + count($internal_only);

        foreach ($internal_only as $applicant_id) {
            $applicantRollMap[$applicant_id] = $roll_start_value;
            $roll_start_value++;
        }
        
        // Assign roll numbers to applicants who applied for both
        foreach ($both_applicants as $applicant_id) {
            $applicantRollMap[$applicant_id] =$roll_start_value;
            $roll_start_value++;
        }


        // Assign roll numbers to external-only applicants
        foreach ($external_only as $applicant_id) {
            $applicantRollMap[$applicant_id] = $roll_start_value;
            $roll_start_value++;
        }


        // Insert roll numbers
        foreach ($query as $value) {
            $papers = DB::table('vacancy_post_paper')
                ->select('id')
                ->where('vacancy_post_id', $value->vacancy_post_id)
                ->get();
            $roll = $applicantRollMap[$value->applicant_id];
            foreach ($papers as $ppr) {
                DB::table('vacancy_exam')->insert([
                    'paper_id' => $ppr->id,
                    'vacancy_apply_id' => $value->vacancy_apply_id,
                    'applicant_id' => $value->applicant_id,
                    'vacancy_post_id' => $value->vacancy_post_id,
                    'designation_id' => $value->designation_id,
                    'exam_roll_no' => $roll
                ]);
            }
        }
    
        CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Roll Numbers Generated."), 'success');
    }
    //with prefix enabled and ordering.
    // public function generateRollNoGroupwise($posts = [])
    // {
    //     $vacancy_data = $this->getVacancyDetail($posts[0]->vacancy_post_id);
    //     $roll_prefix = $vacancy_data->roll_prefix;
    
    //     $group_posts = $posts->toArray();
    //     $combined_posts = array_column($group_posts, 'vacancy_post_id');

     
    //     // VacancyPost::whereIn('id',[$combined_posts])->where('internal',1)->value()
    
    //     // // Assuming the first post is internal and the second is external
    //     // $internal_post_id = $combined_posts[0];
    //     // $external_post_id = $combined_posts[1];

    //     // dd($internal_post_id,$external_post_id);
    //         // Get internal posts
    //         $internal_posts = VacancyPost::whereIn('id', $combined_posts)
    //                                     ->where('internal', 1)
    //                                     ->pluck('id');

    //         // Get external posts
    //         $external_posts = VacancyPost::whereIn('id', $combined_posts)
    //                                     ->whereNull('internal')
    //                                     ->pluck('id');

    //         // Assuming the first internal post and the first external post
    //         $internal_post_id = $internal_posts->first();
    //         $external_post_id = $external_posts->first();


    //         // dd($internal_post_id,$external_post_id);



    
    //     foreach ($posts as $ps) {
    //         DB::table('vacancy_exam')->where('vacancy_post_id', '=', $ps->vacancy_post_id)->delete();
    //     }
    
    //     $query = DB::table('vw_vacancy_applicant as va')
    //         ->select(
    //             'va.applicant_id',
    //             'va.name_en as full_name_en',
    //             'va.vacancy_post_id',
    //             'va.designation_id',
    //             'vp.exam_centre_id',
    //             'va.id as vacancy_apply_id'
    //         )
    //         ->leftJoin('vacancy_post as vp', 'vp.id', '=', 'va.vacancy_post_id')
    //         ->where('va.is_paid', 1)
    //         // ->whereNull('va.is_rejected')
    //         ->whereIn('va.vacancy_post_id', $combined_posts)
    //         ->where('va.fiscal_year_id',Session::get('fiscal_year_id'))
    //         ->orderBy('va.ad_no')
    //         ->get();

    //         // dd($query,$combined_posts);
    
    //     // Categorize applicants
    //     $both_applicants = [];
    //     $internal_only = [];
    //     $external_only = [];
    //     $applicant_posts = [];
    
    //     foreach ($query as $value) {
    //         if (!isset($applicant_posts[$value->applicant_id])) {
    //             $applicant_posts[$value->applicant_id] = [];
    //         }
    //         $applicant_posts[$value->applicant_id][] = $value->vacancy_post_id;
    //     }

    //     // dd($applicant_posts);
    
    //     foreach ($applicant_posts as $applicant_id => $posts) {
    //         if (count($posts) > 1) {
    //             $both_applicants[] = $applicant_id;
    //         } elseif ($posts[0] == $internal_post_id) {
    //             $internal_only[] = $applicant_id;
    //         } else {
    //             $external_only[] = $applicant_id;
    //         }
    //     }

    //     // dd($external_only);
    
    //     // Generate roll numbers
    //     $applicantRollMap = [];
    //     $roll_start_value = 1;
        
        
    //     // Assign roll numbers to applicants who applied for both
    //     foreach ($both_applicants as $applicant_id) {
    //         $roll_prefix='IOP';
    //         $applicantRollMap[$applicant_id] = $roll_prefix . $roll_start_value;
    //         $roll_start_value++;
    //     }
    
    //     $combined_count = count($both_applicants);
    
    //     // Assign roll numbers to internal-only applicants
    //     $internal_start = $combined_count + 1;
    //     $internal_max = $combined_count + count($internal_only);
    //     foreach ($internal_only as $applicant_id) {
    //         $roll_prefix='I';
    //         $applicantRollMap[$applicant_id] = $roll_prefix . $internal_start;
    //         $internal_start++;
    //         if ($internal_start > $internal_max) break;
    //     }
    
    //     // Assign roll numbers to external-only applicants
    //     $external_start = $combined_count + 1;
    //     $external_max = $combined_count + count($external_only);
    //     foreach ($external_only as $applicant_id) {
    //         $roll_prefix='OP';
    //         $applicantRollMap[$applicant_id] = $roll_prefix . $external_start;
    //         $external_start++;
    //         if ($external_start > $external_max) break;
    //     }
    
    //     // Insert roll numbers
    //     foreach ($query as $value) {
    //         $papers = DB::table('vacancy_post_paper')
    //             ->select('id')
    //             ->where('vacancy_post_id', $value->vacancy_post_id)
    //             ->get();
    //         $roll = $applicantRollMap[$value->applicant_id];
    //         foreach ($papers as $ppr) {
    //             DB::table('vacancy_exam')->insert([
    //                 'paper_id' => $ppr->id,
    //                 'vacancy_apply_id' => $value->vacancy_apply_id,
    //                 'applicant_id' => $value->applicant_id,
    //                 'vacancy_post_id' => $value->vacancy_post_id,
    //                 'designation_id' => $value->designation_id,
    //                 'exam_roll_no' => $roll
    //             ]);
    //         }
    //     }
    
    //     CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Roll Numbers Generated."), 'success');
    // }














    // public function generateRollNoGroupwise($posts = [])
    // {
    //     $vacancy_data = $this->getVacancyDetail($posts[0]->vacancy_post_id);
    //     $roll_prefix = $vacancy_data->roll_prefix;
    //     $roll_start_value = $vacancy_data->roll_start_value;

    //     $group_posts=$posts->toArray();
    //     foreach($group_posts as $gp){
    //         $combined_posts[]=$gp->vacancy_post_id;
    //     }
    //     foreach ($posts as $ps) {
    //         DB::table('vacancy_exam')->where('vacancy_post_id', '=', $ps->vacancy_post_id)->delete();
    //     }
    //     $query = DB::table('vw_vacancy_applicant as va')
    //     ->select(
    //         'va.applicant_id',
    //         'va.name_en as full_name_en',
    //         'va.vacancy_post_id',
    //         'va.designation_id',
    //         'vp.exam_centre_id',
    //         'va.id as vacancy_apply_id'
    //     )
    //     ->leftJoin('vacancy_post as vp', 'vp.id', '=', 'va.vacancy_post_id')
    //     ->where('va.is_paid', 1)
    //     ->where('va.is_rejected', 0)
    //     ->whereIn('va.vacancy_post_id', $combined_posts)
    //     ->orderBy('va.ad_no')
    //     ->get();

    //     // dd($query);

    //     // Create a mapping of applicants to their roll numbers
    //     $applicantRollMap = [];
    //     foreach ($query as $value) {
    //         if (!isset($applicantRollMap[$value->applicant_id])) {
    //             $alreadyAssigned = $this->checkIfAlreadyAssigned($value->applicant_id, $value->vacancy_post_id);
    //             if ($alreadyAssigned) {
    //                 $applicantRollMap[$value->applicant_id] = $alreadyAssigned[1];
    //             } else {
    //                 $applicantRollMap[$value->applicant_id] = $roll_prefix . $roll_start_value;
    //                 $roll_start_value++;
    //             }
    //         }
    //     }

    //     // Insert roll numbers
    //     foreach ($query as $value) {
    //         $papers = DB::table('vacancy_post_paper')
    //             ->select('id')
    //             ->where('vacancy_post_id', $value->vacancy_post_id)
    //             ->get();
    //         $roll = $applicantRollMap[$value->applicant_id];
    //         foreach ($papers as $ppr) {
    //             DB::table('vacancy_exam')->insert([
    //                 'paper_id' => $ppr->id,
    //                 'vacancy_apply_id' => $value->vacancy_apply_id,
    //                 'applicant_id' => $value->applicant_id,
    //                 'vacancy_post_id' => $value->vacancy_post_id,
    //                 'designation_id' => $value->designation_id,
    //                 'exam_roll_no' => $roll
    //             ]);
    //         }
    //     }
    //     CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Roll Numbers Generated."), 'success');
    // }

    // public function generateRollNoGroupwise($posts = [])
    // {

    //    // dd('singledfdg',$posts);

    //     $vacancy_data = $this->getVacancyDetail($posts[0]->vacancy_post_id);
    //     $roll_prefix = $vacancy_data->roll_prefix;
    //     $roll_start_value = $vacancy_data->roll_start_value;

    //     $concatedID = "(";
    //     foreach ($posts as $ps) {
    //         $concatedID = $concatedID . $ps->vacancy_post_id . ',';
    //     }


    //     $concatedID = substr($concatedID, 0, -1) . ')';
    //     $newconcatedID = str_replace(array('(', ')'), '', $concatedID);

    //     // dd($newconcatedID);

    //     $row = DB::statement(DB::raw('SET @row :=' . $roll_start_value . ''));


    //     $query = DB::select('select t.*
    //     from (
    //     SELECT
    //         va.applicant_id,
    //                    concat(
    //        upper( `ap`.`first_name_en` ),
    //        \' \',
    //        upper( COALESCE ( `ap`.`mid_name_en`, \'\' ) ),
    //        \' \',
    //        upper( `ap`.`last_name_en` )
    //        ) AS full_name_en,
    //         va.vacancy_post_id,
    //         va.designation_id,
    //         vp.exam_centre_id,
    //         va.id AS vacancy_apply_id
    //     FROM
    //         vacancy_apply va
    //         LEFT JOIN applicant_profile ap ON ap.id = va.applicant_id
    //         LEFT JOIN vacancy_post vp ON vp.id = va.vacancy_post_id
    //     WHERE
    //         is_paid =:is_paid and is_rejected =:is_rejected
    //     AND vacancy_post_id in ' . $concatedID . '
    //     ORDER BY ad_no,full_name_en
    //     ) t', ['is_paid' => 1, 'is_rejected' => 0]);


    //     // Delete old data
    //     foreach ($posts as $ps) {
    //         DB::table('vacancy_exam')->where('vacancy_post_id', '=', $ps->vacancy_post_id)->delete();

    //     }

    //     // dd("$roll_prefix"."$roll_start_value");

    //     //Insert roll no.
    //     foreach ($query as $value) {
    //         $papers = DB::table('vacancy_post_paper')
    //             ->select('id')
    //             ->where('vacancy_post_id', $value->vacancy_post_id)
    //             ->get();

             
    //         $alreadyAssigned = $this->checkIfAlreadyAssigned($value->applicant_id, $value->vacancy_post_id);
    //         foreach ($papers as $ppr) {
    //             if ($alreadyAssigned) {
    //                 // dd($alreadyAssigned);
    //                 DB::table('vacancy_exam')->insert(array('paper_id' => $ppr->id, 'vacancy_apply_id' => $value->vacancy_apply_id, 'applicant_id' => $value->applicant_id, 'vacancy_post_id' => $value->vacancy_post_id, 'designation_id' => $value->designation_id, 'exam_roll_no' => $alreadyAssigned[1]));
    //             } else {
    //                 $roll = "$roll_prefix" . "$roll_start_value";
    //                 DB::table('vacancy_exam')->insert(array('paper_id' => $ppr->id, 'vacancy_apply_id' => $value->vacancy_apply_id, 'applicant_id' => $value->applicant_id, 'vacancy_post_id' => $value->vacancy_post_id, 'designation_id' => $value->designation_id, 'exam_roll_no' => $roll));

    //             }
    //         }
    //         // dd($alreadyAssigned);
    //         if (!$alreadyAssigned) {
    //             $roll_start_value++;
    //         }
    //     }
    //     CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Roll Numbers Generated."), 'success');
    // }

    public function checkIfAlreadyAssigned($ap_id, $vp_id)
    {
        $Group_id = DB::table('vacancy_exam_group_child')
            ->select('vacancy_exam_group_id')
            ->where('vacancy_post_id', $vp_id)
            ->first();
        $Posts = DB::table('vacancy_exam_group_child')
            ->select('vacancy_post_id')
            ->where('vacancy_exam_group_id', $Group_id->vacancy_exam_group_id)
            ->get();
        for ($i = count($Posts) - 1; $i >= 0; $i--) {
            $post_idd = $Posts[$i]->vacancy_post_id;
            $data = DB::table('vacancy_exam')
                ->where([['applicant_id', $ap_id], ['vacancy_post_id', $post_idd]])
                ->get();
            if (count($data) >= 1) {
                return array(true, $data[0]->exam_roll_no);
            }
        }


    }

    public function generateRollNo($id)
    {
        // dd($id);
        $post_id = intval($id);
        $vacancy_data = $this->getVacancyDetail($post_id);
        $roll_prefix = $vacancy_data->roll_prefix;
        $roll_start_value = $vacancy_data->roll_start_value;

        $row = DB::statement(DB::raw('SET @row :=' . $roll_start_value . ''));

        $query = DB::select('select t.*
        from (
        SELECT
            va.applicant_id,
            concat(
                   upper( `ap`.`first_name_en` ),
                   \' \',
                   upper( COALESCE ( `ap`.`mid_name_en`, \'\' ) ),
                   \' \',
                   upper( `ap`.`last_name_en` )
                   ) AS full_name_en,
            va.vacancy_post_id,
            va.designation_id,
            vp.exam_centre_id,
            va.id AS vacancy_apply_id
        FROM
            vacancy_apply va
            LEFT JOIN applicant_profile ap ON ap.id = va.applicant_id
            LEFT JOIN vacancy_post vp ON vp.id = va.vacancy_post_id
        WHERE
            is_paid =:is_paid and is_rejected =:is_rejected and va.is_deleted =:is_deleted
        AND vacancy_post_id =:post_id
        ORDER BY
        ad_no,
        full_name_en
        ) t', ['is_paid' => 1, 'is_rejected' => 0, 'is_deleted' => 0, 'post_id' => $post_id]);

        // dd($query);

        // Delete old data
        DB::table('vacancy_exam')->whereVacancy_post_id($post_id)->delete();
        //Insert roll no.
        foreach ($query as $value) {
            $papers = DB::table('vacancy_post_paper')
                ->select('id')
                ->where('vacancy_post_id', $post_id)
                ->get();
                // dd($papers,$post_id);
            foreach ($papers as $ppr) {
                DB::table('vacancy_exam')
                    ->insert(array('paper_id' => $ppr->id, 'vacancy_apply_id' => $value->vacancy_apply_id, 'applicant_id' => $value->applicant_id, 'vacancy_post_id' => $post_id, 'designation_id' => $value->designation_id, 'exam_roll_no' => $roll_prefix . $roll_start_value));
            }
            $roll_start_value++;
        }

        CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Roll Numbers Generated."), 'success');
    }

    public function postExamDetail()
    {
        ini_set('max_execution_time', 300);
        $roll_start = (int)Request::get('roll_start');
        $roll_prefix = (string)Request::get('roll_prefix');
        $post_id = Request::get('post_id');
        $exam_group_id = Request::get('exam_group_id');

        


        // $exam_group_id = DB::table('vacancy_exam_group_child')
        //     ->select('vacancy_exam_group_id')
        //     ->where('vacancy_post_id', $post_id)
        //     ->get();

        //count of post id in the group
        $post_group = DB::table('vacancy_exam_group_child')
            ->select('vacancy_post_id')
            ->where('vacancy_exam_group_id', $exam_group_id)
            ->get();

        $count_post_group = count($post_group);

        // dd($count_post_group);
        if ($count_post_group <= 1) {
            DB::table('vacancy_post')->whereId($post_id)->update(['roll_start_value' => $roll_start, 'roll_prefix' => $roll_prefix]);
            $this->generateRollNo($post_id);
            CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_post60', trans("Roll Numbers Generated."), 'success');
        }
        for ($i = $count_post_group - 1; $i >= 0; $i--) {
            $post_idd = $post_group[$i]->vacancy_post_id;
            DB::table('vacancy_post')->whereId($post_idd)->update(['roll_start_value' => $roll_start, 'roll_prefix' => $roll_prefix]);
        }
        $this->generateRollNoGroupwise($post_group);
    }

    public function getExamDetail($id)
    {
        $exam_details = DB::table('vacancy_post as vp')
            ->select('vp.id', 'vp.roll_prefix', 'vp.roll_start_value', 'vp.roll_end_value', 'vp.exam_centre_id', 'm.name_en')
            ->leftJoin('mst_exam_centre as m', 'm.id', '=', 'vp.exam_centre_id')
            ->where('vp.id', '=', $id)
            ->first();
        return $exam_details;
    }

    public function generateAdmitCardForUser($id,$exam_group_id)
    {
        // dd($id,$exam_group_id);

        ini_set('max_execution_time', 300);
        $ad_no = VacancyPost::whereId($id)->pluck('ad_no')->first();


        if (Session::get("is_applicant") != 1) {
            $post_id = intval($id);

            $data['opening_type'] = DB::table('vacancy_post as vp')
                ->select('mj.id as id')
                ->leftjoin('vacancy_ad as vad', 'vad.id', '=', 'vp.vacancy_ad_id')
                ->leftjoin('mst_job_opening_type as mj', 'mj.id', '=', 'vad.opening_type_id')
                ->where('vp.id', $post_id)->first();
            $ExamGroup = DB::table('vacancy_exam_group_child')
                ->select('vacancy_exam_group_id')
                ->where('vacancy_post_id', $post_id)
                ->first();


            $ContainMultiplePost = DB::table('vacancy_exam_group_child')
                ->where('vacancy_exam_group_id', $exam_group_id)
                ->get();

            //dd($ContainMultiplePost);

            // $post_ids = $this->illuminatiColToArray($ContainMultiplePost, 'vacancy_post_id');
            // dd($post_ids);

            $post_ids=DB::table('vacancy_exam_group_child')->where('vacancy_exam_group_id',$exam_group_id)->pluck('vacancy_post_id')->toArray();
            // foreach ($ContainMultiplePost as $cp) {
            //     $postids[] = $cp->vacancy_post_id;
            // }

            // dd($ContainMultiplePost );
            // dd(count($post_ids));

            if (count($post_ids) > 1) {
                foreach ($ContainMultiplePost as $cmp) {
                    $applicants = DB::table('vw_admit_card')
                        ->select('applicant_id')
                        ->whereIn('vacancy_post_id', $post_ids)
                        ->distinct()
                        ->get();

                    if ($applicants->isNotEmpty()) {
                        $directory = 'admit_card/open_exam/' . $cmp->vacancy_post_id;
                        Storage::deleteDirectory($directory);
                        Storage::makeDirectory($directory);

                        $count = count($applicants);
                        // dd($count);

                        for ($i = 0; $i < $count; $i++) {
                            $applicant_id = $applicants[$i]->applicant_id;

                            $data['admit_card'] = DB::table('vw_admit_card')
                                ->select('*', DB::raw('IF(internal = 1, "आ. प्र", "खुल्ला/समावेशी") as opening_type'))
                                ->where([['vacancy_post_id', $cmp->vacancy_post_id], ['applicant_id', $applicant_id]])
                                ->distinct()
                                ->take(1)
                                ->get();


                            $data['posts_applied'] = $posts_applied = DB::table('vw_admit_card')
                  
                                ->select('*', DB::raw('IF(internal = 1, "आ. प्र", "खुल्ला/समावेशी") as opening_type'))
                                ->selectRaw("
                                CASE 
                                    WHEN exam_roll_no REGEXP '^[A-Z]+[0-9]+$' 
                                    THEN CONCAT(
                                        SUBSTRING_INDEX(exam_roll_no, REGEXP_SUBSTR(exam_roll_no, '[0-9]+$'), 1),
                                        '-',
                                        REGEXP_SUBSTR(exam_roll_no, '[0-9]+$')
                                    )
                                    ELSE exam_roll_no
                                END AS modified_exam_roll_no
                            ")
                                ->leftjoin('vacancy_post_exam', 'vacancy_post_exam.vacancy_post_id', 'vw_admit_card.vacancy_post_id')
                                ->leftjoin('vacancy_post_paper', 'vacancy_post_paper.id', 'vacancy_post_exam.paper_id')
                                ->whereIn('vw_admit_card.vacancy_post_id', $post_ids)
                                ->where('applicant_id', $applicant_id)
                                ->distinct()
                                ->get();

                                // dd($data);

                            


                            $posts_applied = collect($posts_applied);
                            $posts_applied = $posts_applied->unique('ad_no');
                            $working_path = 'admit_card/open_exam/' . $cmp->vacancy_post_id;
                            $admit_card_path = $working_path . "/" . $data['admit_card'][0]->token_number . "_AdmitCard" . ".html";
                            $admit_card_pdf_path = $working_path . "/" . $applicant_id . "_AdmitCard" . ".pdf";
                            // $a = View::make('admit_card.openexam.indexmultiplepost', $data);
                            $a = View::make('admit_card.combined_exam.indexMultiplePost', $data);
                            // dd($data);
                           
                        //    return $a;
                            Storage::put($admit_card_path, $a);
                        }
                    } else {
                        CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Card could not be generated! Please make sure that roll number is generated."), 'warning');
                    }

                }
                CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Cards Generated!"), 'success');

            } // if not in group
            else {
                    // dd($id);
                $applicants = DB::table('vw_admit_card')
                    ->select('*')
                    ->where('vacancy_post_id', $post_id)
                    ->distinct()
                    ->get();

                    // dd($applicants);
                //dd($applicants,$post_id);
                if ($applicants) {
                    $directory = 'admit_card/open_exam/' . $post_id;
                    Storage::deleteDirectory($directory);
                    Storage::makeDirectory($directory);

                    $count = count($applicants);
                    for ($i = 0; $i < $count; $i++) {
                        $applicant_id = $applicants[$i]->applicant_id;

                        $data['admit_card'] = DB::table('vw_admit_card')
                            ->select('*', DB::raw('IF(internal = 1, "आ. प्र", "खुल्ला/समावेशी") as opening_type'))
                            ->where([['vacancy_post_id', $post_id], ['applicant_id', $applicant_id]])
                            ->distinct()
                            ->take(1)
                            ->get();

                        $working_path = 'admit_card/open_exam/' . $post_id;
                        $admit_card_path = $working_path . "/" . $data['admit_card'][0]->token_number . "_AdmitCard" . ".html";
                        $admit_card_pdf_path = $working_path . "/" . $applicant_id . "_AdmitCard" . ".pdf";

                        $data['papers'] = DB::table('vacancy_post_paper')
                            ->select('vacancy_post_paper.id as post_paper_id', 'vacancy_post_paper.paper_name_np as paper_name_np', 'vacancy_post_exam.date_bs as date', 'vacancy_post_exam.time_from as time')
                            ->leftjoin('vacancy_post_exam', 'vacancy_post_exam.paper_id', '=', 'vacancy_post_paper.id')
                            ->where([['vacancy_post_paper.is_deleted', false], ['vacancy_post_paper.vacancy_post_id', $post_id]])
                            ->distinct()
                            ->get();


                        $data['center'] = DB::table('vacancy_exam as ve')
                            ->select('ve.exam_center as center', 'vpp.id as paper_id', 'mec.name_np as name')
                            ->leftjoin('vacancy_post_paper as vpp', function ($join) {
                                $join->on('vpp.vacancy_post_id', '=', 've.vacancy_post_id')
                                    ->where('vpp.is_deleted', false);
                            })
                            ->leftjoin('mst_exam_centre AS mec', 've.exam_center', 'mec.id')
                            ->where([['ve.vacancy_post_id', $post_id], ['ve.applicant_id', $applicant_id]])
                            ->distinct()
                            ->get();

                            // dd($data);

                        $center_details = [];
                        foreach ($data['papers'] as $papers) {

                            foreach ($data['center'] as $center) {
                                if ($center->paper_id == $papers->post_paper_id) {
                                    $center_details['paper_name'][] = $papers->paper_name_np;
                                    $center_details['centername'][] = $center->name;
                                    $center_details['date'][] = $papers->date;
                                    $center_details['time'][] = $papers->time;
                                }
                            }
                        }
                        $data['center_details'] = $center_details;
                        DB::table('admit_card_status')->insert(
                            ['vacancy_post_id' => $post_id,'fiscal_year_id'=>Session::get('fiscal_year_id'), 'token_number' => $data['admit_card'][0]->token_number ,'applicant_id' => $applicant_id, 'html_path' => $admit_card_path, 'status' => 1]
                        );
                        // $a = View::make('admit_card.openexam.pdfindexnew', $data);

                        // dd($data);

                        $a = View::make('admit_card.combined_exam.indexSinglePost', $data);
                        // dd($data);

                        // return $a;
                        Storage::put($admit_card_path, $a);
                    }
                    CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Cards Generated!"), 'success');
                } else {
                    CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Card could not be generated! Please make sure that roll number is generated."), 'warning');
                    // return;
                }
            }
        }
    }

//     public function generateAdmitCardForUserOld($id)
//     {
//         // dd($id);
//         ini_set('max_execution_time', 300);
//         $ad_no = VacancyPost::whereId($id)->pluck('ad_no')->first();


//         if (Session::get("is_applicant") != 1) {
//             $post_id = intval($id);

//             $data['opening_type'] = DB::table('vacancy_post as vp')
//                 ->select('mj.id as id')
//                 ->leftjoin('vacancy_ad as vad', 'vad.id', '=', 'vp.vacancy_ad_id')
//                 ->leftjoin('mst_job_opening_type as mj', 'mj.id', '=', 'vad.opening_type_id')
//                 ->where('vp.id', $post_id)->first();
//             $ExamGroup = DB::table('vacancy_exam_group_child')
//                 ->select('vacancy_exam_group_id')
//                 ->where('vacancy_post_id', $post_id)
//                 ->first();


//             $ContainMultiplePost = DB::table('vacancy_exam_group_child')
//                 ->where('vacancy_exam_group_id', $ExamGroup->vacancy_exam_group_id)
//                 ->get();

//             //dd($ContainMultiplePost);

//             $post_ids = $this->illuminatiColToArray($ContainMultiplePost, 'vacancy_post_id');
//             // dd($post_ids);

//             foreach ($ContainMultiplePost as $cp) {
//                 $postids[] = $cp->vacancy_post_id;
//             }

//             if ($ContainMultiplePost->count() > 1) {
//                 foreach ($ContainMultiplePost as $cmp) {
//                     $applicants = DB::table('vw_admit_card')
//                         ->select('applicant_id')
//                         ->whereIn('vacancy_post_id', $postids)
//                         ->distinct()
//                         ->get();


//                     if ($applicants->isNotEmpty()) {
//                         $directory = 'admit_card/open_exam/' . $cmp->vacancy_post_id;
//                         Storage::deleteDirectory($directory);
//                         Storage::makeDirectory($directory);

//                         $count = count($applicants);
//                         // dd($count);

//                         for ($i = 0; $i < $count; $i++) {
//                             $applicant_id = $applicants[$i]->applicant_id;

//                             $data['admit_card'] = DB::table('vw_admit_card')
//                                 ->select('*')
//                                 ->where([['vacancy_post_id', $cmp->vacancy_post_id], ['applicant_id', $applicant_id]])
//                                 ->distinct()
//                                 ->take(1)
//                                 ->get();

//                             // $posts_applied=DB::table('vw_admit_card')
//                             // ->whereIn('vacancy_post_id',$postids)
//                             // ->where('applicant_id',$applicant_id)
//                             //  ->distinct()
//                             //   ->get();


//                             $data['posts_applied'] = $posts_applied = DB::table('vw_admit_card')
//                                 ->select('*')
//                                 ->leftjoin('vacancy_post_exam', 'vacancy_post_exam.vacancy_post_id', 'vw_admit_card.vacancy_post_id')
//                                 ->leftjoin('vacancy_post_paper', 'vacancy_post_paper.id', 'vacancy_post_exam.paper_id')
//                                 ->whereIn('vw_admit_card.vacancy_post_id', $postids)
//                                 ->where('applicant_id', $applicant_id)
//                                 ->distinct()
//                                 ->get();


//                             $posts_applied = collect($posts_applied);
//                             $posts_applied = $posts_applied->unique('ad_no');
//                             $working_path = 'admit_card/open_exam/' . $cmp->vacancy_post_id;
//                             $admit_card_path = $working_path . "/" . $data['admit_card'][0]->token_number . "_AdmitCard" . ".html";
//                             $admit_card_pdf_path = $working_path . "/" . $applicant_id . "_AdmitCard" . ".pdf";
//                             dd($data);
//                             $a = View::make('admit_card.openexam.indexmultiplepost', $data);
//                             Storage::put($admit_card_path, $a);
//                         }
//                     } else {
//                         CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Card could not be generated! Please make sure that roll number is generated."), 'warning');
//                     }

//                 }
//                 CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Cards Generated!"), 'success');

//             } // if not in group
//         else {
//                 // dd($id);
//             $applicants = DB::table('vw_admit_card')
//                 ->select('*')
//                 ->where('vacancy_post_id', $post_id)
//                 ->distinct()
//                 ->get();
//             //dd($applicants,$post_id);
//             if ($applicants) {
//                 $directory = 'admit_card/open_exam/' . $post_id;
//                 Storage::deleteDirectory($directory);
//                 Storage::makeDirectory($directory);

//                 $count = count($applicants);
//                 for ($i = 0; $i < $count; $i++) {
//                     $applicant_id = $applicants[$i]->applicant_id;

//                     $data['admit_card'] = DB::table('vw_admit_card')
//                         ->select('*')
//                         ->where([['vacancy_post_id', $post_id], ['applicant_id', $applicant_id]])
//                         ->distinct()
//                         ->take(1)
//                         ->get();

//                     $working_path = 'admit_card/open_exam/' . $post_id;
//                     $admit_card_path = $working_path . "/" . $data['admit_card'][0]->token_number . "_AdmitCard" . ".html";
//                     $admit_card_pdf_path = $working_path . "/" . $applicant_id . "_AdmitCard" . ".pdf";

//                     $data['papers'] = DB::table('vacancy_post_paper')
//                         ->select('vacancy_post_paper.id as post_paper_id', 'vacancy_post_paper.paper_name_np as paper_name_np', 'vacancy_post_exam.date_bs as date', 'vacancy_post_exam.time_from as time')
//                         ->leftjoin('vacancy_post_exam', 'vacancy_post_exam.paper_id', '=', 'vacancy_post_paper.id')
//                         ->where([['vacancy_post_paper.is_deleted', false], ['vacancy_post_paper.vacancy_post_id', $post_id]])
//                         ->distinct()
//                         ->get();


//                     $data['center'] = DB::table('vacancy_exam as ve')
//                         ->select('ve.exam_center as center', 'vpp.id as paper_id', 'mec.name_np as name')
//                         ->leftjoin('vacancy_post_paper as vpp', function ($join) {
//                             $join->on('vpp.vacancy_post_id', '=', 've.vacancy_post_id')
//                                 ->where('vpp.is_deleted', false);
//                         })
//                         ->leftjoin('mst_exam_centre AS mec', 've.exam_center', 'mec.id')
//                         ->where([['ve.vacancy_post_id', $post_id], ['ve.applicant_id', $applicant_id]])
//                         ->distinct()
//                         ->get();



//                     $center_details = [];
//                     foreach ($data['papers'] as $papers) {

//                         foreach ($data['center'] as $center) {
//                             if ($center->paper_id == $papers->post_paper_id) {
//                                 $center_details['paper_name'][] = $papers->paper_name_np;
//                                 $center_details['centername'][] = $center->name;
//                                 $center_details['date'][] = $papers->date;
//                                 $center_details['time'][] = $papers->time;
//                             }
//                         }
//                     }

//                     $data['center_details'] = $center_details;

//                     // var_dump($data['center']);
//                     // dd($data['center']);

//                     // exit;
//                     // Make html file
//                     #move images to public folder

//                     //dd($data);


//                     DB::table('admit_card_status')->insert(
//                         ['vacancy_post_id' => $post_id,'fiscal_year_id'=>Session::get('fiscal_year_id'), 'token_number' => $data['admit_card'][0]->token_number ,'applicant_id' => $applicant_id, 'html_path' => $admit_card_path, 'status' => 1]
//                     );

// //                         $a = View::make('admit_card.open_admitcard', $data);
//                     // return $a;


//                     #html file
// //                         $a = View::make('admit_card.openexam.indexnew', $data);
// //                        $a = View::make('admit_card.openexam.pdfindexnew', $data);
//                     $a = View::make('admit_card.openexam.pdfindexnew', $data);
//                     Storage::put($admit_card_path, $a);
//                 }

//                 CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Cards Generated!"), 'success');

//             } else {
//                 CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_exam_group', trans("Admit Card could not be generated! Please make sure that roll number is generated."), 'warning');
//                 // return;
//             }
//         }
//         }
//     }


}
