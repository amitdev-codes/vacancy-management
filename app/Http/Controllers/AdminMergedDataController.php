<?php namespace App\Http\Controllers;

    use Session;
    use Request;
    use DB;
    use CRUDBooster;
    use Route;
    use Schema;
    use Carbon\Carbon;
    use Bsdate;
    use DateTime;
    use App\Helpers\Helper;

class AdminMergedDataController extends BaseCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "name_en";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "merged_applicant_service_history";
        $this->getEdit_view = "default.comparision_form";
        $this->getDelete_view = "default.form";

        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label"=>"Code","name"=>"vacancy_apply_id"];
        $this->col[] = ["label"=>"Council","name"=>"applicant_id"];
        $this->col[] = ["label"=>"Council (Nepali)","name"=>"working_office"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form = [];
			//$this->form[] = ['label'=>'Applicant Id','name'=>'applicant_id','type'=>'select2-c','validation'=>'required|integer|min:0','width'=>'col-sm-10','cmp-ratio'=>'4:12:12','datatable'=>'applicant_profile,first_name_np'];
			$this->form[] = ['label'=>'Working Office','name'=>'working_office','type'=>'select2-c','datatable'=>'mst_working_office,name_np','cmp-ratio'=>'4:12:12'];
			$this->form[] = ['label'=>'Designation','name'=>'designation','type'=>'select2-c','datatable'=>'mst_designation,name_np','cmp-ratio'=>'4:12:12'];
			$this->form[] = ['label'=>'Service Group','name'=>'service_group','type'=>'select2-c','datatable'=>'mst_work_service_group,name_np','cmp-ratio'=>'4:12:12'];
			$this->form[] = ['label'=>'Service Subgroup','name'=>'service_subgroup','type'=>'select2-c','datatable'=>'mst_work_service_sub_group,name_np','cmp-ratio'=>'4:12:12'];
			$this->form[] = ['label'=>'Work Level','name'=>'work_level','type'=>'select2-c','datatable'=>'mst_work_level,name_np','cmp-ratio'=>'8:12:3'];

			//$this->form[] = ['label'=>'Job Category','name'=>'job_category_id','type'=>'select2-c','validation'=>'required|min:1|max:255','width'=>'col-sm-10','cmp-ratio'=>'4:12:12','datatable'=>'mst_job_category,name_np'];

			$this->form[] = ['label'=>'Date From Bs','name'=>'date_from_bs','type'=>'date-n','validation'=>'max:255','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];
			$this->form[] = ['label'=>'Date From Ad','name'=>'date_from_ad','type'=>'date-c','validation'=>'date','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];

			$this->form[] = ['label'=>'Date To Bs','name'=>'date_to_bs','type'=>'date-n','validation'=>'max:255','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];
			$this->form[] = ['label'=>'Date To Ad','name'=>'date_to_ad','type'=>'date-c','validation'=>'date','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];


			$this->form[] = ['label'=>'Is Office Incharge','name'=>'is_office_incharge','type'=>'radio-c','validation'=>'required|integer','width'=>'col-sm-10','cmp-ratio'=>'3:12:12','dataenum'=>'1|Is Incharge; 0|Not Incharge'];
			$this->form[] = ['label'=>'Incharge from BS','name'=>'incharge_date_from_bs','type'=>'date-n','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];
			$this->form[] = ['label'=>'Incharge from AD','name'=>'incharge_date_from_ad','type'=>'date-c','validation'=>'date','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];
			$this->form[] = ['label'=>'Incharge to BS','name'=>'incharge_date_to_bs','type'=>'date-n','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];
			$this->form[] = ['label'=>'Incharge to AD','name'=>'incharge_date_to_ad','type'=>'date-c','validation'=>'date','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];

			$this->form[] = ['label'=>'Currently Working at this office','name'=>'is_current','type'=>'radio-c','validation'=>'required|integer','width'=>'col-sm-10','cmp-ratio'=>'3:12:12','dataenum'=>'1|Yes; 0|No'];
			$this->form[] = ['label'=>'Seniority date BS','name'=>'seniority_date_bs','type'=>'date-n','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];
			$this->form[] = ['label'=>'Seniority date AD','name'=>'seniority_date_ad','type'=>'date-c','validation'=>'date','width'=>'col-sm-10','cmp-ratio'=>'3:12:12'];
			$this->form[] = ['label'=>'कोष प्रमाणित दुरी','name'=>'distance_km','type'=>'number-c','width'=>'col-sm-10','cmp-ratio'=>'4:12:4'];

        // # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Code","name"=>"code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Name En","name"=>"name_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Name Np","name"=>"name_np","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        $this->alert        = array();



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
        $this->load_js[] = asset("js/serviceHistory.js");
        $this->load_js[] = asset("js/merged_data.js");



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

    public function getDelete($id)
    {
        // dd($id);
        if(CRUDBooster::myPrivilegeId()==1 || CRUDBooster::myPrivilegeId()==5){
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if($resp != false)
            return $resp;

        $this->is_delete = true;
        $this->cbLoader();
        $isApplicant=false;
        if(Session::get('is_applicant') == 1){
            $data['isApplicant']=true;
            $isApplicant=true;
        }


        $row = DB::table($this->table)->where($this->primary_key, $id)->first();


        //insert log
        if($isapplicant)
        {
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id)[0];
            CRUDBooster::insertLog(trans("crudbooster.log_delete", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]).' with applicant_id '. $applicant_id);
        }
        else
        CRUDBooster::insertLog(trans("crudbooster.log_delete", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name])." with user_id ".CRUDBooster::myId());

        $this->hook_before_delete($id);

        if (CRUDBooster::isColumnExists($this->table, 'deleted_at')) {
            DB::table($this->table)->where($this->primary_key, $id)->update(array('is_deleted'=>true,'deleted_at'=>date('Y-m-d H:i:s')));
        } else {
            DB::table($this->table)->where($this->primary_key, $id)->delete();
        }

        $this->hook_after_delete($id);

        $url = g('return_url') ?: CRUDBooster::referer();

        CRUDBooster::redirect($url, trans("crudbooster.alert_delete_data_success"), 'success');
        }
        else{
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
    
            }
    
    }

    public function getEdit($id)
    {
        if(CRUDBooster::myPrivilegeId()==1 || CRUDBooster::myPrivilegeId()==5){

        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if($resp != false)
            return $resp;

        $this->is_edit = true;
        $this->cbLoader();
        

        $row = DB::table($this->table)->where($this->primary_key, $id)->first();
        

        $page_menu = Route::getCurrentRoute()->getActionName();
        $page_title = trans("crudbooster.edit_data_page_title", ['module' => CRUDBooster::getCurrentModule()->name, 'name' => $row->{$this->title_field}]);
        $command = 'edit';
        Session::put('current_row_id', $id);
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $isApplicant = true;
        }
        if($isApplicant){
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id)[0];
            $desc="Acess route ".CRUDBooster::mainpath()."/edit/".$id.' with applicant id '.$applicant_id;
        }
        else
        $desc="Acess route ".CRUDBooster::mainpath()."/edit/".$id.' with user id'.CRUDBooster::myId();

        CRUDBooster::insertLog($desc);
        //return view('crudbooster::default.form',compact('id','row','page_menu','page_title','command'));
        return view($this->getEdit_view, compact('id', 'row', 'page_menu', 'page_title', 'command', 'isApplicant'));
        }
        else{
        CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));

        }

    }

    public function postEditSave($id)
    {
        if(CRUDBooster::myPrivilegeId()==1 || CRUDBooster::myPrivilegeId()==5){
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if($resp != false)
            return $resp;

        $this->is_edit = true;
        $this->cbLoader();
        $isApplicant=false;
        if(Session::get('is_applicant') == 1){
            $data['isApplicant']=true;
            $isApplicant=true;
        }

        $row = DB::table($this->table)->where($this->primary_key, $id)->first();
        $ap_id=$row->applicant_id;
        $va_id=$row->vacancy_apply_id;
        

        $this->validation($id);
        $this->input_assignment($id);

        if (Schema::hasColumn($this->table, 'updated_at')) {
            $this->arr['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->hook_before_edit($this->arr, $id);
        DB::table($this->table)->where($this->primary_key, $id)->update($this->arr);

        //Looping Data Input Again After Insert
        foreach ($this->data_inputan as $ro) {

            $name = $ro['name'];
            if (!$name) {
                continue;
            }

            $inputdata = Request::get($name);

            //Insert Data Checkbox if Type Datatable
            if ($ro['type'] == 'checkbox' || $ro['type'] == 'checkbox-c') {
                if ($ro['relationship_table']) {
                    $datatable = explode(",", $ro['datatable'])[0];

                    $foreignKey2 = CRUDBooster::getForeignKey($datatable, $ro['relationship_table']);
                    $foreignKey = CRUDBooster::getForeignKey($this->table, $ro['relationship_table']);
                    DB::table($ro['relationship_table'])->where($foreignKey, $id)->delete();

                    if ($inputdata) {
                        foreach ($inputdata as $input_id) {
                            $relationship_table_pk = CB::pk($ro['relationship_table']);
                            DB::table($ro['relationship_table'])->insert([
                                $relationship_table_pk => CRUDBooster::newId($ro['relationship_table']),
                                $foreignKey => $id,
                                $foreignKey2 => $input_id,
                            ]);
                        }
                    }

                }
            }

            if ($ro['type'] == 'select2' || $ro['type'] == 'select2-c') {
                if ($ro['relationship_table']) {
                    $datatable = explode(",", $ro['datatable'])[0];

                    $foreignKey2 = CRUDBooster::getForeignKey($datatable, $ro['relationship_table']);
                    $foreignKey = CRUDBooster::getForeignKey($this->table, $ro['relationship_table']);
                    DB::table($ro['relationship_table'])->where($foreignKey, $id)->delete();

                    if ($inputdata) {
                        foreach ($inputdata as $input_id) {
                            $relationship_table_pk = CB::pk($ro['relationship_table']);
                            DB::table($ro['relationship_table'])->insert([
                                $relationship_table_pk => CRUDBooster::newId($ro['relationship_table']),
                                $foreignKey => $id,
                                $foreignKey2 => $input_id,
                            ]);
                        }
                    }

                }
            }

            if ($ro['type'] == 'child') {
                $name = str_slug($ro['label'], '');
                $columns = $ro['columns'];
                $count_input_data = count(Request::get($name . '-' . $columns[0]['name'])) - 1;
                $child_array = [];
                $childtable = CRUDBooster::parseSqlTable($ro['table'])['table'];
                $fk = $ro['foreign_key'];

                DB::table($childtable)->where($fk, $id)->delete();
                $lastId = CRUDBooster::newId($childtable);
                $childtablePK = CB::pk($childtable);

                for ($i = 0; $i <= $count_input_data; $i++) {

                    $column_data = [];
                    $column_data[$childtablePK] = $lastId;
                    $column_data[$fk] = $id;
                    foreach ($columns as $col) {
                        $colname = $col['name'];
                        $column_data[$colname] = Request::get($name . '-' . $colname)[$i];
                    }
                    $child_array[] = $column_data;

                    $lastId++;
                }

                $child_array = array_reverse($child_array);

                DB::table($childtable)->insert($child_array);
            }

        }

        $this->hook_after_edit($id);

        $this->return_url = ($this->return_url) ? $this->return_url : Request::get('return_url');
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
        $neededUri = str_replace("-save", "", $_SERVER["REQUEST_URI"]);
        $this->return_url = $protocol . $_SERVER["HTTP_HOST"] . $neededUri;
        //insert log
        $old_values = json_decode(json_encode($row), true);

        CRUDBooster::insertLog(trans("crudbooster.log_update", ['name' => $this->arr[$this->title_field], 'module' => CRUDBooster::getCurrentModule()->name]), LogsCBController::displayDiff($old_values, $this->arr));
        $this->return_url=CRUDBooster::adminpath().'/applicant_service_history?applicant_id='.$ap_id.'&va_id='.$va_id;
        if ($this->return_url) {
            CRUDBooster::redirect($this->return_url, trans("crudbooster.alert_update_data_success"), 'success');
        } else {
            if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_update_data_success"), 'success');
            } else {
                CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_update_data_success"), 'success');
            }
        }
    }
    else{
    CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
    }
    }

    public function approveMergedData($ap_id,$va_id){
        $arr['is_approved']=1;
        $arr['approved_by']=CRUDBooster::myId();
        $arr['approved_on']= Carbon::now();
        DB::table('merged_applicant_service_history')
            ->where([['applicant_id',$ap_id],['vacancy_apply_id',$va_id]])
            ->update($arr);
        $url=CRUDBooster::adminpath().'/applicant_service_history?applicant_id='.$ap_id.'&va_id='.$va_id;
        CRUDBooster::redirect($url, trans("Data is approved."), 'success');
    }

    public function verifyMergedData($ap_id,$va_id){
        $arr['is_verified']=1;
        $arr['verified_by']=CRUDBooster::myId();
        $arr['verified_on']= Carbon::now();
        DB::table('merged_applicant_service_history')
            ->where([['applicant_id',$ap_id],['vacancy_apply_id',$va_id]])
            ->update($arr);
        $url=CRUDBooster::adminpath().'/applicant_service_history?applicant_id='.$ap_id.'&va_id='.$va_id;
        CRUDBooster::redirect($url, trans("Data is verified."), 'success');
    }
    public function reMergeData($ap_id,$va_id){
       
        DB::table('merged_applicant_service_history')
            ->where([['applicant_id',$ap_id],['vacancy_apply_id',$va_id]])
            ->delete();
        $url=CRUDBooster::adminpath().'/applicant_service_history?applicant_id='.$ap_id.'&va_id='.$va_id;
        CRUDBooster::redirect($url, trans("Data is re-merged."), 'success');
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
        $postdata['updated_by']=CRUDBooster::myId();
       if($postdata['is_office_incharge']==0){
            $postdata['incharge_date_from_bs']=null;
            $postdata['incharge_date_from_ad']=null;
            $postdata['incharge_date_to_bs']=null;
            $postdata['incharge_date_to_ad']=null;
       };
       if($postdata['is_current']==0){
        $postdata['seniority_date_bs']=null;
        $postdata['seniority_date_ad']=null;
        $service_merged=DB::table('merged_applicant_service_history')->where('id',$id)->first();
        if($service_merged->is_current==1){
            $ifotherIsCurrentExist=DB::table('merged_applicant_service_history')->where([['vacancy_apply_id',$service_merged->vacancy_apply_id],['is_current',1]])->get();
            if(count($ifotherIsCurrentExist)==1){
                $url = g('return_url') ?: CRUDBooster::referer();
                CRUDBooster::redirect($url, trans("This the only current data of this applicant."), 'warning');
            }
        }
        }
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
        $applicant=DB::table('merged_applicant_service_history')->select('applicant_id','work_level','vacancy_apply_id')->where('id',$id)->first();
        // getting current level
        $data['apply_info']=DB::table('vw_vacancy_applicant_file_pormotion')
            ->where('id',$applicant->vacancy_apply_id)
			->first();

			$level=(int)$data['apply_info']->work_level - 1;
            $work_level_id=DB::table('mst_work_level')->where('name_en',$level)->first();
        $erp_data=$this->getErpData($applicant->applicant_id);
        $recruit_data=DB::select(
            'SELECT
            mwo.name_en as working_office
            ,mwo.id as working_office_id
            ,md.name_en as designation
            ,md.id as designation_id
            ,mwsg.name_en as service_group
            ,mwsg.id as service_group_id
            ,mwl.name_en as work_level
            ,mwl.id as work_level_id
            ,ash.date_from_ad
            ,ash.date_to_ad
            ,ash.date_from_bs
            ,ash.date_to_ad
            ,ash.date_to_bs
            ,ash.seniority_date_ad
            ,ash.seniority_date_bs
            ,case when ash.is_office_incharge = 1 then "YES" ELSE "NO" END as is_office_incharge
            ,ash.incharge_date_from_ad
            ,ash.incharge_date_to_ad
            ,ash.incharge_date_to_bs
            ,ash.incharge_date_from_bs
            ,case when ash.is_current = 1 then "YES" ELSE "NO" END as is_current
            ,ash.seniority_date_ad
            FROM applicant_service_history ash
            LEFT JOIN mst_working_office mwo ON mwo.id=ash.working_office
            LEFT JOIN mst_designation md ON md.id=ash.designation
            LEFT JOIN mst_work_service_group mwsg ON mwsg.id=ash.service_group
            LEFT JOIN mst_work_service_sub_group mwssg ON mwssg.id=ash.service_subgroup
            LEFT JOIN mst_work_level mwl ON mwl.id=ash.work_level
            WHERE ash.applicant_id=:applicant_id and ash.work_level=:work_level 
            ORDER BY date_from_bs desc',['applicant_id'=>$applicant->applicant_id,'work_level'=>$work_level_id->id]);
       
        
        $merged_data=DB::select(
            'SELECT
        mwo.name_en as working_office
            ,mwo.id as working_office_id
            ,md.name_en as designation
            ,md.id as designation_id
            ,mwsg.name_en as service_group
            ,mwsg.id as service_group_id
            ,mwl.name_en as work_level
            ,mwl.id as work_level_id
            ,ash.date_from_ad
            ,ash.date_from_bs
            ,ash.date_to_ad
            ,ash.date_to_bs
            ,ash.incharge_date_from_ad
            ,ash.incharge_date_from_bs
            ,ash.incharge_date_to_ad
            ,ash.incharge_date_to_bs
            ,ash.seniority_date_ad
            ,ash.seniority_date_bs
            ,case when ash.is_office_incharge = 1 then "YES" ELSE "NO" END as is_office_incharge
            ,ash.incharge_date_from_ad
            ,ash.incharge_date_from_bs
            ,ash.incharge_date_to_ad
            ,ash.incharge_date_to_bs
            ,case when ash.is_current = 1 then "YES" ELSE "NO" END as is_current
            ,ash.seniority_date_ad
        FROM merged_applicant_service_history ash
        LEFT JOIN mst_working_office mwo ON mwo.id=ash.working_office
        LEFT JOIN mst_designation md ON md.id=ash.designation
        LEFT JOIN mst_work_service_group mwsg ON mwsg.id=ash.service_group
        LEFT JOIN mst_work_service_sub_group mwssg ON mwssg.id=ash.service_subgroup
        LEFT JOIN mst_work_level mwl ON mwl.id=ash.work_level
        WHERE ash.id=:id
        ORDER BY ash.date_from_bs desc',['id'=>$id]);

        $is_matched=$this->getIdenticalData($merged_data,$recruit_data);
        if($is_matched){
            $arr['flag']="correct";
            $arr['mismatched_key']="";
            DB::table('merged_applicant_service_history')
            ->where('id', $id)
            ->update($arr);
        }
        else{
            $compare_result=$this->CompareArray($merged_data,$erp_data,$recruit_data);
            if($compare_result=="only_in_erp"){
                $arr['flag']="only_in_erp";
                $arr['mismatched_key']="";
                DB::table('merged_applicant_service_history')
                ->where('id', $id)
                ->update($arr);
            }
            elseif($compare_result=="missing_in_erp"){
                $arr['flag']="missing_in_erp";
                $arr['mismatched_key']="";
                DB::table('merged_applicant_service_history')
                ->where('id', $id)
                ->update($arr);
            }
            else{
                $arr['flag']="mistakes";
                $arr['mismatched_key']=$compare_result;
                DB::table('merged_applicant_service_history')
                ->where('id', $id)
                ->update($arr);

            }

        }
        
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
        $service_merged=DB::table('merged_applicant_service_history')->where('id',$id)->first();
        if($service_merged->is_current==1){
            $ifotherIsCurrentExist=DB::table('merged_applicant_service_history')->where([['vacancy_apply_id',$service_merged->vacancy_apply_id],['is_current',1]])->get();
            if(count($ifotherIsCurrentExist)==1){
                $url = g('return_url') ?: CRUDBooster::referer();
                CRUDBooster::redirect($url, trans("Unable to delete.There must be one current data."), 'warning');
            }
        }
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
    public function CompareArray($array1,$array2,$array3){
       // getting only in erp data
       $only_in_erp=true;
        foreach($array1 as $merged_data){
            foreach($array3 as $recruit_data){
                if($recruit_data->working_office==$merged_data->working_office && $recruit_data->designation==$merged_data->designation && $recruit_data->date_from_bs==$merged_data->date_from_bs){
                    $only_in_erp=false;
                }
            }
        }
        if($only_in_erp)
            return 'only_in_erp';
        // getting missing in erp data and mismatched data
        $not_in_erp=true;
        foreach($array1 as $merged_data){
            foreach($array2 as $erp){
                if($merged_data->working_office==$erp->working_office && $merged_data->designation==$erp->designation && $merged_data->date_from_bs==$erp->date_from_bs){
                    $not_in_erp=false;
                    $arr1=json_decode(json_encode($merged_data), true);
                    $arr2=json_decode(json_encode($erp), true);
                    $result=array_diff_assoc($arr2,$arr1);
                    if(count($result)>0){
                        $mismatchedkeys="";
                        foreach($result as $key=> $value){
                            $mismatchedkeys=$mismatchedkeys.'-'.$key;
                        }
                    }
                }
            }
        }
        if($not_in_erp)
            return 'missing_in_erp';
        if(isset($mismatchedkeys))
        {
          return $mismatchedkeys;
        }
    }

    public function getIdenticalData($array1,$array2){
        $common_data=false;
        foreach($array1 as $merged_data){
            foreach($array2 as $recruit_data){
                if($merged_data->working_office==$recruit_data->working_office && $merged_data->designation==$recruit_data->designation && $merged_data->date_from_bs==$recruit_data->date_from_bs){
                    $arr1=json_decode(json_encode($merged_data), true);
                    $arr2=json_decode(json_encode($recruit_data), true);
                    $result=array_diff_assoc($arr2,$arr1);
                    if(count($result)==0){
                        $common_data=true;
                    }
                }
            }
        }
        return $common_data;
    }

    public function getErpData($applicant_id){
        $emp_no=DB::table('applicant_profile')->select('nt_staff_code')->where('id',$applicant_id)->first();

        $erp_data= DB::select(
            'SELECT 
            t1.start_date AS date_from_ad,
             t1.end_date AS date_to_ad,
            t1.job_id,
            t1.org_id,
            t1.seniority_date_bs AS seniority_date_bs,
            t1.seniority_Date AS seniority_date_ad,
            t5.name_en AS working_office,
            t5.id AS working_office_id,
            t7.name_en AS designation,
            t7.id AS designation_id,
            t8.name_en AS service_group,
            t8.id AS service_group_id,
            t9.name_en AS work_level,
            t9.id AS work_level_id,
            CASE 
                WHEN t1.incharge = 1 THEN \'YES\' 
                ELSE \'NO\' 
            END AS is_office_incharge,
            CASE 
                WHEN t1.incharge = 1 THEN t1.start_date 
                ELSE NULL 
            END AS incharge_date_from_ad,
            CASE 
                WHEN t1.incharge = 1 THEN t1.end_date 
                ELSE NULL 
            END AS incharge_date_to_ad 
            FROM erp_service_history t1
            INNER JOIN applicant_profile t4 ON t4.nt_staff_code = t1.emp_no 
            LEFT JOIN erp_organization t3 ON t3.id = t1.org_id
            LEFT JOIN mst_working_office t5 ON t5.id = t3.working_office_id
            LEFT JOIN erp_jobs t6 ON t6.id = t1.job_id
            LEFT JOIN mst_designation t7 ON t7.id = t6.designation_id
            LEFT JOIN mst_work_service_group t8 ON t8.id = t6.service_group_id
            LEFT JOIN mst_work_level t9 ON t9.name_en = t1.grade 
            WHERE t1.emp_no=:emp_no and t1.seniority_Date=(SELECT MAX(seniority_Date) from erp_service_history WHERE emp_no=:emp_no1)
            ORDER by t1.start_date',['emp_no'=>$emp_no->nt_staff_code,'emp_no1'=>$emp_no->nt_staff_code]);

            // $erp_data=$this->removeDuplicatieData($erp_data);
            foreach($erp_data as $key => $erd){
                $date_from=explode('-',$erd->date_from_ad);
                if((int)$date_from[0]<=2022 && (int)$date_from[0]>=1944){
                    $date_from_bs=Helper::get_nepali_date($date_from[0],$date_from[1],$date_from[2]);
                    $erp_data[$key]->date_from_bs=$date_from_bs['year'].'-'.$date_from_bs['month'].'-'.$date_from_bs['date'];
                }
                $date_to=explode('-',$erd->date_to_ad);
                if((int)$date_to[0]<=2022 && (int)$date_to[0]>=1944){
                    $date_to_bs=Helper::get_nepali_date($date_to[0],$date_to[1],$date_to[2]);
                    $erp_data[$key]->date_to_bs=$date_to_bs['year'].'-'.$date_to_bs['month'].'-'.$date_to_bs['date'];
                }
                $incharge_date_from=explode('-',$erd->incharge_date_from_ad);
                if((int)$incharge_date_from[0]<=2022 && (int)$incharge_date_from[0]>=1944){
                    $incharge_date_from_bs=Helper::get_nepali_date($incharge_date_from[0],$incharge_date_from[1],$incharge_date_from[2]);
                    $erp_data[$key]->incharge_date_from_bs=$incharge_date_from_bs['year'].'-'.$incharge_date_from_bs['month'].'-'.$incharge_date_from_bs['date'];
                }
                $incharge_date_to=explode('-',$erd->incharge_date_to_ad);
                if((int)$incharge_date_to[0]<=2022 && (int)$incharge_date_to[0]>=1944){
                    $incharge_date_to_bs=Helper::get_nepali_date($incharge_date_to[0],$incharge_date_to[1],$incharge_date_to[2]);
                    $erp_data[$key]->incharge_date_to_bs=$incharge_date_to_bs['year'].'-'.$incharge_date_to_bs['month'].'-'.$incharge_date_to_bs['date'];
                }
            }
            $erp_data=$this->transformToRecruitTypeData($erp_data);
            return $erp_data;
    }


    public function transformToRecruitTypeData($arr){
        $trasformarr=[];
        
        // $lastkey=count($arr)-1;
        foreach($arr as $key=>$array){
            if($array->date_to_ad==null){
                $arr[$key]->is_current="YES";
            }
            else{
                $arr[$key]->is_current="NO";
                unset($arr[$key]->seniority_date_ad);
                unset($arr[$key]->seniority_date_bs);
            }

        }
        $duplicate=0;
        $arr=array_reverse($arr);
        foreach($arr as $key=>$array){
            foreach($arr as $key2=> $array2){
                if($array->job_id==$array2->job_id && $array->org_id==$array2->org_id){
                    $duplicate++;
                    if($duplicate>1){
                        //if work is continuos and only change in incharge day
                        $date = new DateTime($array2->date_to_ad);
                        $date->modify('+1 day');
                        if($date->format('Y-m-d')==$array->date_from_ad){
                        if(isset($array2->incharge_date_from_ad)){
                            if($arr[$key]->incharge_date_from_ad > $array2->incharge_date_from_ad)
                                $arr[$key]->incharge_date_from_ad=$array2->incharge_date_from_ad;
                            if($arr[$key]->incharge_date_to_ad < $array2->incharge_date_to_ad)
                                $arr[$key]->incharge_date_to_ad=$array2->incharge_date_to_ad;

                        }
                        $arr[$key]->date_from_ad=$array2->date_from_ad;
                        $arr[$key]->date_from_bs=$array2->date_from_bs;
                        unset($arr[$key2]);
                    }
                    }
                }
            }
            $duplicate=0;		
        }
        $arr=array_reverse($arr);
        foreach($arr as $key=> $array){
            unset($arr[$key]->org_id);
            unset($arr[$key]->job_id);
        }
        return $arr;
    }
    
    //By the way, you can still create your own method in here... :)
}
