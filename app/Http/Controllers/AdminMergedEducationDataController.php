<?php namespace App\Http\Controllers;

    use Session;
    use Request;
    use DB;
    use CRUDBooster;
    use Route;
    use Schema;
    use Carbon\Carbon;

class AdminMergedEducationDataController extends BaseCBController
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
        $this->table = "merged_applicant_education";
        $this->getEdit_view = "default.comparision_form";
        $this->getDelete_view = "default.comparision_form";

        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label"=>"Code","name"=>"vacancy_apply_id"];
        $this->col[] = ["label"=>"Council","name"=>"applicant_id"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        // $this->form[] = ['label'=>'Applicant ','name'=>'applicant_id','type'=>'select-c','validation'=>'required|integer|min:0','cmp-ratio'=>'12:2:8','dataquery'=>'SELECT id as value, CONCAT(first_name_en, \'   \', mid_name_en, \' \', last_name_en) AS label FROM applicant_profile'];
        $this->form[] = ['label' => 'Education Level ', 'name' => 'edu_level_id', 'type' => 'select-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:12:12', 'dataquery' => 'SELECT id as value, CONCAT( name_en) AS label FROM mst_edu_level'];
        // $this->form[] = ['label'=>'Education Degree ','name'=>'edu_degree_id','type'=>'select-c','validation'=>'required|max:255','cmp-ratio'=>'6:12:12','dataquery'=>'SELECT id as value, CONCAT( name_en) AS label FROM mst_edu_degree'];
        $this->form[] = ['label' => 'Education Degree ', 'name' => 'edu_degree_id', 'type' => 'select-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_edu_degree,name_np'];
        $this->form[] = ['label' => 'Education Major', 'name' => 'edu_major_id', 'type' => 'select2-c', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_edu_major,name_en', 'parent_select' => 'edu_level_id'];
        // $this->form[] = ['label' => 'Passed Year BS', 'maxlength' => '4', 'name' => 'passed_year_bs', 'id' => 'passed_year_bs', 'type' => 'number-c', 'validation' => 'required|numeric|min:1|max:9999', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Passed Year BS', 'maxlength' => '4', 'name' => 'passed_year_bs', 'id' => 'passed_year_bs', 'type' => 'number-c', 'validation' => 'numeric|min:1|max:9999', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Division ','name' => 'division_id', 'type' => 'select-c', 'validation' => 'max:255', 'cmp-ratio' => '2:12:12', 'dataquery' => 'SELECT id as value, CONCAT( name_en) AS label FROM mst_edu_division'];

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
        $this->script_js = "
        $(document).ready(function(){
            year_ad();
            year_bs();
        });

        function year_ad(){
            var start = 1900;
            var end = new Date().getFullYear();
            var options = '';
            for(var year = start ; year <=end; year++){
              options += '<option>'+ year +'</option>';
            }
            document.getElementById('passed_year_ad').innerHTML = options;
        }

        function year_bs(){
            var start = 1957;
            var end = new Date().getFullYear();
            var end_bs = end + 57;
            var options = '';
            for(var year = start ; year <=end_bs; year++){
              options += '<option>'+ year +'</option>';
            }
            document.getElementById('passed_year_bs').innerHTML = options;
        }
        ";;


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
        $neededUri = str_replace("-save", "", $_SERVER['REQUEST_URI']);
        $this->return_url = $protocol . $_SERVER['HTTP_HOST'] . $neededUri;
        //insert log
        $old_values = json_decode(json_encode($row), true);

        CRUDBooster::insertLog(trans("crudbooster.log_update", ['name' => $this->arr[$this->title_field], 'module' => CRUDBooster::getCurrentModule()->name]), LogsCBController::displayDiff($old_values, $this->arr));
        $this->return_url=CRUDBooster::adminpath().'/applicant_edu_info?applicant_id='.$ap_id.'&va_id='.$va_id;
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
        DB::table('merged_applicant_education')
            ->where([['applicant_id',$ap_id],['vacancy_apply_id',$va_id]])
            ->update($arr);
        $url=CRUDBooster::adminpath().'/applicant_edu_info?applicant_id='.$ap_id.'&va_id='.$va_id;
        CRUDBooster::redirect($url, trans("Data is approved."), 'success');
    }

    public function verifyMergedData($ap_id,$va_id){
        $arr['is_verified']=1;
        $arr['verified_by']=CRUDBooster::myId();
        $arr['verified_on']= Carbon::now();
        DB::table('merged_applicant_education')
            ->where([['applicant_id',$ap_id],['vacancy_apply_id',$va_id]])
            ->update($arr);
        $url=CRUDBooster::adminpath().'/applicant_edu_info?applicant_id='.$ap_id.'&va_id='.$va_id;
        CRUDBooster::redirect($url, trans("Data is Verified."), 'success');
        

    }
    public function reMergeData($ap_id,$va_id){

        // dd($ap_id,$va_id);
        DB::table('merged_applicant_education')
            ->where([['applicant_id',$ap_id],['vacancy_apply_id',$va_id]])
            ->delete();
        $url=CRUDBooster::adminpath().'/applicant_edu_info?applicant_id='.$ap_id.'&va_id='.$va_id;
        CRUDBooster::redirect($url, trans("Data is remerged."), 'success');
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
        $applicant=DB::table('merged_applicant_education')->select('applicant_id','vacancy_apply_id')->where('id',$id)->first();
        $erp_data=DB::select(
            'SELECT 
            mel.id as education_level_id
            ,mel.name_en AS education_level
            ,med.id AS degree_id
            ,med.name_en AS education_degree
            ,mem.id AS major_id
            ,mem.name_en AS education_major
            ,medi.id AS division_id
            ,medi.name_en AS division 
            ,aei.passed_year_ad
            ,aei.passed_year_bs
            FROM applicant_edu_info aei
            LEFT JOIN mst_edu_level mel ON mel.id=aei.edu_level_id
            LEFT JOIN mst_edu_degree med ON med.id=aei.edu_degree_id
            LEFT JOIN mst_edu_major mem ON mem.id=aei.edu_major_id
            LEFT JOIN mst_edu_division medi ON medi.id=aei.division_id
            WHERE aei.applicant_id=:applicant_id',['applicant_id'=>$applicant->applicant_id]);
        
        $recruit_data=DB::select(
            'SELECT 
            mel.id as education_level_id
            ,mel.name_en AS education_level
            ,med.id AS degree_id
            ,med.name_en AS education_degree
            -- ,mem.id AS major_id
            -- ,mem.name_en AS education_major
            ,medi.id AS division_id
            ,medi.name_en AS division 
            ,aei.passed_year_ad
            ,aei.passed_year_bs
            FROM applied_applicant_edu_info aei
            LEFT JOIN mst_edu_level mel ON mel.id=aei.edu_level_id
            LEFT JOIN mst_edu_degree med ON med.id=aei.edu_degree_id
            LEFT JOIN mst_edu_major mem ON mem.id=aei.edu_major_id
            LEFT JOIN mst_edu_division medi ON medi.id=aei.division_id
            WHERE applicant_id=:applicant_id
            and vacancy_apply_id=:vacancy_apply_id',['applicant_id'=>$applicant->applicant_id,'vacancy_apply_id'=>$applicant->vacancy_apply_id]);

        $merged_data=DB::select(
            'SELECT 
            mel.id as education_level_id
            ,mel.name_en AS education_level
            ,med.id AS degree_id
            ,med.name_en AS education_degree
            ,mem.id AS major_id
            ,mem.name_en AS education_major
            ,medi.id AS division_id
            ,medi.name_en AS division 
            ,aei.passed_year_ad
            ,aei.passed_year_bs
            FROM merged_applicant_education aei
            LEFT JOIN mst_edu_level mel ON mel.id=aei.edu_level_id
            LEFT JOIN mst_edu_degree med ON med.id=aei.edu_degree_id
            LEFT JOIN mst_edu_major mem ON mem.id=aei.edu_major_id
            LEFT JOIN mst_edu_division medi ON medi.id=aei.division_id
            WHERE aei.id=:id',['id'=>$id]);

         $is_matched=$this->getIdenticalData($merged_data,$recruit_data);
         if($is_matched){
             $arr['flag']="correct";
             $arr['mismatched_key']="";
             DB::table('merged_applicant_education')
             ->where('id', $id)
             ->update($arr);
         }
         else{
             $compare_result=$this->CompareArray($merged_data,$erp_data,$recruit_data);
             if($compare_result=="only_in_erp"){
                 $arr['flag']="only_in_erp";
                 $arr['mismatched_key']="";
                 DB::table('merged_applicant_education')
                 ->where('id', $id)
                 ->update($arr);
             }
             elseif($compare_result=="missing_in_erp"){
                 $arr['flag']="missing_in_erp";
                 $arr['mismatched_key']="";
                 DB::table('merged_applicant_education')
                 ->where('id', $id)
                 ->update($arr);
             }
             else{
                 $arr['flag']="mistakes";
                 $arr['mismatched_key']=$compare_result;
                 DB::table('merged_applicant_education')
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

    public function CompareArray($array1,$array2){
        // getting only in erp data
        $only_in_erp=true;
         foreach($array2 as $erp){
             foreach($array1 as $recruit){
                if($recruit->education_degree==$erp->education_degree && $recruit->education_major==$erp->education_major){
                     $only_in_erp=false;
                 }
             }
         }
         if($only_in_erp)
             return 'only_in_erp';
         // getting missing in erp data and mismatched data
         $not_in_erp=true;
         foreach($array1 as $recruit){
             foreach($array2 as $erp){
                if($recruit->education_degree==$erp->education_degree && $recruit->education_major==$erp->education_major){
                     $not_in_erp=false;
                     $arr1=json_decode(json_encode($recruit), true);
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
         foreach ($array1 as $key => $value) {
             foreach($array2 as $key2=> $value2){
                     $arr1=json_decode(json_encode($value), true);
                     $arr2=json_decode(json_encode($value2), true);
                     $result=array_diff_assoc($arr2,$arr1);
                     if(count($result)==0){
                         $common_data=true;
                     }
                 }
             }
             return $common_data;
         }



    //By the way, you can still create your own method in here... :)
}
