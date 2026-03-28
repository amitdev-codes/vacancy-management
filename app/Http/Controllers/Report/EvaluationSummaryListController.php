<?php

namespace App\Http\Controllers\Report;

use App;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Request;
use Session;
use View;

class EvaluationSummaryListController extends App\Http\Controllers\BaseCBController
{
    public $ad_id = 0;

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "vacancy_post_paper";
        $this->title_field = "id";
        $this->limit = 20;
        $this->orderby = "id,desc";
        $this->show_numbering = false;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_delete = true;
        $this->button_edit = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_export = false;
        $this->button_import = false;
        $this->button_bulk_action = true;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        // $this->col = array();
        // $this->col[] = array("label"=>"Vacancy Post Id","name"=>"vacancy_post_id","join"=>"vacancy_post,ad_no");
        // $this->col[] = array("label"=>"Paper Name En","name"=>"paper_name_en" );
        // $this->col[] = array("label"=>"Paper Name Np","name"=>"paper_name_np" );
        // $this->col[] = array("label"=>"Remarks","name"=>"remarks" );

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        // $this->form = [];
        // $this->form[] = ["label"=>"Vacancy Post","name"=>"vacancy_post_id","type"=>"select2-c","cmp-ratio"=>"4:6:12","required"=>true,"validation"=>"","datatable"=>"vacancy_post,ad_no"];
        // $this->form[] = ["label"=>"Paper Name En","name"=>"paper_name_en","type"=>"text-c","cmp-ratio"=>"4:6:12","required"=>true,"validation"=>"required"];
        // $this->form[] = ["label"=>"Paper Name Np","name"=>"paper_name_np","type"=>"text-c","cmp-ratio"=>"4:6:12","required"=>true,"validation"=>"required"];
        // $this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"wysiwyg-c","cmp-ratio"=>"12:12:12","required"=>false,"validation"=>"string|min:5|max:5000"];

        # END FORM DO NOT REMOVE THIS LINE

        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key    = foreign key of sub table/module
        | @button_color   = Bootstrap Class (primary,success,warning,danger)
        | @button_icon    = Font Awesome Class
        | @parent_columns = Sparate with comma, e.g : name,created_at
        |
         */
        $this->sub_module = array();

        /*
        | ----------------------------------------------------------------------
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
        | @icon        = Font awesome class icon. e.g : fa fa-bars
        | @color       = Default is primary. (primary, warning, succecss, info)
        | @showIf      = If condition when action show. Use field alias. e.g : [id] == 1
        |
         */
        $this->addaction = array();

        /*
        | ----------------------------------------------------------------------
        | Add More Button Selected
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @icon        = Icon from fontawesome
        | @name        = Name of button
        | Then about the action, you should code at actionButtonSelected method
        |
         */
        $this->button_selected = array();

        /*
        | ----------------------------------------------------------------------
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------
        | @message = Text of message
        | @type    = warning,success,danger,info
        |
         */
        $this->alert = array();

        /*
        | ----------------------------------------------------------------------
        | Add more button to header button
        | ----------------------------------------------------------------------
        | @label = Name of button
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        |
         */
        $this->index_button = array();

        //  $this->index_button[] = ["label" => "Evaluate Points", "icon" => "fa fa-check", "url" => CRUDBooster::adminPath('evaluation'), 'color' => 'success'];

        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
         */
        $this->table_row_color = array();

        /*
        | ----------------------------------------------------------------------
        | You may use this bellow array to add statistic at dashboard
        | ----------------------------------------------------------------------
        | @label, @count, @icon, @color
        |
         */
        $this->index_statistic = array();

        /*
        | ----------------------------------------------------------------------
        | Add javascript at body
        | ----------------------------------------------------------------------
        | javascript code in the variable
        | $this->script_js = "function() { ... }";
        |
         */
        $this->script_js = "";

        /*
        | ----------------------------------------------------------------------
        | Include HTML Code before index table
        | ----------------------------------------------------------------------
        | html code to display it before index table
        | $this->pre_index_html = "<p>test</p>";
        |
         */
        $this->pre_index_html = null;

        /*
        | ----------------------------------------------------------------------
        | Include HTML Code after index table
        | ----------------------------------------------------------------------
        | html code to display it after index table
        | $this->post_index_html = "<p>test</p>";
        |
         */
        $this->post_index_html = null;

        /*
        | ----------------------------------------------------------------------
        | Include Javascript File
        | ----------------------------------------------------------------------
        | URL of your javascript each array
        | $this->load_js[] = asset("myfile.js");
        |
         */
        $this->load_js = array();

        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
         */
        $this->style_css = null;

        /*
        | ----------------------------------------------------------------------
        | Include css File
        | ----------------------------------------------------------------------
        | URL of your css each array
        | $this->load_css[] = asset("myfile.css");
        |
         */
        $this->load_css = array();
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for button selected
    | ----------------------------------------------------------------------
    | @id_selected = the id selected
    | @button_name = the name of button
    |
     */
    public function actionButtonSelected($id_selected, $button_name)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate query of index result
    | ----------------------------------------------------------------------
    | @query = current sql query
    |
     */
    public function hook_query_index(&$query)
    {
        // dd('amit');
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate row of index table html
    | ----------------------------------------------------------------------
    |
     */
    public function hook_row_index($column_index, &$column_value)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before add data is execute
    | ----------------------------------------------------------------------
    | @arr
    |
     */
    public function hook_before_add(&$postdata)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after add public static function called
    | ----------------------------------------------------------------------
    | @id = last insert id
    |
     */
    public function hook_after_add($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before update data is execute
    | ----------------------------------------------------------------------
    | @postdata = input post data
    | @id       = current id
    |
     */
    public function hook_before_edit(&$postdata, $id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after edit public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
     */
    public function hook_after_edit($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command before delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
     */
    public function hook_before_delete($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
     */
    public function hook_after_delete($id)
    {
        //Your code here
    }

    public function getIndex()
    {
        // dd('amit');
        $data = [];
        $data['page_title'] = 'File';
        $data['adno_data'] = $this->getVacancyAdNo();

        //dd($data);
        $this->cbView('reports.evaluation_summary_list', $data);

    }
    public function getVacancyAdNo()
    {
        // $adno_data = DB::select(DB::raw("select id,ad_title_en from vacancy_ad"));
        $fiscal_year_id = Session::get('fiscal_year_id');
        $today = Carbon::now();
        $adno_data = DB::table('vacancy_ad as va')
            ->select('va.id', 'ad_title_en', 'mj.name_np as opening_type')
            ->leftjoin('mst_job_opening_type as mj', 'va.opening_type_id', 'mj.id')
            ->where([['va.is_deleted', false], ['va.opening_type_id', 3], ['fiscal_year_id', $fiscal_year_id], ['vacancy_extended_date_ad', '>=', $today],['is_published',true]])
            ->get();
        return $adno_data;

    }

    public function getDesignation($id)
    {

        $this->ad_id = $id;
        $desination_data = DB::select('SELECT distinct
        CONCAT_WS("-",d.name_en,d.name_np) as designation,
        d.id,
        vp.id AS post_id
    FROM
        vacancy_post vp
        LEFT JOIN mst_designation d ON d.id = vp.designation_id
    WHERE
        vacancy_ad_id =:id and vp.is_deleted is false and vp.file_pormotion is not null', ['id' => $id]);
        return $desination_data;
    }

    public function setVacancyAdId($id)
    {
        $this->ad_id = $id;
    }

    public function getVacancyAdId()
    {
        return $this->ad_id;
    }

    public function getDesignationView($id)
    {
        $data = [];
        $data['designation_data'] = $this->getDesignation($id);
        $data['adno_data'] = $this->getVacancyAdNo();
        $data['id'] = $id;
        $data['ad_id'] = $id;
        $this->ad_id = $id;
        $this->cbView('reports.evaluation_summary_list', $data);
    }

    public function getCandidates($ad_id, $id)
    {

        $data = [];
        $data['md_id'] = $id;
        $designation_id = DB::table('vacancy_post')
            ->select('designation_id', 'vacancy_ad_id')
            ->where('id', $id)
            ->first();

        $opening_type = DB::table('vacancy_ad')
            ->select('opening_type_id')
            ->where('id', $designation_id->vacancy_ad_id)
            ->first();

        $neededDegree = DB::table('mst_designation_degree as mdd')
            ->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
            ->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
            ->where('mdd.designation_id', $designation_id->designation_id)
            ->get();

        $neededTraining = DB::table('mst_designation_training as mdt')
            ->select('mdt.training_id as ti', 'mt.name_en as name')
            ->leftjoin('mst_training as mt', 'mt.id', '=', 'mdt.training_id')
            ->where('mdt.designation_id', $designation_id->designation_id)
            ->get();

        $candidate_data = DB::select('SELECT DISTINCT
        aem.geographical_marks,
        aem.seniority_marks,
        aem.leave_marks,
        aem.qualification_marks,
        aem.incharge_marks,
        aem.total_marks,
        t2.exam_roll_no AS roll,
        t1.*,
        ms.name_np AS current_designation,
        t1.gender,
        mwl.name_np AS work_level,
        mwo.name_en AS working_office,
        t3.seniority_date_bs,
        t3.seniority_date_ad,
        med.name_en AS minimum_qualification_degree,
        max_med.name_en AS additional_qualification_degree,
        medi.name_en AS minimum_qualification_division,
        max_medi.name_en AS additional_qualification_division,
        t3.remarks AS service_history_remarks
    FROM
        vw_file_pormotion_applied t1
        LEFT JOIN vacancy_exam t2 ON t1.vacancy_apply_id = t2.vacancy_apply_id
        LEFT JOIN merged_applicant_service_history t3 ON t1.ap_id = t3.applicant_id
        LEFT JOIN mst_designation ms ON ms.id = t3.designation
        LEFT JOIN mst_work_level mwl ON mwl.id = t3.work_level
        LEFT JOIN mst_working_office mwo ON mwo.id = t3.working_office
        LEFT JOIN applicant_evaluation_marks aem ON aem.token_number = t1.token_number
        LEFT JOIN mst_edu_degree med ON med.id = aem.min_edu_degree_id
        LEFT JOIN mst_edu_division medi ON medi.id = aem.min_division_id
        LEFT JOIN mst_edu_degree max_med ON max_med.id = aem.max_edu_degree_id
        LEFT JOIN mst_edu_division max_medi ON max_medi.id = aem.max_division_id
    WHERE
        t1.vp_id =:id
        AND t1.is_rejected =:is_rejected
        AND t1.is_cancelled =:is_cancelled
        AND t3.is_current =:is_current
    ORDER BY
        applicant_name_en', ['id' => $id, 'is_rejected' => 0, 'is_cancelled' => 0, 'is_current' => 1]);

        $candidate_data = collect($candidate_data);


        $candidate_data = $candidate_data->unique('ap_id');

        // dd($candidate_data);
        foreach ($candidate_data as $key => $value) {
            $servicestatus = "";
            $edustatus = "";
            $service_status = DB::table('merged_applicant_service_history')
                ->select('is_verified', 'is_approved')
                ->where('vacancy_apply_id', $value->vacancy_apply_id)
                ->first();
            $education_status = DB::table('merged_applicant_education')
                ->select('is_verified', 'is_approved')
                ->where('vacancy_apply_id', $value->vacancy_apply_id)
                ->first();
            if ($service_status->is_verified == 1) {
                $servicestatus = "Verified.";
                if ($service_status->is_approved == 1) {
                    $servicestatus = "Approved.";
                }
            } else {
                $servicestatus = "Not Verified.";
            }
            if ($education_status->is_verified == 1) {
                $edustatus = "Verified.";
                if ($education_status->is_approved == 1) {
                    $edustatus = "Approved.";
                }
            } else {
                $edustatus = "Not Verified.";
            }
            $status = $servicestatus . '/' . $edustatus;
            $candidate_data[$key]->status = $status;

        }

        $data['mst_fiscal_year'] =
        DB::select('SELECT code FROM `mst_fiscal_year`
        WHERE is_current=:is_current', ['is_current' => 1]);

        $data['fiscal_year'] = DB::select('SELECT
        b.id,
        b.date_from_ad,
        b.date_to_ad,
        b.code
    FROM
        vacancy_ad a
        LEFT JOIN mst_fiscal_year b ON a.date_to_publish_ad BETWEEN b.date_from_ad
        AND b.date_to_ad
    WHERE
        a.id=:id and a.opening_type_id=:oid and a.is_deleted=:is_deleted', ['id' => $designation_id->vacancy_ad_id, 'oid' => 3, 'is_deleted' => 0]);

        //education data
        $education_data = [];
        foreach ($candidate_data as $cd) {
            $edu_data = DB::table('applicant_edu_info')
                ->where('applicant_id', $cd->ap_id)
            //->orderBY('id','desc')
                ->get();
            foreach ($edu_data as $ed) {
                foreach ($neededDegree as $nd) {
                    if ($nd->edi === $ed->edu_degree_id) {
                        $edu_major_data = DB::table('mst_edu_major')
                            ->select('name_en')
                            ->where('id', $ed->edu_major_id)
                            ->first();
                        $education_data[$cd->ap_id] = $nd->name . '/' . $edu_major_data->name_en;
                        if ($nd->is_training_required == 0) {
                            goto targetLocation;
                        }
                    }
                }
            }
            targetLocation:
            if (!isset($education_data[$cd->ap_id])) {
                $higest_degree_id = $this->getHighestDegree($cd->ap_id);
                $edu_degree_data = DB::table('mst_edu_degree')
                    ->select('name_en')
                    ->where('id', $higest_degree_id)
                    ->first();
                $edu_major_id = $edu_data = DB::table('applicant_edu_info')
                    ->select('edu_major_id')
                    ->where([['applicant_id', $cd->ap_id], ['edu_degree_id', $higest_degree_id]])
                    ->first();
                $edu_major_data = DB::table('mst_edu_major')
                    ->select('name_en')
                    ->where('id', $edu_major_id->edu_major_id)
                    ->first();
                $education_data[$cd->ap_id] = $edu_degree_data->name_en . '/' . $edu_major_data->name_en;

            }
        }

        // training data
        $training_data = [];
        foreach ($candidate_data as $cd) {
            $trng_data = DB::table('applicant_training_info')
                ->where('applicant_id', $cd->ap_id)
                ->get();
            foreach ($trng_data as $td) {
                foreach ($neededTraining as $nt) {
                    if ($nt->ti === $td->training_id) {
                        $training_data[$cd->ap_id] = $nt->name . '/' . $td->institute_name;
                        goto nextTarget;
                    }
                }
            }
            nextTarget:
            if (!isset($education_data[$cd->ap_id])) {
                $training_data[$cd->ap_id] = $trng_data[0]->training_title . '/' . $trng_data[0]->institute_name;
            }
        }

        // dd($candidate_data);
        $intro_data = DB::select('SELECT
        mws.name_en AS service,
        mwsg.name_en AS service_group,
        va.notice_no,
        vp.ad_no,
        va.ad_title_en,
        vp.designation_id,
        wl.name_en AS work_level,
        md.name_en AS designation,
        vp.total_req_seats
          FROM
        vacancy_post vp
        LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
        LEFT JOIN mst_designation md ON md.id = vp.designation_id
        LEFT JOIN mst_work_level wl ON wl.id = md.work_level_id
        LEFT JOIN mst_work_service mws ON mws.id = md.work_service_id
        LEFT JOIN mst_work_service_group mwsg ON mwsg.id = md.service_group_id

         WHERE
        vp.id =:id', ['id' => $id]);

        $data['level'] = DB::table('vw_published_vacancy_posts_all')
            ->select('level')
            ->where('id', $id)
            ->first();
        if ($data['level']->level == 8 || $data['level']->level == 9) {
            $expereince_data = [];
            foreach ($candidate_data as $cd) {
                $exp_data = DB::table('applicant_exp_info')
                    ->where('applicant_id', $cd->ap_id)
                    ->get();
                foreach ($exp_data as $exd) {
                    // $expereince_data[$cd->ap_id][$exd->id]=$exd->working_office.'('.$exd->date_from_bs.'/'.$exd->date_to_bs.')';
                    $expereince_data[$cd->ap_id][] = $exd->working_office . '(' . $exd->date_from_bs . '/' . $exd->date_to_bs . ')';

                }

            }

            $data['expereince_data'] = $expereince_data;
        }

        // for($i=0; $i<count($expereince_data['1466']); $i++){
        //     echo $expereince_data['1466'][$i];
        // }
        $page = Request::get('page');
        if ($page == '1' || $page == null) {
            $i = 1;
        } else {
            $i = ((int) $page - 1) * 50 + 1;
        }

        foreach ($candidate_data as $cd) {
            $cd->rn = $i;
            $i++;
        }
        $data['training_data'] = $training_data;
        $data['education_data'] = $education_data;
        $data['candidate_data'] = $candidate_data;
        $data['intro_data'] = $intro_data;
        $data['adno_data'] = $this->getVacancyAdNo();
        $data['designation_data'] = $this->getDesignation($ad_id);
        $data['opening_type_id'] = $opening_type->opening_type_id;
        Session::put('candidate_data', $data);
        $this->cbView('reports.evaluation_summary_list', $data);

    }
    public function getHighestDegree($ap_id)
    {
        $edu_data = DB::table('applicant_edu_info')
            ->where('applicant_id', $ap_id)
            ->get();
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 3) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 4) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 1) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 5) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 2) {
                return $ed->edu_degree_id;
            }
        }

    }
    public function downloadPDF(Request $request, $id)
    {
        //   $user = UserDetail::find($id);

        $data = array();
        $candidate_data = DB::select('SELECT distinct ap.id, va.token_number, va.vacancy_post_id,
        CONCAT(
                    ap.first_name_en,
                    \' \',
                    COALESCE (ap.mid_name_en, \' \'),
                    \' \',
                    ap.last_name_en
                ) AS applicant_name,
                ap.dob_bs as birth_date,
            concat(d.name_en,', ',ap.tole_name,'-',ap.ward_no) as address,
            concat(afi.father_name_en,' / ',afi.mother_name_en) as father_mother,
            afi.grand_father_name_en as grand_father,
            ae.working_office,
            ae.date_from_bs,
            ae.date_to_bs,
            ai.training_title as training,
            em.name_en as edu_major, ed.name_en as edu_degree
            FROM
                applicant_profile AS ap
            LEFT JOIN mst_district d on d.id = ap.district_id
            LEFT JOIN applicant_family_info afi on afi.applicant_id = ap.id
            LEFT JOIN applicant_exp_info ae on ae.applicant_id = ap.id
            LEFT JOIN applicant_training_info ai on ai.applicant_id = ap.id
            LEFT JOIN applicant_edu_info aei on aei.applicant_id = ap.id
            LEFT JOIN mst_edu_major em on em.id = aei.edu_major_id
            LEFT JOIN mst_designation_degree dd on dd.edu_degree_id = aei.edu_degree_id
            left join mst_edu_degree ed on ed.id = dd.edu_degree_id
            left join vacancy_apply va on va.applicant_id = ap.id
            where aei.edu_degree_id in(
            select edu_degree_id from mst_designation_degree where designation_id=:id', ['id' => $id]);

        $intro_data = DB::select('SELECT
        va.notice_no, va.ad_title_en, vp.designation_id, wl.name_en as work_level, md.name_en as designation,
    vp.total_req_seats, vp.open_seats, vp.mahila_seats, vp.madheshi_seats, vp.janajati_seats, vp.remote_seats, vp.apanga_seats, vp.dalit_seats
    FROM
        vacancy_post vp
        LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
        left join mst_designation md on md.id = vp.designation_id
        left join mst_work_level wl on wl.id = md.work_level_id
        where vp.designation_id =:id', ['id' => 10]);

        $data['candidate_data'] = $candidate_data;

    }

    public function generateExcel($ad, $id)
    {
        $data = Session::get('candidate_data');
        $report_name = "report" . $ad . '-' . $id . '-' . $today;
        ob_end_clean();
        ob_start();
        ini_set('memory_limit', '-1');
        \Excel::create($report_name, function ($excel) use ($data) {
            $excel->sheet('New sheet', function ($sheet) use ($data) {
                $sheet->loadView('selected_candidate.evaluation_summary_list_xl_report', $data);
                $sheet->setOrientation('portrait');
            });
        })->download('xls');

        ob_flush();
    }
    public function generatepdf($ad, $id)
    {
        $data = Session::get('candidate_data');
        $today = Carbon::now();
        $report_name = "report" . $ad . '-' . $id . '-' . $today;

        $view = View::make('selected_candidate.evaluation_summary_list_pdf_report', $data);
        $contents = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0);
        return $pdf->download($report_name . '.pdf');
    }
}
