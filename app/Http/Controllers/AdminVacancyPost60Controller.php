<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use CRUDBooster;
use DB;
// use Junity\Hashids\Facades\Hashids;
use Request;
use Session;
use Vinkla\Hashids\Facades\Hashids;

class AdminVacancyPost60Controller extends BaseCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->getIndex_view = "default.vacancy.AdwiseIndex";
        if ($this->is_add || $this->is_edit || $this->is_delete) {
            $this->table = "vacancy_post";
        } else {
            $this->table = "vw_published_vacancy_posts_all";
        }
        # END CONFIGURATION DO NOT REMOVE THIS LINE
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $applicant_id = $applicant_id[0];
        $isNtStaff = DB::table("applicant_profile")
            ->select('is_nt_staff')
            ->where('id', $applicant_id)
            ->first();
        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Ad No.", "name" => "ad_no"];
        $this->col[] = ["label" => "Designation", "name" => "trim(concat(post,'<br/>',post_np)) as post"];
        $this->col[] = ["label" => "Service", "name" => "trim(concat(work_service,'<br/>',work_service_np)) as work_service"];
        $this->col[] = ["label" => "Service Group", "name" => "trim(concat(work_service_group,'<br/>',work_service_group_np)) as work_service_group"];

        $this->col[] = ["label" => "Level", "name" => "level"];
        $this->col[] = ["label" => "Published On", "name" => "published_date"];
        $this->col[] = ["label" => "Apply By", "name" => "last_date"];
        $this->col[] = ["label" => "Total Seats", "name" => "total_req_seats"];
        // $this->col[] = ["label" => "Opening Type", "name" => "opening_type"];
        // $this->col[] = ["label" => "Opening Type", "name" => "trim(concat(opening_type,'<br/>',opening_type_np)) as opening_type"];

        if ($isNtStaff->is_nt_staff == 1) {
            $this->col[] = ["label" => "का.स.मु.", "name" => "file_pormotion"];
            $this->col[] = ["label" => "आ.प्र.", "name" => "internal"];
        }
        $this->col[] = ["label" => "Open Seats", "name" => "open_seats"];
        $this->col[] = ["label" => "Mahila Seats", "name" => "mahila_seats"];
        $this->col[] = ["label" => "Janajati Seats", "name" => "janajati_seats"];
        $this->col[] = ["label" => "Madheshi Seats", "name" => "madheshi_seats"];
        $this->col[] = ["label" => "Dalit Seats", "name" => "dalit_seats"];
        $this->col[] = ["label" => "Apanga Seats", "name" => "apanga_seats"];
        $this->col[] = ["label" => "Remote Seats", "name" => "remote_seats"];

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $fiscal_year_id=Session::get('fiscal_year_id');
        $this->form[] = ['label' => 'Vacancy Ad', 'name' => 'vacancy_ad_id', 'type' => 'select2-c', 'cmp-ratio' => '3:12:12', 'validation' => 'required|integer|min:0', 'datatable' => 'vacancy_ad,ad_title_en', 'datatable_where' => 'fiscal_year_id='.$fiscal_year_id.' and is_published=1 and is_deleted=0'];
        $this->form[] = ['label' => 'Advertisement No', 'name' => 'ad_no', 'type' => 'text-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Designation', 'name' => 'designation_id', 'type' => 'select2-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '3:12:12', 'datatable' => 'mst_designation,name_en'];
        $this->form[] = ['label' => 'Total Required Seats', 'name' => 'total_req_seats', 'type' => 'number-c', 'validation' => 'required|numeric|min:1', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Open Seats', 'name' => 'open_seats', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Mahila Seats', 'name' => 'mahila_seats', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Janajati Seats', 'name' => 'janajati_seats', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Madheshi Seats', 'name' => 'madheshi_seats', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Dalit Seats', 'name' => 'dalit_seats', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Apanga Seats', 'name' => 'apanga_seats', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Remote Area Seats', 'name' => 'remote_seats', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'का.स.मु.', 'name' => 'file_pormotion', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'आ.प्र.', 'name' => 'internal', 'type' => 'number-c', 'validation' => 'numeric|min:0', 'cmp-ratio' => '2:12:12'];

        // $this->form[] = ['label'=>'Roll Prefix','name'=>'roll_prefix','type'=>'text-c','cmp-ratio'=>'6:12:12'];
        // $this->form[] = ['label'=>'Roll Start Value','name'=>'roll_start_value','type'=>'number-c','validation'=>'min:1','cmp-ratio'=>'6:12:12'];

        $this->form[] = ['label' => 'Remarks', 'name' => 'remarks', 'type' => 'wysiwyg-c', 'validation' => 'string|min:5|max:5000', 'cmp-ratio' => '12:7:12'];

        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Vacancy Ad Id","name"=>"vacancy_ad_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"vacancy_ad,ad_title_en"];
        //$this->form[] = ["label"=>"Ad No","name"=>"ad_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Designation Id","name"=>"designation_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"designation,id"];
        //$this->form[] = ["label"=>"Total Req Seats","name"=>"total_req_seats","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Open Seats","name"=>"open_seats","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Mahila Seats","name"=>"mahila_seats","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Janajati Seats","name"=>"janajati_seats","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Madheshi Seats","name"=>"madheshi_seats","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Dalit Seats","name"=>"dalit_seats","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Apanga Seats","name"=>"apanga_seats","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        # OLD END FORM

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
        // if (CRUDBooster::myPrivilegeId() == 1) {
        //     $this->addaction[] = ['label' => '', 'icon' => 'fa fa-file', 'color' => 'danger', 'url' => CRUDBooster::mainpath('../vacancy_post60/edit') . '/[id]'];
        // }

        if (Session::get("is_applicant") != 1) {
            //$this->addaction[] = ['label' => 'Admit Card', 'icon' => 'fa fa-envelope-o', 'color' => 'info', 'url' => CRUDBooster::mainpath('../exam/schedule') . '/[id]'];
        } else {
            $this->addaction[] = ['label' => 'Apply', 'icon' => 'fa fa-check-circle', 'color' => 'warning', 'url' => CRUDBooster::mainpath('../vacancy_apply/add') . '/[id]'];
        }

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
        $this->script_js = null;

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
        $this->load_js[] = asset("js/vacancy_post.js");

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

    // public function check_applied($ad_id)
    // {
    //     $data['vacancy_details'] = DB::table('vacancy_post as t1')
    //     ->select('t1.mahila_seats', 't1.janajati_seats', 't1.madheshi_seats', 't1.dalit_seats', 't1.apanga_seats', 't1.remote_seats',
    //     't2.ad_title_en as ad_title', 't3.id as post_id', 't3.name_en as post', 't1.id as vacancy_post_id',
    //     't4.application_rate as fee', 't4.privileged_group_rate as privilege_fee', 't4.extended_time_rate as fine')
    //     ->leftJoin('vacancy_ad as t2', 't2.id', '=', 't1.vacancy_ad_id')
    //     ->leftJoin('mst_designation as t3', 't3.id', '=', 't1.designation_id')
    //     ->leftJoin('mst_work_level as t4', 't4.id', '=', 't3.work_level_id')
    //     ->where('t1.id', '=', $ad_id)
    //     ->first();
    // }

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
        $design = Request::get('md');
        $adver = Request::get('ad');
        $date = date('y-m-d');
        // dd($md, $adver);
        $fiscal_year_id = Session::get('fiscal_year_id');

        if (Session::get("is_applicant") == 1) {
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id);
            $applicant_id = $applicant_id[0];

            //dd('dev');

            if (Session::get("is_nt_staff") == 1) {
                $work_level = intval(Session::get('work_level'));
                $wl = $work_level + 1;
                $work_service_id = intval(Session::get('work_service_id'));
                $service_group_id = intval(Session::get('servicegroup_id'));
                $opening_type_id = Request::get('ot');

                // dd($wl,$work_level);

                // $ot = DB::select('SELECT  distinct opening_type_id from vw_published_vacancy_posts_all where vacancy_ad_id=:vad and fiscal_year_id=:fyd', ['vad' => $adver, 'fyd' => $fiscal_year_id]);
                if (!empty($adver)) {
                    $ot = DB::select('SELECT  distinct opening_type_id from vw_published_vacancy_posts_all where vacancy_ad_id=:vad and fiscal_year_id=:fy_id and extended_date_ad>=:date_ad', ['vad' => $adver, 'fy_id' => $fiscal_year_id, 'date_ad' => Carbon::today()]);
                } else {
                    $ot = DB::select('SELECT  distinct opening_type_id from vw_published_vacancy_posts_all where fiscal_year_id=:fy_id and extended_date_ad>=:date_ad', ['fy_id' => $fiscal_year_id, 'date_ad' => Carbon::today()]);
                }

                $opening_type_id = $ot[0]->opening_type_id;
                Session::put('opening_type_id', $opening_type_id);

                //dd($opening_type_id, $fiscal_year_id);

                /**
                 * If opening type = 1 : list all job openings regardless of service group
                 * If opening type = 2,3 : list all job openings by service group
                 */

                if ($opening_type_id != 0) {
                    $opening_type = DB::table('vacancy_ad')->where([['opening_type_id', $opening_type_id], ['is_deleted', false], ['fiscal_year_id', $fiscal_year_id]]);

                    if ($opening_type->count() == 0) {
                        CRUDBooster::redirect(CRUDBooster::mainpath(), trans("Not any advertisement with that opening type."), 'warning');
                    } elseif ($opening_type_id == 1) {
                        if (CRUDBooster::myPrivilegeId() == 1|| CRUDBooster::myPrivilegeId() == 5){
                            $query->where([['vw_published_vacancy_posts_all.opening_type_id', 1], ['vw_published_vacancy_posts_all.fiscal_year_id', $fiscal_year_id]]);
                        }else{
                            $query->where([['vw_published_vacancy_posts_all.opening_type_id', 1], ['vw_published_vacancy_posts_all.fiscal_year_id', $fiscal_year_id], ['vw_published_vacancy_posts_all.extended_date_ad', '>=', Carbon::today()]]);
                        }
                       
                        $query->orderBy('ad_no');
                   #for internal
                  } elseif ($opening_type_id == 2) {
                     #check level 1,2 and 3
                     //dd($work_level, $work_service_id,   $service_group_id);
                     #gettechnical service group id
                      $technical_work_service=DB::table('mst_work_service')->where([['name_en','TECHNICAL'],['is_deleted',false]])->select('id')->first();
                      $tech_work_serv_id=$technical_work_service->id;

                      #gettechnical service group id
                      $technical_work_service_group=DB::table('mst_work_service_group')->where([['name_en','TECHNICAL'],['work_service_id',$tech_work_serv_id],['is_deleted',false]])->select('id')->first();
                      $tech_work_serv_group_id=$technical_work_service_group->id;

                      #special case for work level 1,2,3
                      if(in_array($work_level,[1,2,3]) && $work_service_id==$tech_work_serv_id && $service_group_id==$tech_work_serv_group_id)
                      {
                        $wl = 4;
                      }else{
                        $wl = $work_level + 1; 
                      }

                    //   dd($wl);

                    if (CRUDBooster::myPrivilegeId() == 1|| CRUDBooster::myPrivilegeId() == 5){
                        $query->where([['vw_published_vacancy_posts_all.opening_type_id', $opening_type_id], ['vw_published_vacancy_posts_all.fiscal_year_id', $fiscal_year_id], ['vw_published_vacancy_posts_all.level', '<=', $wl]]);
                    }else{
                        $query->where([['vw_published_vacancy_posts_all.opening_type_id', $opening_type_id], ['vw_published_vacancy_posts_all.fiscal_year_id', $fiscal_year_id], ['vw_published_vacancy_posts_all.level', '<=', $wl], ['vw_published_vacancy_posts_all.extended_date_ad', '>=', Carbon::today()]]);
                    }

                   
                      if (!empty($design)) {
                          $query->where('designation_id', $design);
                      }
                      $query->orderBy('ad_no');

                    }
                    else {


                        if (CRUDBooster::myPrivilegeId() == 1|| CRUDBooster::myPrivilegeId() == 5){
                            $query->where([['vw_published_vacancy_posts_all.opening_type_id', $opening_type_id], ['vw_published_vacancy_posts_all.fiscal_year_id', $fiscal_year_id], ['vw_published_vacancy_posts_all.level', '=', $wl]]);
                        }else{
                            $query->where([['vw_published_vacancy_posts_all.opening_type_id', $opening_type_id], ['vw_published_vacancy_posts_all.fiscal_year_id', $fiscal_year_id], ['vw_published_vacancy_posts_all.level', '=', $wl], ['vw_published_vacancy_posts_all.extended_date_ad', '>=', Carbon::today()]]);
                        }
    




                      
                        if (!empty($design)) {
                            $query->where('designation_id', $design);
                        }
                        $query->orderBy('ad_no');
                    }


                } else {
                    #new condition remove service group from level 4 in internal and file promoyion
                    if($wl>=4){
                        $query->where([['extended_date_ad', '>=', Carbon::today()], ['level', '=', $wl], ['fiscal_year_id', $fiscal_year_id]]);
                    }else{
                        $query->where([['extended_date_ad', '>=', Carbon::today()], ['level', '=', $wl], ['work_service_id', '=', $work_service_id], ['fiscal_year_id', $fiscal_year_id]]);  
                    }

                    //$query->where([['extended_date_ad', '>=', Carbon::today()], ['level', '=', $wl], ['work_service_id', '=', $work_service_id], ['fiscal_year_id', $fiscal_year_id]]);
                    $query->orderBy('ad_no');
                }

            } else {
                /**
                 * If not NT Staff, then opening type is always 1
                 */
                // $designation = DB::table('vw_published_vacancy_posts_all')->select('designation_id', 'post_np', 'post')->where([['extended_date_ad', '>=', Carbon::today()], ['fiscal_year_id', $fiscal_year_id], ['vacancy_ad_id', $this->ad_id], ['opening_type_id', 1]]);
            
                
                
                if (CRUDBooster::myPrivilegeId() == 1|| CRUDBooster::myPrivilegeId() == 5){
                    $query->where([['opening_type_id', 1], ['fiscal_year_id', $fiscal_year_id]]);
                }else{
                    $query->where([['extended_date_ad', '>=', Carbon::today()], ['opening_type_id', 1], ['fiscal_year_id', $fiscal_year_id]]);
                }
                
                
                
                
                
                
                
                if (!empty($design)) {
                    $query->where('designation_id', $design);
                }
                $query->orderBy('ad_no');
            }
        } else {

            //dd('devs');
            if (!empty($adver)) {$query->where('vacancy_ad_id', $adver);}
            if (!empty($design)) {$query->where('designation_id', $design);}



            if (CRUDBooster::myPrivilegeId() == 1|| CRUDBooster::myPrivilegeId() == 5){
                $query->where([['fiscal_year_id', $fiscal_year_id]])->orderBy('ad_no');
            }else{
                $query->where([['extended_date_ad', '>=', Carbon::today()], ['fiscal_year_id', $fiscal_year_id]])->orderBy('ad_no');
            }


   
                
           // dd($query->toSql());
        }

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

    //By the way, you can still create your own method in here... :)

    public function getIndex()
    {
        return parent::getIndex();
    }

    public function GetOpeningType(Request $request)
    {
        $vacancy_ad_id = Request::get('vacancy_ad_id');
        $fiscal_year_id = Session::get('fiscal_year_id');
        $data = DB::table('vacancy_ad')
            ->select('opening_type_id')
            ->where([['id', $vacancy_ad_id], ['fiscal_year_id', $fiscal_year_id], ['is_deleted', false]])
            ->first();

        return response()->json(array('data' => $data), 200);
    }
}
