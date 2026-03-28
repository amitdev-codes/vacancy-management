<?php namespace App\Http\Controllers;

use Carbon\Carbon;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminInternalRejectedCandidatesController extends BaseCBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "paper_name_en";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "vacancy_post_paper";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Vacancy Post Id","name"=>"vacancy_post_id","join"=>"vacancy_post,id"];
			$this->col[] = ["label"=>"Paper Name En","name"=>"paper_name_en"];
			$this->col[] = ["label"=>"Paper Name Np","name"=>"paper_name_np"];
			$this->col[] = ["label"=>"Remarks","name"=>"remarks"];
			$this->col[] = ["label"=>"Is Deleted","name"=>"is_deleted"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Vacancy Post Id','name'=>'vacancy_post_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'vacancy_post,id'];
			$this->form[] = ['label'=>'Paper Name En','name'=>'paper_name_en','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Paper Name Np','name'=>'paper_name_np','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Remarks','name'=>'remarks','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Is Deleted','name'=>'is_deleted','type'=>'radio','validation'=>'required|integer','width'=>'col-sm-10','dataenum'=>'Array'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Vacancy Post Id","name"=>"vacancy_post_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"vacancy_post,id"];
			//$this->form[] = ["label"=>"Paper Name En","name"=>"paper_name_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Paper Name Np","name"=>"paper_name_np","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Is Deleted","name"=>"is_deleted","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
			# OLD END FORM

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
	        //Your code here
	            
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

			public function getIndex()
			{
					$data = [];
					$data['page_title'] = 'Rejected Candidate-अस्वीकृत नामावली';
					$data['adno_data'] = $this->getVacancyAdNo();
					$this->cbView('rejected_candidate.index', $data);
			}
	
			public function getVacancyAdNo()
			{
					$fiscal_year_id = Session::get('fiscal_year_id');
					$today = Carbon::now();
					$adno_data = DB::table('vacancy_ad as va')
							->select('va.id', 'ad_title_en', 'mj.name_np as opening_type')
							->leftjoin('mst_job_opening_type as mj', 'va.opening_type_id', 'mj.id')
							->where([['va.is_deleted', false], ['fiscal_year_id', $fiscal_year_id]])
							->get();
					return $adno_data;
	
			}
	
			public function getDesignation($id)
			{
					$designation_data = DB::table('vacancy_post as vp')
							->select('md.name_en as designation_en','md.name_np as designation_np', 'vp.designation_id','vp.id')
							->leftjoin('mst_designation as md', 'vp.designation_id','=', 'md.id')
							->where([['vacancy_ad_id', $id], ['vp.is_deleted', false]])
							->get();
	
					// dd($designation_data);
					return $designation_data;
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
					$data['vacancy_ad_id'] = $id;
					$data['id'] = $id;
					$data['ad_id'] = $id;
					$this->ad_id = $id;
	
					#redirect report page according to opening type
					$opening_type_id=DB::table('vacancy_ad')->where([['id',$id],['is_deleted',false]])->select('opening_type_id')->first();
					$ot=$opening_type_id->opening_type_id;
					if($ot==1){
							#for khulla
							$this->cbView('rejected_candidate.index', $data);
					}elseif($ot==2){
							#for internal
							$this->cbView('rejected_candidate.internal_exam_report', $data);
					}else{
							#for filepromotion
							$this->cbView('rejected_candidate.file_promotion_report', $data);
					}
			}
	
			public function getCandidates($ad_id, $id)
			{
	
					//dd($ad_id,$id);
	
					$data = [];
	 
					$designation_id = DB::table('vacancy_post')
							->select('designation_id', 'vacancy_ad_id')
							->where('id', $id)
							->first();
					$opening_type = DB::table('vacancy_ad')
							->select('opening_type_id')
							->where('id', $designation_id->vacancy_ad_id)
							->first();
	
					if ($opening_type->opening_type_id == 1) {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 0], ['mdd.is_additional', 0]])
									->get();
					} elseif ($opening_type->opening_type_id == 2) {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 1], ['mdd.is_additional', 0]])
									->get();
					} else {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 1], ['mdd.is_additional', 0]])
									->get();
					}
	
					$neededTraining = DB::table('mst_designation_training as mdt')
							->select('mdt.training_id as ti', 'mt.name_en as name')
							->leftjoin('mst_training as mt', 'mt.id', '=', 'mdt.training_id')
							->where('mdt.designation_id', $designation_id->designation_id)
							->get();
	
	
	
					if ($opening_type->opening_type_id == 2) {
							$candidate_data = DB::select('select
							distinct t2.exam_roll_no as roll,
							t1.*
							, ms.name_np as current_designation,
							mwl.name_np as work_level,
							t3.seniority_date_bs,mg.name_np as gender
					from
					vw_vacancy_post_rejected_applicant_profile t1
					left join vacancy_exam t2 on
							t1.vacancy_apply_id = t2.vacancy_apply_id
					left join applicant_service_history t3 on
							t1.ap_id = t3.applicant_id
					left join mst_designation ms on
							ms.id = t3.designation
					left join mst_gender mg on
							mg.id = t1.gender
					left join mst_work_level mwl on
							mwl.id = t3.work_level
					where
							t1.is_paid =:is_paid
							and t3.is_current =:is_current
							and t1.vp_id =:id
					and t3.date_to_ad in
					(select max(date_to_ad)from applicant_service_history where applicant_id=t1.ap_id and is_current=:is_current1)
					order by
							applicant_name_en', ['is_paid' => 1, 'is_current' => 1, 'id' => $id, 'is_current1' => 1]);
	
					} elseif ($opening_type->opening_type_id == 3) {
							$candidate_data = DB::select('select distinct t2.exam_roll_no as roll, t1.*,ms.name_np as current_designation,mwo.name_en as working_office,
									mwl.name_np as work_level,t3.seniority_date_bs,t3.minimum_qualification_degree,t3.additional_qualification_degree,t3.minimum_qualification_division,t3.additional_qualification_division,t3.remarks as service_history_remarks
																	from vw_vacancy_post_rejected_applicant_profile t1
																	left join vacancy_exam t2 on t1.vacancy_apply_id = t2.vacancy_apply_id
																	left join applicant_service_history t3 on t1.ap_id=t3.applicant_id
																	left join mst_designation ms on ms.id=t3.designation
																	left join mst_work_level mwl on mwl.id=t3.work_level
																	left join mst_working_office mwo on t3.working_office=mwo.id
											where t3.is_current=1 and t1.vp_id =:id
											order by applicant_name_en', ['id' => $id]);
					} else {
							$candidate_data = DB::table('vw_vacancy_post_rejected_applicant_profile as t1')
									->select('t2.exam_roll_no as roll', 't1.*','mg.name_np as gender')
									->leftjoin('vacancy_exam as t2', 't1.vacancy_apply_id', '=', 't2.vacancy_apply_id')
									->leftjoin('mst_gender as mg', 't1.gender', '=', 'mg.id')
									->where([['t1.is_paid', 1], ['t1.vp_id', $id]])
									->orWhere([['t1.total_paid_amount', '<>', ''], ['t1.vp_id', $id]])
									->orderBy('applicant_name_en')
									->distinct()
									->get();
					}
	
					if ($opening_type->opening_type_id == 3) {
							//$candidate_data = DB::select(DB::raw($sql));
							$candidate_data = collect($candidate_data);
							$candidate_data = $candidate_data->unique('ap_id');
					}
							$education_data = [];
							foreach ($candidate_data as $key=> $cd) {
							$education_data=DB::table('applicant_edu_info as aei')
															->select('aei.id','aei.applicant_id','mel.name_en as edu_level','med.name_en as edu_degree','mem.name_en as edu_major')
															->leftjoin('mst_edu_level as mel','aei.edu_level_id','mel.id')
															->leftjoin('mst_edu_degree as med','aei.edu_degree_id','med.id')
															->leftjoin('mst_edu_major as mem','aei.edu_major_id','mem.id')
															->where([['applicant_id',$cd->ap_id],['aei.is_deleted',false]])
															->orderBY('id','desc')
															->get();
									$cad_education_data[$cd->ap_id]=collect($education_data);
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
	
			 //dd($candidate_data);
	
					$intro_data = DB::select('SELECT mws.name_en as service,mwsg.name_en as service_group,
					va.notice_no,vp.ad_no, va.ad_title_en, vp.designation_id, wl.name_en as work_level, md.name_en as designation,
					vp.total_req_seats
					FROM
							vacancy_post vp
							LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
							left join mst_designation md on md.id = vp.designation_id
							left join mst_work_level wl on wl.id = md.work_level_id
							LEFT JOIN mst_work_service mws on mws.id=md.work_service_id
							left JOIN mst_work_service_group mwsg on mwsg.id=md.service_group_id
							where vp.id =:id', ['id' => $id]);
	
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
											$expereince_data[$cd->ap_id][] = $exd->working_office . '(' . $exd->date_from_bs . '/' . $exd->date_to_bs . ')';
	
									}
	
							}
	
							$data['expereince_data'] = $expereince_data;
					}
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
					$data['md_id'] = $id;
					$data['ad_id'] = $ad_id;
					$data['vacancy_ad_id'] = $ad_id;
					$data['id'] = $ad_id;
					$data['training_data'] = $training_data;;
					$data['candidate_data'] = $candidate_data;
					$data['candidate_education_data'] = $cad_education_data;
					$data['intro_data'] = $intro_data;
					$data['adno_data'] = $this->getVacancyAdNo();
					$data['designation_data'] = $this->getDesignation($ad_id);
					$data['opening_type_id'] = $opening_type->opening_type_id;
					Session::put('selected_candidates_id',$id);
	
					#redirect report page according to opening type
	
					$ot=$opening_type->opening_type_id;
					if($ot==1){
							#for khulla
							$this->cbView('rejected_candidate.open_exam_report', $data);
					}elseif($ot==2){
							#for internal
							$this->cbView('rejected_candidate.internal_exam_report', $data);
					}else{
							#for filepromotion
							$this->cbView('rejected_candidate.file_promotion_report', $data);
					}
	
					// $this->cbView('selected_candidate.index', $data);
	
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
	
			public function getMinDegree($ap_id,$id){
	
				$min_edu_level=DB::table('mst_designation_degree as mdd')->leftjoin('mst_edu_degree as med','med.id','mdd.edu_degree_id')
											 ->where([['mdd.is_for_internal',true],['mdd.designation_id',$id],['is_additional',false]])->distinct('edu_level_id')
											 ->first();
				$applicant_edu_info=DB::table('applicant_edu_info')->where([['is_deleted',false],['edu_level_id',$min_edu_level->edu_level_id],['applicant_id',$ap_id]])
													 ->select('edu_degree_id')->first();
													 return $applicant_edu_info->edu_degree_id;
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
							where va.is_rejected=0
							and aei.edu_degree_id in(
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
	
			public function generateExcel($id)
			{
	
	
	
					$data = [];
					$designation_id = DB::table('vacancy_post')
							->select('designation_id', 'vacancy_ad_id')
							->where('id', $id)
							->first();
					$opening_type = DB::table('vacancy_ad')
							->select('opening_type_id')
							->where('id', $designation_id->vacancy_ad_id)
							->first();
	
					if ($opening_type->opening_type_id == 1) {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 0]])
									->get();
					} elseif ($opening_type->opening_type_id == 2) {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 1]])
									->get();
					} else {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where('mdd.designation_id', $designation_id->designation_id)
									->get();
					}
	
					$neededTraining = DB::table('mst_designation_training as mdt')
							->select('mdt.training_id as ti', 'mt.name_en as name')
							->leftjoin('mst_training as mt', 'mt.id', '=', 'mdt.training_id')
							->where('mdt.designation_id', $designation_id->designation_id)
							->get();
	
	
					if ($opening_type->opening_type_id == 2) {
							$candidate_data = DB::select('select
							distinct t2.exam_roll_no as roll,
							t1.*
							, ms.name_np as current_designation,
							mwl.name_np as work_level,
							t3.seniority_date_bs
					from
					vw_vacancy_post_rejected_applicant_profile t1
					left join vacancy_exam t2 on
							t1.vacancy_apply_id = t2.vacancy_apply_id
					left join applicant_service_history t3 on
							t1.ap_id = t3.applicant_id
					left join mst_designation ms on
							ms.id = t3.designation
					left join mst_work_level mwl on
							mwl.id = t3.work_level
					where
							t1.is_paid =:is_paid
							and t3.is_current =:is_current
							and t1.vp_id =:id
					and t3.date_to_ad in
					(select max(date_to_ad)from applicant_service_history where applicant_id=t1.ap_id and is_current=:is_current1)
					order by
							applicant_name_en', ['is_paid' => 1, 'is_current' => 1, 'id' => $id, 'is_current1' => 1]);
	
					} elseif ($opening_type->opening_type_id == 3) {
							$candidate_data = DB::select('select distinct t2.exam_roll_no as roll, t1.*,ms.name_np as current_designation,
							mwl.name_np as work_level,t3.seniority_date_bs,t3.minimum_qualification_degree,t3.additional_qualification_degree,t3.minimum_qualification_division,t3.additional_qualification_division,t3.remarks as service_history_remarks
															from vw_vacancy_post_rejected_applicant_profile t1
															left join vacancy_exam t2 on t1.vacancy_apply_id = t2.vacancy_apply_id
															left join applicant_service_history t3 on t1.ap_id=t3.applicant_id
															left join mst_designation ms on ms.id=t3.designation
															left join mst_work_level mwl on mwl.id=t3.work_level
									where t3.is_current=1 and t1.vp_id =:id
									order by applicant_name_en', ['id' => $id]);
					} else {
							$candidate_data = DB::select('select distinct t2.exam_roll_no as roll, t1.*
							from vw_vacancy_post_rejected_applicant_profile t1
							left join vacancy_exam t2 on t1.vacancy_apply_id = t2.vacancy_apply_id
							left join mst_gender as mg on t1.gender = mg.id
							where t1.vp_id =:id and (t1.is_paid=1 OR t1.total_paid_amount is not null)
							order by applicant_name_en', ['id' => $id]);
					}
					// $candidate_data = DB::select(DB::raw($sql));
					if ($opening_type->opening_type_id == 3) {
							$candidate_data = collect($candidate_data);
							$candidate_data = $candidate_data->unique('ap_id');
					}
	
					//education data
					$education_data = [];
					foreach ($candidate_data as $cd) {
							$edu_data = DB::table('applicant_edu_info')
									->where('applicant_id', $cd->ap_id)
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
	
					$intro_data = DB::select('SELECT
					va.notice_no,vp.ad_no, va.ad_title_en, vp.designation_id, wl.name_en as work_level, md.name_en as designation,
			vp.total_req_seats, vp.open_seats, vp.mahila_seats, vp.madheshi_seats, vp.janajati_seats, vp.remote_seats, vp.apanga_seats, vp.dalit_seats
			FROM
					vacancy_post vp
					LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
					left join mst_designation md on md.id = vp.designation_id
					left join mst_work_level wl on wl.id = md.work_level_id
					where vp.id =:id', ['id' => $id]);
	
					$data['intro_data'] = $intro_data;
					$data['training_data'] = $training_data;
					$data['education_data'] = $education_data;
					$data['candidate_data'] = $candidate_data;
					$data['intro_data'] = $intro_data;
					$data['adno_data'] = $this->getVacancyAdNo();
					$data['designation_data'] = $this->getDesignation($this->ad_id);
	
					$designation_name = DB::table('mst_designation')
							->select('name_np')
							->where('id', $designation_id->designation_id)
							->first();
					//$data= json_decode( json_encode($data), true);
					ob_end_clean();
					ob_start();
					ini_set('memory_limit', '-1');
	
	
					if ($opening_type->opening_type_id == 1) {
							$candidate_data=$data['candidate_data'];
							return Excel::download(new SelectedCandidates($id), 'users.xlsx');
					} elseif ($opening_type->opening_type_id == 2) {
							return Excel::download(new SelectedCandidates($id), 'users.xlsx');
					} else {
							return Excel::download(new SelectedCandidates($id), 'users.xlsx');
					}
					ob_flush();
	
			}
	
			public function generateLoksewaExcel($id)
			{
	
					$data = [];
					$designation_id = DB::table('vacancy_post')
							->select('designation_id', 'vacancy_ad_id')
							->where('id', $id)
							->first();
					$opening_type = DB::table('vacancy_ad')
							->select('opening_type_id')
							->where('id', $designation_id->vacancy_ad_id)
							->first();
	
					if ($opening_type->opening_type_id == 1) {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 0]])
									->get();
					} elseif ($opening_type->opening_type_id == 2) {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 1]])
									->get();
					} else {
							$neededDegree = DB::table('mst_designation_degree as mdd')
									->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
									->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
									->where('mdd.designation_id', $designation_id->designation_id)
									->get();
					}
	
					$neededTraining = DB::table('mst_designation_training as mdt')
							->select('mdt.training_id as ti', 'mt.name_en as name')
							->leftjoin('mst_training as mt', 'mt.id', '=', 'mdt.training_id')
							->where('mdt.designation_id', $designation_id->designation_id)
							->get();
	
	
					if ($opening_type->opening_type_id == 2) {
							$candidate_data = DB::select('select
							distinct t2.exam_roll_no as roll,
							t1.*
							, ms.name_np as current_designation,
							mwl.name_np as work_level,
							t3.seniority_date_bs
					from
					vw_vacancy_post_rejected_applicant_profile t1
					left join vacancy_exam t2 on
							t1.vacancy_apply_id = t2.vacancy_apply_id
					left join applicant_service_history t3 on
							t1.ap_id = t3.applicant_id
					left join mst_designation ms on
							ms.id = t3.designation
					left join mst_work_level mwl on
							mwl.id = t3.work_level
					where
							t1.is_paid =:is_paid
							and t3.is_current =:is_current
							and t1.vp_id =:id
					and t3.date_to_ad in
					(select max(date_to_ad)from applicant_service_history where applicant_id=t1.ap_id and is_current=:is_current1)
					order by
							applicant_name_en', ['is_paid' => 1, 'is_current' => 1, 'id' => $id, 'is_current1' => 1]);
	
					} elseif ($opening_type->opening_type_id == 3) {
							$candidate_data = DB::select('select distinct t2.exam_roll_no as roll, t1.*,ms.name_np as current_designation,
							mwl.name_np as work_level,t3.seniority_date_bs,t3.minimum_qualification_degree,t3.additional_qualification_degree,t3.minimum_qualification_division,t3.additional_qualification_division,t3.remarks as service_history_remarks
															from vw_vacancy_post_rejected_applicant_profile t1
															left join vacancy_exam t2 on t1.vacancy_apply_id = t2.vacancy_apply_id
															left join applicant_service_history t3 on t1.ap_id=t3.applicant_id
															left join mst_designation ms on ms.id=t3.designation
															left join mst_work_level mwl on mwl.id=t3.work_level
									where t3.is_current=1 and t1.vp_id =:id
									order by applicant_name_en', ['id' => $id]);
					} else {
							$candidate_data = DB::select('select distinct t2.exam_roll_no as roll, t1.*
							from vw_vacancy_post_rejected_applicant_profile t1
							left join vacancy_exam t2 on t1.vacancy_apply_id = t2.vacancy_apply_id
							left join mst_gender as mg on t1.gender = mg.id
							where t1.vp_id =:id and (t1.is_paid=1 OR t1.total_paid_amount is not null)
							order by applicant_name_en', ['id' => $id]);
					}
					// $candidate_data = DB::select(DB::raw($sql));
					if ($opening_type->opening_type_id == 3) {
							$candidate_data = collect($candidate_data);
							$candidate_data = $candidate_data->unique('ap_id');
					}
	
					//education data
					$education_data = [];
					foreach ($candidate_data as $cd) {
							$edu_data = DB::table('applicant_edu_info')
									->where('applicant_id', $cd->ap_id)
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
	
					$intro_data = DB::select('SELECT
					va.notice_no,vp.ad_no, va.ad_title_en, vp.designation_id, wl.name_en as work_level, md.name_en as designation,
			vp.total_req_seats, vp.open_seats, vp.mahila_seats, vp.madheshi_seats, vp.janajati_seats, vp.remote_seats, vp.apanga_seats, vp.dalit_seats
			FROM
					vacancy_post vp
					LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
					left join mst_designation md on md.id = vp.designation_id
					left join mst_work_level wl on wl.id = md.work_level_id
					where vp.id =:id', ['id' => $id]);
	
					$data['intro_data'] = $intro_data;
					$data['training_data'] = $training_data;
					$data['education_data'] = $education_data;
					$data['candidate_data'] = $candidate_data;
					$data['intro_data'] = $intro_data;
					$data['adno_data'] = $this->getVacancyAdNo();
					$data['designation_data'] = $this->getDesignation($this->ad_id);
	
					$designation_name = DB::table('mst_designation')
							->select('name_np')
							->where('id', $designation_id->designation_id)
							->first();
					//$data= json_decode( json_encode($data), true);
					ob_end_clean();
					ob_start();
					ini_set('memory_limit', '-1');
	
	
					if ($opening_type->opening_type_id == 1) {
							$candidate_data=$data['candidate_data'];
							return Excel::download(new LoksewaSelectedCandidates($id), 'users.xlsx');
					} elseif ($opening_type->opening_type_id == 2) {
							return Excel::download(new LoksewaSelectedCandidates($id), 'users.xlsx');
					} else {
							return Excel::download(new LoksewaSelectedCandidates($id), 'users.xlsx');
					}
					ob_flush();
	
			}
	

	    //By the way, you can still create your own method in here... :) 


	}