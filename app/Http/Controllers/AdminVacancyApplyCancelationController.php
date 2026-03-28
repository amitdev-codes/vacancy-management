<?php namespace App\Http\Controllers;

use CRUDBooster;
use DB;
use Session;

class AdminVacancyApplyCancelationController extends BaseCBController
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
        $this->button_edit = true;
        $this->button_delete = false;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = false;
        $this->button_import = false;
        $this->button_export = true;
        $this->is_cancelled_count = true;
        $this->table = "vacancy_apply";
        $this->getIndex_view = "default.vacancy.AdwiseIndex";
        $this->ad_id = 0;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE87ycycuc
        $this->col = [];
        $this->col[] = ["label" => "Vacancy Post", "name" => "vacancy_post_id", "join" => "vacancy_post,ad_no"];
        $this->col[] = ["label" => "Designation", "name" => "designation_id", "join" => "mst_designation,name_en"];
        $this->col[] = ["label" => "Token No.", "name" => "token_number"];
        $this->col[] = ["label" => "Applicant", "name" => "(select concat(a.first_name_en,' ',coalesce(NULLIF(a.mid_name_en,''),''),' ',a.last_name_en) from applicant_profile a where vacancy_apply.applicant_id = a.id) as full_name"];
        $this->col[] = ["label" => "Mobile", "name" => "(select mobile_no from applicant_profile a where vacancy_apply.applicant_id = a.id) as mobile"];
        $this->col[] = ["label" => "Applied Date", "name" => "trim(concat(applied_date_ad,' A.D.</br>', applied_date_bs,' B.S.')) as applied_date"];
        // $this->col[] = ["label"=>"Applied Date AD","name"=>"applied_date_ad"];
        // $this->col[] = ["label"=>"Applied Date BS","name"=>"applied_date_bs"];
        $this->col[] = ["label" => "Cancelled Date", "name" => "trim(concat(cancelled_date_ad,' A.D.</br>', cancelled_date_bs,' B.S.')) as cancelled_date"];
        // $this->col[] = ["label"=>"Cancelled Date AD","name"=>"cancelled_date_ad"];
        // $this->col[] = ["label"=>"Cancelled Date BS","name"=>"cancelled_date_bs"];
        $this->col[] = ["label" => "Cancelled", "name" => "case when is_cancelled = 1 then 'YES' ELSE 'NO' END as is_cancelled"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        // $this->form[] = ['label'=>'is_cancelled','name'=>'is_cancelled','type'=>'hidden','validation'=>'required','value'=>1];
        $this->form[] = ['label' => 'Applicant Name', 'name' => 'applicant_id', 'type' => 'select2-c', 'width' => 'col-sm-10', "datatable_format" => "first_name_en,' ',last_name_en", 'datatable' => 'applicant_profile,first_name_en', 'cmp-ratio' => '4:8:12'];
        $this->form[] = ['label' => 'Advertisement No.', 'name' => 'vacancy_post_id', 'type' => 'select2-c', 'width' => 'col-sm-10', 'datatable' => 'vacancy_post,ad_no', 'cmp-ratio' => '4:8:12'];
        $this->form[] = ['label' => 'Advertisement Id.', 'name' => 'vacancy_post_id', 'type' => 'hidden', 'width' => 'col-sm-10', 'datatable' => 'vacancy_post,id', 'cmp-ratio' => '4:8:12'];
        $this->form[] = ['label' => 'Applicant Id', 'name' => 'applicant_id', 'type' => 'hidden', 'width' => 'col-sm-10', 'datatable' => 'applicant_profile,id', 'cmp-ratio' => '4:8:12'];
        $this->form[] = ['label' => 'Designation', 'name' => 'designation_id', 'type' => 'select2-c', 'width' => 'col-sm-10', 'datatable' => 'mst_designation,name_en', 'cmp-ratio' => '4:8:12'];
        $this->form[] = ['label' => 'Designation', 'name' => 'designation_id', 'type' => 'hidden', 'width' => 'col-sm-10', 'datatable' => 'mst_designation,id', 'cmp-ratio' => '4:8:12'];
        $this->form[] = ['label' => 'Cancelled Date BS', 'name' => 'cancelled_date_bs', 'type' => 'text-c', 'validation' => 'required', 'width' => 'col-sm-10', 'cmp-ratio' => '4:8:12'];
        $this->form[] = ['label' => 'Cancelled Date AD', 'name' => 'cancelled_date_ad', 'type' => 'text-c', 'validation' => 'date', 'width' => 'col-sm-10', 'cmp-ratio' => '4:8:12'];

        $this->form[] = ['label' => 'Is Cancelled', 'name' => 'is_cancelled', 'type' => 'radio-c', 'validation' => 'required|integer', 'width' => 'col-sm-10', 'dataenum' => '0|No;1|Yes', 'cmp-ratio' => '4:8:12'];

        $this->form[] = ['label' => 'Reason to Cancel', 'name' => 'cancel_reason', 'type' => 'wysiwyg-c', 'validation' => 'required|min:1|max:500', 'width' => 'col-sm-10', 'cmp-ratio' => '12:6:12'];
        $this->form[] = ['label' => 'Cancelled By', 'name' => 'cancelled_by', 'type' => 'hidden', 'validation' => 'required', 'value' => CRUDBooster::myId()];

        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Vacancy Post Id","name"=>"vacancy_post_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"vacancy_post,id"];
        //$this->form[] = ["label"=>"Applicant Id","name"=>"applicant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"applicant,id"];
        //$this->form[] = ["label"=>"Designation Id","name"=>"designation_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"designation,id"];
        //$this->form[] = ["label"=>"Applied Date Ad","name"=>"applied_date_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Applied Date Bs","name"=>"applied_date_bs","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Is Female","name"=>"is_female","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Is Janajati","name"=>"is_janajati","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Is Madhesi","name"=>"is_madhesi","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Is Dalit","name"=>"is_dalit","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Is Handicapped","name"=>"is_handicapped","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Is Remote Village","name"=>"is_remote_village","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Is Application Confirmed","name"=>"is_application_confirmed","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Token Number","name"=>"token_number","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Amount For Job","name"=>"amount_for_job","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Amount For Priv Grp","name"=>"amount_for_priv_grp","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Amount For Extension","name"=>"amount_for_extension","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Total Amount","name"=>"total_amount","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Age While Applying","name"=>"age_while_applying","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Is Open","name"=>"is_open","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Total Paamount","name"=>"total_paid_amount","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Is Paid","name"=>"is_paid","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Is Cancelled","name"=>"is_cancelled","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Cancelled Date Ad","name"=>"cancelled_date_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Cancelled Date Bs","name"=>"cancelled_date_bs","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Cancel Reason","name"=>"cancel_reason","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Cancelled By","name"=>"cancelled_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
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
        // $user=CRUDBooster::first("cms_users", Session::get("admin_id"));
        // if (isset($user)) {
        //     if ($user->id_cms_privileges != 4) {
        //         $this->addaction[] = ['label'=>'','icon'=>'fa fa-remove','color'=>'warning','url'=>CRUDBooster::mainpath('../vacancy_apply_cancelation/edit').'/[id]'];
        //     }
        // }
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
        $this->script_js = "
        $(document).ready(function(){

                $('#vacancy_post_id').prop('readonly', true);
                $('#applicant_id').prop('readonly', true);
                $('#designation_id').prop('readonly', true);

            var dateTime = new Date();
            dateTime = moment(dateTime).format('YYYY-MM-DD');

            $('#cancelled_date_ad').val(dateTime);

            $('#cancelled_date_bs').val(AD2BS(dateTime));
            $('#cancelled_date_ad').prop('readonly', true);
            $('#cancelled_date_bs').prop('readonly',true);
            });
        ";

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
        //Your code here
        $this->fyearid = Session::get('fiscal_year_id');
        $this->fyearcode = Session::get('fiscal_year_code');

        $fiscal_year_id = Session::get('fiscal_year_id');
        $vacancy_ad_id = DB::table('vacancy_ad')->select('id')->where([['fiscal_year_id', $fiscal_year_id], ['is_deleted', false]])->get();
        foreach ($vacancy_ad_id as $key => $va_id) {
            $va[] = $va_id->id;
        }

        $vacancy_post = DB::table('vacancy_post')->select('id')->whereIn('vacancy_ad_id', $va)->get();
        foreach ($vacancy_post as $key => $vp_id) {
            $vp[] = $vp_id->id;
        }
        $query->whereIn('vacancy_post_id', $vp)
            ->whereIs_cancelled(true);
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

    public function unlinkCancelledApplications($application_id = [])
    {
        // $result =  DB::table('csv_payment_file_details as cd')
        // ->join('vacancy_apply as va', 'cd.token_number', '=', 'va.token_number')
        // ->where([['va.is_cancelled' ,'=', 1],['va.id','=', $application_id]])
        // ->update([['cd.is_linked' => 0],[cd.linked_application_id]=>null]);

        // var_dump($result);
        // die();

        // return $result;

        $result = DB::table('csv_payment_file_details')
            ->where('linked_application_id', '=', $application_id)
            ->first();

        if (is_null($result)) {
            //Do nothing
        } else {
            $arr['is_linked'] = 0;
            $arr['linked_application_id'] = null;
            DB::table('csv_payment_file_details')
                ->where('id', $result->id)
                ->update($arr);
            //$result->save();
        }

        // return DB::update('UPDATE csv_payment_file_details cd
        // INNER JOIN vacancy_apply va ON cd.token_number = va.token_number
        // SET cd.is_linked = 0,
        //  cd.linked_application_id = NULL
        // WHERE
        //     va.is_cancelled = 1
        // AND va.id = ?', $application_id);

        // $result = $result->toArray();
    }

    private function getAppliedVacancy($application_id)
    {
        // return DB::table('vacancy_apply as va')
        //     ->select('va.applicant_id')
        // ->where('va.id', '=', $application_id)
        // ->first();

        return DB::table('vacancy_apply as va')
            ->select('va.cancel_reason', 'va.cancelled_date_ad', 'va.cancelled_date_bs', 'va.is_cancelled', 'va.cancelled_by', 'va.applicant_id', 'vp.mahila_seats', 'vp.janajati_seats', 'vp.madheshi_seats', 'vp.dalit_seats', 'vp.apanga_seats', 'vp.remote_seats', 'ad.ad_title_en as ad_title_en', 'ad.ad_title_np as ad_title_np', 'va.designation_id', 'd.name_en as designation_name_en', 'd.name_np as designation_name_np', 'va.vacancy_post_id', 'l.code as level_code', 'va.amount_for_job as fee', 'va.amount_for_priv_grp as privilege_fee', 'va.total_amount as total', 'va.token_number', 'va.applied_date_ad', 'va.applied_date_bs')
            ->join('vacancy_post as vp', 'va.vacancy_post_id', "=", "vp.id")
            ->leftJoin('vacancy_ad as ad', 'ad.id', '=', 'vp.vacancy_ad_id')
            ->leftJoin('mst_designation as d', 'd.id', '=', 'vp.designation_id')
            ->leftJoin('mst_work_level as l', 'l.id', '=', 'd.work_level_id')
            ->where('va.id', '=', $application_id)
            ->first();
    }

    public function hook_after_edit($id)
    {
        $this->unlinkCancelledApplications($id);

        //Your code here
        $application_data = $this->getAppliedVacancy($id);
        $applicant_id = $application_data->applicant_id;
        $applicant = CRUDBooster::first('applicant_profile', $applicant_id);
        $data = collect($application_data);
        $data = $data->merge($applicant)->all();
        \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_application_cancel']);
        $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_cancel", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_application_cancel']);
        //update log
        $arr['cancel_email_log_path'] = $log_file;
        $arr['is_paid'] = 0;
        $arr['total_paid_amount'] = null;
        $arr['paid_receipt_no'] = null;
        $arr['paid_date_ad'] = null;
        // dd($application_data);
        DB::table('vacancy_apply')
            ->where('id', $id)
            ->update($arr);
        $this->return_url = CRUDBooster::mainpath() . "/detail/" . $id;

        CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_applicants', trans("Application cancelled successfully."), 'success');
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
}
