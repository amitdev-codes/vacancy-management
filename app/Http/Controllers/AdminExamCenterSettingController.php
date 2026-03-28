<?php namespace App\Http\Controllers;

	use App\Models\VacancyPost;
    use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use Schema;
	use CB;

	ini_set('max_execution_time', 300); 
	class AdminExamCenterSettingController extends BaseCBController {

	    public function cbInit() {
	    	# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->table 			   = "exam_center_setting";
			$this->title_field         = "id";
			$this->limit               = 10;
			$this->orderby             = "id,desc";
			$this->show_numbering      = FALSE;
			$this->global_privilege    = FALSE;
			$this->button_table_action = TRUE;
			$this->button_action_style = "button_icon";
			$this->button_add          = TRUE;
			$this->button_delete       = TRUE;
			$this->button_edit         = TRUE;
			$this->button_detail       = TRUE;
			$this->button_show         = TRUE;
			$this->button_filter       = TRUE;
			$this->button_export       = FALSE;
			$this->button_import       = FALSE;
			$this->button_bulk_action  = false;
			$this->getAdd_view='exam.center_setting';
            $this->getIndex_view = "default.vacancy.AdwiseIndex";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
	    $this->col = array();
		  $this->col[] = array("label"=>"Paper Id","name"=>"paper_id","join"=>"vacancy_post_paper,paper_name_np");
		  $this->col[] = array("label"=>"Vacancy Post","name"=>"vacancy_post_id","join"=>"vacancy_post,ad_no");
		  $this->col[] = array("label"=>"Remarks","name"=>"remarks");

			# END COLUMNS DO NOT REMOVE THIS LINE
			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ["label" => "Vacancy Ad", "name" => "vacancy_ad_id", "cmp-ratio" => "6:3:9", "type" => "select-c", "required" => true, "validation" => "required|min:0", "datatable" => "vacancy_ad,ad_title_en"];
    $this->form[] = ["label" => "Vacancy Post", "name" => "vacancy_post_id", "cmp-ratio" => "6:3:9", "type" => "select-c", "required" => true, "validation" => "required|min:0", "datatable" => "vacancy_post,ad_no", "parent_select" => "vacancy_ad_id"];

    $this->form[] = ["label" => "Paper", "name" => "paper_id", "cmp-ratio" => "6:3:9", "type" => "select-c", "required" => true, "validation"=> "required|integer|min:0", "datatable" => "vacancy_post_paper,paper_name_en", "cmp-ratio" => "6:3:9", "parent_select" => "vacancy_post_id"];
		
			# END FORM DO NOT REMOVE THIS LINE
		$centers = [];
		//$columns[] = ['label'=>'Ad No','name'=>'ad_no','type'=>'text','validation'=>'','width'=>'col-sm-10'];
		$centers[] = ['label'=>'Center','name'=>'center_id','type'=>'datamodal','datamodal_table'=>'mst_exam_centre', "required" => true,'datamodal_columns'=>'name_np','datamodal_select_to'=>'id:name_np','datamodal_size'=>'large'];
		
		$centers[] = ['label'=>'No.of candidates','name'=>'max_candidates','type'=>'number', 'value'=>"0"];

		// $centers[] = ['label'=>'No.of candidates','name'=>'max_candidates', "required" => true,'type'=>'number', 'value'=>"0"];
		$centers[] = ['label'=>'Roll start','name'=>'roll_start','type'=>'number', 'value'=>"0"];
		$centers[] = ['label'=>'Roll end','name'=>'roll_end','type'=>'number', 'value'=>"0"];
		
		$this->form[] = ['label'=>'Exam Centers','name'=>'paper_exam_centers','type'=>'child-custom-exam-center','columns'=>$centers,'table'=>'paper_exam_centers','foreign_key'=>'paper_exam_centers.esc_id'];

		$this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"textarea-c","validation"=>"string|min:5|max:5000"];
		
			/*
	        | ----------------------------------------------------------------------
	        | Sub Module
	        | ----------------------------------------------------------------------
			| @label          = Label of action
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
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
	        | @color 	   = Default is primary. (primary, warning, succecss, info)
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        |
	        */
	        $this->addaction = array();
			$this->addaction[] = ['label' => 'Update Center', 'icon' => 'fa fa-home', 'color' => 'info', 'url' => CRUDBooster::mainpath('../exam/updatecenter') . '/[id]'];


	        /*
	        | ----------------------------------------------------------------------
	        | Add More Button Selected
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button
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
	        $this->script_js = NULL;


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
	      	$this->load_js[] = asset("js/center_setting.js");
			


	        /*
	        | ----------------------------------------------------------------------
	        | Add css style at body
	        | ----------------------------------------------------------------------
	        | css code in the variable
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;



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

		public function postAddSave() {

			$this->is_add = true;
			$this->cbLoader();
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE) {
				CRUDBooster::insertLog(trans('crudbooster.log_try_add_save',['name'=>Request::input($this->title_field),'module'=>CRUDBooster::getCurrentModule()->name ]));
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
	
			$this->validation();
			$this->input_assignment();
	
			if(Schema::hasColumn($this->table, 'created_at'))
			{
				$this->arr['created_at'] = date('Y-m-d H:i:s');
			}
	
			$this->hook_before_add($this->arr);
	
			if(!isset($this->arr[$this->primary_key])){
				// $id = DB::table($this->table)->insertGetId($this->arr);
				$this->arr[$this->primary_key] = $id = CRUDBooster::newId($this->table);
			}
			else{
				$id=$this->arr[$this->primary_key];
			}
			unset($this->arr['paper_exam_centers']);
			$this->arr['fiscal_year_id']=Session::get('fiscal_year_id');
			DB::table($this->table)->insert($this->arr);
	
	
			//Looping Data Input Again After Insert
			foreach($this->data_inputan as $ro) {
				$name = $ro['name'];
				if(!$name) continue;
	
				$inputdata = Request::get($name);
	
				//Insert Data Checkbox if Type Datatable
				if($ro['type'] == 'checkbox' || $ro['type'] == 'checkbox-2') {
					if($ro['relationship_table']) {
						$datatable = explode(",",$ro['datatable'])[0];
						$foreignKey2 = CRUDBooster::getForeignKey($datatable,$ro['relationship_table']);
						$foreignKey = CRUDBooster::getForeignKey($this->table,$ro['relationship_table']);
						DB::table($ro['relationship_table'])->where($foreignKey,$id)->delete();
	
						if($inputdata) {
							$relationship_table_pk = CB::pk($ro['relationship_table']);
							foreach($inputdata as $input_id) {
								DB::table($ro['relationship_table'])->insert([
									$relationship_table_pk=>CRUDBooster::newId($ro['relationship_table']),
									$foreignKey=>$id,
									$foreignKey2=>$input_id
									]);
							}
						}
	
					}
				}
	
	
				if($ro['type'] == 'select2' || $ro['type'] == 'select2-c') {
					if($ro['relationship_table']) {
						$datatable = explode(",",$ro['datatable'])[0];
						$foreignKey2 = CRUDBooster::getForeignKey($datatable,$ro['relationship_table']);
						$foreignKey = CRUDBooster::getForeignKey($this->table,$ro['relationship_table']);
						DB::table($ro['relationship_table'])->where($foreignKey,$id)->delete();
	
						if($inputdata) {
							foreach($inputdata as $input_id) {
								$relationship_table_pk = CB::pk($row['relationship_table']);
								DB::table($ro['relationship_table'])->insert([
									$relationship_table_pk=>CRUDBooster::newId($ro['relationship_table']),
									$foreignKey=>$id,
									$foreignKey2=>$input_id
									]);
							}
						}
	
					}
				}
	
			
				if($ro['type']=='child-custom-exam-center') {
					$name = str_slug($ro['label'],'');
					$columns = $ro['columns'];
					$count_input_data = count(Request::get($name.'-'.$columns[0]['name']))-1;
					$child_array = [];
	
					for($i=0;$i<=$count_input_data;$i++) {
						$fk = $ro['foreign_key'];
						$column_data = [];
						$column_data[$fk] = $id;
						foreach($columns as $col) {
							$colname = $col['name'];
							$column_data[$colname] = Request::get($name.'-'.$colname)[$i];
						}
						$child_array[] = $column_data;
					}
	
					$childtable = CRUDBooster::parseSqlTable($ro['table'])['table'];
					DB::table($childtable)->insert($child_array);
				}
			}
	
	
			$this->hook_after_add($this->arr[$this->primary_key]);
	
	
			$this->return_url = ($this->return_url)?$this->return_url:Request::get('return_url');
	
			//insert log
			CRUDBooster::insertLog(trans("crudbooster.log_add",['name'=>$this->arr[$this->title_field],'module'=>CRUDBooster::getCurrentModule()->name]));
	
			if($this->return_url) {
				if(Request::get('submit') == trans('crudbooster.button_save_more')) {
					CRUDBooster::redirect(Request::server('HTTP_REFERER'),trans("crudbooster.alert_add_data_success"),'success');
				}else{
					CRUDBooster::redirect($this->return_url,trans("crudbooster.alert_add_data_success"),'success');
				}
	
			}else{
				if(Request::get('submit') == trans('crudbooster.button_save_more')) {
					CRUDBooster::redirect(CRUDBooster::mainpath('add'),trans("crudbooster.alert_add_data_success"),'success');
				}else{
					CRUDBooster::redirect(CRUDBooster::mainpath(),trans("crudbooster.alert_add_data_success"),'success');
				}
			}
		}

		public function postEditSave($id) {
			$this->hide_form = ["vacancy_post_id"];
			$this->is_edit = true;
			$this->cbLoader();
			$row = DB::table($this->table)->where($this->primary_key,$id)->first();
	
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {
				CRUDBooster::insertLog(trans("crudbooster.log_try_add",['name'=>$row->{$this->title_field},'module'=>CRUDBooster::getCurrentModule()->name]));
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
			}
	
			$this->validation($id);
			$this->input_assignment($id);
	
			if (Schema::hasColumn($this->table, 'updated_at'))
			{
				$this->arr['updated_at'] = date('Y-m-d H:i:s');
			}
	
	
			$this->hook_before_edit($this->arr,$id);
			unset($this->arr['paper_exam_centers']);
			DB::table($this->table)->where($this->primary_key,$id)->update($this->arr);
	
	
	
			//Looping Data Input Again After Insert
			foreach($this->data_inputan as $ro) {
	
	
				$name = $ro['name'];
				if(!$name) continue;
	
				$inputdata = Request::get($name);
	
				//Insert Data Checkbox if Type Datatable
				if($ro['type'] == 'checkbox' || $ro['type'] == 'checkbox-c') {
					if($ro['relationship_table']) {
						$datatable = explode(",",$ro['datatable'])[0];
	
						$foreignKey2 = CRUDBooster::getForeignKey($datatable,$ro['relationship_table']);
						$foreignKey = CRUDBooster::getForeignKey($this->table,$ro['relationship_table']);
						DB::table($ro['relationship_table'])->where($foreignKey,$id)->delete();
	
						if($inputdata) {
							foreach($inputdata as $input_id) {
								$relationship_table_pk = CB::pk($ro['relationship_table']);
								DB::table($ro['relationship_table'])->insert([
									$relationship_table_pk=>CRUDBooster::newId($ro['relationship_table']),
									$foreignKey=>$id,
									$foreignKey2=>$input_id
									]);
							}
						}
	
	
					}
				}
	
	
				if($ro['type'] == 'select2' || $ro['type'] == 'select2-c') {
					if($ro['relationship_table']) {
						$datatable = explode(",",$ro['datatable'])[0];
	
						$foreignKey2 = CRUDBooster::getForeignKey($datatable,$ro['relationship_table']);
						$foreignKey = CRUDBooster::getForeignKey($this->table,$ro['relationship_table']);
						DB::table($ro['relationship_table'])->where($foreignKey,$id)->delete();
	
						if($inputdata) {
							foreach($inputdata as $input_id) {
								$relationship_table_pk = CB::pk($ro['relationship_table']);
								DB::table($ro['relationship_table'])->insert([
									$relationship_table_pk=>CRUDBooster::newId($ro['relationship_table']),
									$foreignKey=>$id,
									$foreignKey2=>$input_id
									]);
							}
						}
	
	
					}
				}
	
				if($ro['type']=='child-custom-exam-center') {
					$name = str_slug($ro['label'],'');
					$columns = $ro['columns'];
					$count_input_data = count(Request::get($name.'-'.$columns[0]['name']))-1;
					$child_array = [];
					$childtable = CRUDBooster::parseSqlTable($ro['table'])['table'];
					$fk = $ro['foreign_key'];
	
					DB::table($childtable)->where($fk,$id)->delete();
					$lastId = CRUDBooster::newId($childtable);
					$childtablePK = CB::pk($childtable);
	
					for($i=0;$i<=$count_input_data;$i++) {
	
						$column_data = [];
						$column_data[$childtablePK] = $lastId;
						$column_data[$fk] = $id;
						foreach($columns as $col) {
							$colname = $col['name'];
							$column_data[$colname] = Request::get($name.'-'.$colname)[$i];
						}
						$child_array[] = $column_data;
	
						$lastId++;
					}
	
					$child_array = array_reverse($child_array);
	
					DB::table($childtable)->insert($child_array);
				}
	
	
			}
	
			$this->hook_after_edit($id);
	
	
			$this->return_url = ($this->return_url)?$this->return_url:Request::get('return_url');
			$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
			$neededUri=str_replace("-save","",$_SERVER['REQUEST_URI']);
			$this->return_url=$protocol.$_SERVER['HTTP_HOST'].$neededUri;
			//insert log
			$old_values = json_decode(json_encode($row),true);
			CRUDBooster::insertLog(trans("crudbooster.log_update",['name'=>$this->arr[$this->title_field],'module'=>CRUDBooster::getCurrentModule()->name]), LogsCBController::displayDiff($old_values, $this->arr));
	
			if($this->return_url) {
				CRUDBooster::redirect($this->return_url,trans("crudbooster.alert_update_data_success"),'success');
			}else{
				if(Request::get('submit') == trans('crudbooster.button_save_more')) {
					CRUDBooster::redirect(CRUDBooster::mainpath('add'),trans("crudbooster.alert_update_data_success"),'success');
				}else{
					CRUDBooster::redirect(CRUDBooster::mainpath(),trans("crudbooster.alert_update_data_success"),'success');
				}
			}
		}


		public function getTotalApplicant(Request $request) {
			$post_id = Request::get('vacancy_post_id');
			$post=DB::table('vacancy_post')
			->select('designation_id')
			->where('id',$post_id)
			->first();

			$d_id=$post->designation_id;
			$paper_id = Request::get('paper_id');
			$data=DB::table('vw_assigned_center_applicant')
			->select('va_count','vpe_count','diff')
			->where([['vacancy_post_id',$post_id],['paper_id',$paper_id]])
			->first();
			//return $data->address;
			return response()->json(array('data'=> $data), 200);
		}
		public function getCenterCapacity(Request $request){
			$center_id = Request::get('center_id');
			$paper_id = Request::get('paper_id');
			
			$center_capacity=DB::table('mst_exam_centre')
			->select('max_candidate')
			->where('id',$center_id)
			->first();
			
			$paper_exam_dates=DB::table('vacancy_post_exam')
			->select('id','vacancy_post_id','date_ad','time_from')
			->get();

			$requested_paper_exam_date=DB::table('vacancy_post_exam')
			->select('id','vacancy_post_id','date_ad','time_from')
			->where('paper_id',$paper_id)
			->first();

			$requested_group_id=DB::table('vacancy_exam_group_child')
			->select('vacancy_exam_group_id')
			->where('vacancy_post_id',$requested_paper_exam_date->vacancy_post_id)
			->first();

			if(!isset($requested_paper_exam_date)){
				$data['valid_date']=false;
				return response()->json(array('data'=>$data),200);
			}
			$data['is_on_same_date_time']=false;
			$papers_id=array();
			foreach($paper_exam_dates as $ped){
				$paper_group_id=DB::table('vacancy_exam_group_child')
				->select('vacancy_exam_group_id')
				->where('vacancy_post_id',$ped->vacancy_post_id)
				->first();
				if($requested_group_id->vacancy_exam_group_id!=$paper_group_id->vacancy_exam_group_id){
				if($ped->date_ad==$requested_paper_exam_date->date_ad && $ped->time_from==$requested_paper_exam_date->time_from ){
					$data['is_on_same_date_time']=true;
					$papers_id[]=$ped->id;
				}
			}

			}
		

			$data['valid_date']=true;
			$data['center_capacity']=$center_capacity->max_candidate;
			if($data['is_on_same_date_time']){
			// $data['center_assigned_count']= DB::select(DB::raw('select count(*) as count from vacancy_exam where exam_center=1 
			// and paper_id in '.$papers_id));
			$data['center_assigned_count']=DB::table('vacancy_exam')
			->where('exam_center',$center_id)
			->whereIn('paper_id',$papers_id)
			->count();
			}
			else{
			$data['center_assigned_count']=DB::table('vacancy_exam')
			->where([['exam_center',$center_id],['paper_id',$paper_id]])
			->count();
			}
			
			
			$data['diff']=$data['center_capacity']-$data['center_assigned_count'];
			$data['center_id']=$center_id;
			return response()->json(array('data'=> $data), 200);

		}

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for button selected
	    | ----------------------------------------------------------------------
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here

	    }


	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate query of index result
	    | ----------------------------------------------------------------------
	    | @query = current sql query
	    |
	    */
	    public function hook_query_index(&$query) {
            if(!empty(\Illuminate\Support\Facades\Request::all())){
                #get vacancy_ad
                if(!empty(\Illuminate\Support\Facades\Request::get('ad'))){
                    $vp=VacancyPost::filter(Request::get('ad'))->pluck('id');
                    $query->whereIn('exam_center_setting.vacancy_post_id',$vp);
                }
                if(!empty(Request::get('md'))){
                    $vp_id=VacancyPost::FilterByDesignation(Request::get('md'),Request::get('ad'))->pluck('id');
                    $query->where('exam_center_setting.vacancy_post_id',$vp_id);
                }
            }

            $query->where('exam_center_setting.fiscal_year_id',Session::get('fiscal_year_id'));

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
	    	//Your code here
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {
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
	    public function hook_before_edit(&$postdata,$id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }

	
	}