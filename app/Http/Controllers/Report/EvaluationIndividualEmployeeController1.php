<?php

namespace App\Http\Controllers\Report;

use App;
use Carbon\Carbon;
use CRUDBooster;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Request;
use Session;
use View;

class EvaluationIndividualEmployeeController extends ReportBaseController
{
    public $ad_id = 0;

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "vacancy_post_paper";
        $this->title_field = "paper_name_en";
        $this->limit = 2000;
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
    public function getIndividaualIndex($token_number)
    {
        $data = [];
        $data['sn'] = Request::get('sn');
        $data['mst_fiscal_year'] = DB::select('SELECT code,date_to_bs,date_from_bs FROM `mst_fiscal_year` WHERE is_current=:id', ['id' => 1]);
        $time = $data['mst_fiscal_year'][0]->date_from_bs;
        $date = new Carbon($time);
        $data['year'] = $date->year;

        $data['last_fiscal_year_ending_date'] = DB::select('SELECT date_to_ad,code,date_to_bs from mst_fiscal_year WHERE is_current=:id ORDER BY date_to_ad DESC LIMIT 1', ['id' => 0]);
        $last_fiscal_year_ending_date_bs = $data['last_fiscal_year_ending_date'][0]->date_to_bs;
        $last_fiscal_year_ending_date_ad = $data['last_fiscal_year_ending_date'][0]->date_to_ad;
        $data['name'] = CRUDBooster::myName();
        $date = Carbon::today();
        $data['format'] = $date->format('Y-m-d');

        #gender rate
        $data['gender'] = DB::select('SELECT gender_id,
                         case
                         when gender_id=:id1 then "rate_male"
                         when gender_id=:id2 then "rate_female"
                         end as gender
                         from applicant_profile ap
                         left join vacancy_apply va on ap.id=va.applicant_id
                         where va.token_number=:token_number', ['id1' => 1, 'id2' => 2, 'token_number' => $token_number]);
        $gender = $data['gender'][0]->gender;

        #least_point_for education by gender
        $lp = DB::select('select ' . $gender . ' from geo_points_setting ORDER BY rate_male ASC LIMIT 1');
        $least_point = $lp[0]->$gender;
        // dd($least_point, $gender, $least_point[0]->$gender);

        //personal info

        $data['intro_data'] = DB::select('SELECT
        ap.first_name_np,
        ap.mid_name_np,
        ap.last_name_np,
        ap.nt_staff_code,
        md1.name_np AS apply_designation,
        ap.nt_staff_code,
        md.name_np AS designation,
        vp.ad_no,
        vva.token_number,
        md.name_np current_post,
        mwl.name_np current_work_level,
        mwl1.name_np apply_work_level,
        mwsg.name_np AS current_service_group,
        mwssg.name_np current_service_sub_group,
        app.local_level_id,
        app.district_id AS district,
        app.ward_no,
        pmd.name_np AS perm_district,
        pmll.name_np AS perm_local_level,
        mg.name_np AS gender,
        ap.photo,
        vva.applicant_id
        FROM
        vacancy_apply vva
        LEFT JOIN merged_applicant_service_history apsh ON apsh.applicant_id = vva.applicant_id
        LEFT JOIN mst_designation md1 ON md1.id = vva.designation_id
        LEFT JOIN mst_designation md ON md.id = apsh.designation
        LEFT JOIN mst_work_level mwl ON mwl.id = apsh.work_level
        LEFT JOIN mst_work_level mwl1 ON mwl1.id = md1.work_level_id
        LEFT JOIN mst_work_service_group mwsg ON mwsg.id = apsh.service_group
        LEFT JOIN mst_work_service_sub_group mwssg ON mwssg.id = apsh.service_subgroup
        LEFT JOIN applicant_profile app ON app.id = apsh.applicant_id
        LEFT JOIN mst_local_level AS pmll ON app.local_level_id = pmll.id
        LEFT JOIN mst_district AS pmd ON app.district_id = pmd.id
        LEFT JOIN mst_gender mg ON app.gender_id = mg.id
        LEFT JOIN applicant_profile ap ON vva.applicant_id = ap.id
        LEFT JOIN vacancy_post vp ON vva.vacancy_post_id = vp.id
        WHERE
        vva.token_number =:token_number
        AND apsh.is_current =:id
        LIMIT 1', ['token_number' => $token_number, 'id' => 1]);

        // dd($data['intro_data'],$token_number);

        if (count($data['intro_data']) == 0) {
            $post = DB::Table('vacancy_apply')->where('token_number', $token_number)->first();
            CRUDBooster::redirect('/app/evaluation_summary_list_designation/' . $post->vacancy_post_id, trans("Please go through the service history of applicant first."), 'warning');
        }
        $district_id = $data['intro_data'][0]->district;
        $ad_no = $data['intro_data'][0]->ad_no;

        //seniority calculation
        $data['seniority'] = DB::select('SELECT mwo.name_np as working_office,
        ash.date_from_bs,
        ash.date_from_ad,
        ash.date_to_bs ,
        ash.remarks,
        ash.seniority_date_bs,
        ash.seniority_date_ad
        from vacancy_apply va
        left join merged_applicant_service_history ash on va.applicant_id=ash.applicant_id
        left join mst_working_office mwo on ash.working_office=mwo.id
        WHERE va.token_number=:token_number
        and seniority_date_bs is not NULL and va.is_deleted is false ORDER BY date_from_bs asc limit 1',
            ['token_number' => $token_number]
        );

        //   dd($data['seniority']);
        $seniority_date_bs = $data['seniority'][0]->seniority_date_bs;
        $seniority_date_ad = $data['seniority'][0]->seniority_date_ad;

        $data['annual_marks_for_seniority'] = DB::select('SELECT mes.annual_marks_rate,mec.name_np FROM mst_evaluation_setting mes
        left join mst_evaluation_criteria mec on mes.criteria_id=mec.id WHERE mec.id=:id', ['id' => 1]);

        $data['max_obtainable_marks_for_seniority'] = DB::select('SELECT mes.max_marks_obtainable FROM mst_evaluation_setting mes
        LEFT JOIN mst_evaluation_criteria mec ON mes.criteria_id = mec.id WHERE mec.id =:id', ['id' => 1]);

        $data['min_duration_months_for_seniority'] = DB::select('SELECT mes.min_duration_months FROM mst_evaluation_setting mes
        LEFT JOIN mst_evaluation_criteria mec ON mes.criteria_id = mec.id WHERE mec.id =:id', ['id' => 1]);

        //end of seniority calculation

        //start of geographical calculation
        $data['max_marks_obtainable_for_geographic'] = DB::select('SELECT mes.max_marks_obtainable FROM mst_evaluation_setting mes
        left join mst_evaluation_criteria mec on mes.criteria_id=mec.id WHERE mec.id=:id', ['id' => 2]);

        $data['min_duration_months_for_geographic'] = DB::select('SELECT mes.min_duration_months FROM mst_evaluation_setting mes
      LEFT JOIN mst_evaluation_criteria mec ON mes.criteria_id = mec.id WHERE mec.id =:id', ['id' => 2]);

        // dd($token_number);

        $data['apply_info'] = DB::table('vw_vacancy_applicant_file_pormotion')->where('token_number', $token_number)->first();
        $level = (int) $data['apply_info']->work_level - 1;
        $work_level_id = DB::table('mst_work_level')->where('name_en', $level)->first();

        // dd($work_level_id, $level);
        //
        $data['min_days_for_geographical'] = $data['min_duration_months_for_geographic'][0]->min_duration_months * 30;
        $min_days_for_geo = $data['min_duration_months_for_geographic'][0]->min_duration_months * 30;

        // dd($data);

        $data['distance'] = DB::select('SELECT
        mwo.name_en as working_office,
        mwo.district_id,
        ap.gender_id,
        gps.rate_male,
        gps.rate_female,
        ash.distance_km,
        ash.seniority_date_bs,
        ash.seniority_date_ad,
        eo.geo_category as varga,
        ash.date_from_ad,
        ash.date_from_bs,
        case when gender_id=1 then
 	       case
                when mwo.district_id=:district_id AND (distance_km < 25 OR  distance_km IS NULL OR distance_km=0)  then :least_point
  	            when mwo.district_id=:district_id1 AND distance_km >=25 then rate_male
  	       else rate_male
  	       end
      else
           case
		   when mwo.district_id=:district_id2 and (distance_km < 25 OR  distance_km IS NULL OR distance_km=0) then :least_point1
	       when mwo.district_id=:district_id3 and distance_km >=25 then rate_female
		   else rate_female
		   end
       end annual_rate,
       case
           when date_from_bs=(select date_from_bs from merged_applicant_service_history where vacancy_apply_id=:token_number1
                and date_from_bs>=:seniority_date_bs order by date_from_bs asc limit 1) then :seniority_date_bs1
           else
                date_from_bs
      end start_date_bs,
      case
             when date_from_ad=(select date_from_ad from merged_applicant_service_history where vacancy_apply_id=:token_number2
                   and date_from_ad>=:seniority_date_ad order by date_from_ad asc limit 1) then :seniority_date_ad1
             else
                  date_from_ad
      end start_date_ad,

      case when is_current=:is_current then :last_fiscal_year_ending_date_bs else date_to_bs end last_date_bs,
      case when is_current=:is_current1 then :last_fiscal_year_ending_date_ad else date_to_ad end last_date_ad,
      DATEDIFF( case when is_current=:is_current2 then :last_fiscal_year_ending_date_ad1 else date_to_ad end,
                case when date_from_bs=(select date_from_ad from merged_applicant_service_history where vacancy_apply_id=:token_number3
                order by date_from_ad asc limit 1) then :seniority_date_ad2 else date_from_ad end) as difference_in_days,

    case
         when
         DATEDIFF( case
         when is_current=:is_current3 then :last_fiscal_year_ending_date_bs1
         else date_to_bs
         end,
         case
         when date_from_bs=(select date_from_bs from merged_applicant_service_history
         where vacancy_apply_id=:token_number4
         order by date_from_bs asc limit 1) then :seniority_date_bs2
         else
         date_from_bs
         end)<=:min_days_for_geo then 0
         else
         DATEDIFF( case
         when is_current=:is_current4 then :last_fiscal_year_ending_date_bs2
         else date_to_bs
         end, case
         when date_from_bs=(select date_from_bs from merged_applicant_service_history
         where vacancy_apply_id=:token_number5
         order by date_from_bs asc limit 1) then :seniority_date_bs3
         else
         date_from_bs
         end)
         end total_diff_days,
         mg.name_np as gender,
      case
          when gender_id=:id1  then
          case
          when distance_km < 25 OR  distance_km IS NULL OR distance_km=0  then :least_point2
          else rate_male
          end
          else
          case
          when distance_km < 25 OR  distance_km IS NULL OR distance_km=0  then :least_point3
          else rate_female
          end
		 end distance_point,
        gps.category
      from merged_applicant_service_history ash

      left join applicant_profile ap on ap.id=ash.applicant_id
      left join mst_gender mg on ap.gender_id=mg.id
      left join mst_working_office mwo on ash.working_office=mwo.id
      left join erp_organization eo on eo.name =mwo.name_en
      left join ( select rate_male,rate_female,category,
      case
      when category = 1 then "A"
      when category = 2 then "B"
      when category = 3 then "C"
      when category = 4 then "D"
      when category = 5 then "E"
      end as varga
      from geo_points_setting) gps on eo.geo_category=gps.varga
      WHERE ash.vacancy_apply_id =:token_number6

      AND work_level IN ( SELECT distinct work_level FROM merged_applicant_service_history sh
      left join vacancy_apply va on sh.applicant_id = va.applicant_id
      WHERE ash.vacancy_apply_id=:token_number7)
      and
      case
      when date_from_bs=(select date_from_bs from merged_applicant_service_history
      where vacancy_apply_id=:token_number8
      and date_from_bs>=:seniority_date_bs4
      order by date_from_bs asc limit 1) then :seniority_date_bs5
      else
      date_from_bs
      end>=:seniority_date_bs6
      and
      case
      when is_current=:is_current5 then :last_fiscal_year_ending_date_bs3
      else date_to_bs
      end<=:last_fiscal_year_ending_date_bs4

      and
      case
      when is_current=:is_current6 then :last_fiscal_year_ending_date_bs5
      else date_to_bs
      end>= case
      when date_from_bs=(select date_from_bs from merged_applicant_service_history
      where vacancy_apply_id=:token_number9
      and date_from_bs>=:seniority_date_bs7
      order by date_from_bs asc limit 1) then :seniority_date_bs8
      else
      date_from_bs
      end

      ORDER BY ash.date_from_ad asc',
            ['district_id' => $district_id,
                'least_point' => $least_point,
                'district_id1' => $district_id,
                'district_id2' => $district_id,
                'least_point1' => $least_point,
                'district_id3' => $district_id,
                'token_number1' => $token_number,
                'seniority_date_bs' => $seniority_date_bs,
                'seniority_date_bs1' => $seniority_date_bs,
                'token_number2' => $token_number,
                'seniority_date_ad' => $seniority_date_ad,
                'seniority_date_ad1' => $seniority_date_ad,
                'is_current' => 1,
                'last_fiscal_year_ending_date_bs' => $last_fiscal_year_ending_date_bs,
                'is_current1' => 1,
                'last_fiscal_year_ending_date_ad' => $last_fiscal_year_ending_date_ad,
                'is_current2' => 1,
                'last_fiscal_year_ending_date_ad1' => $last_fiscal_year_ending_date_ad,
                'token_number3' => $token_number,
                'seniority_date_ad2' => $seniority_date_ad,
                'is_current3' => 1,
                'last_fiscal_year_ending_date_bs1' => $last_fiscal_year_ending_date_bs,
                'token_number4' => $token_number,
                'seniority_date_bs2' => $seniority_date_bs,
                'min_days_for_geo' => $min_days_for_geo,
                'is_current4' => 1,
                'last_fiscal_year_ending_date_bs2' => $last_fiscal_year_ending_date_bs,
                'token_number5' => $token_number,
                'seniority_date_bs3' => $seniority_date_bs,
                'id1' => 1,
                'least_point2' => $least_point,
                'least_point3' => $least_point,
                'token_number6' => $token_number,
                'token_number7' => $token_number,
                // 'work_level' => $work_level_id->id,
                'token_number8' => $token_number,
                'seniority_date_bs4' => $seniority_date_bs,
                'seniority_date_bs5' => $seniority_date_bs,
                'seniority_date_bs6' => $seniority_date_bs,
                'is_current5' => 1,
                'last_fiscal_year_ending_date_bs3' => $last_fiscal_year_ending_date_bs,
                'last_fiscal_year_ending_date_bs4' => $last_fiscal_year_ending_date_bs,
                'is_current6' => 1,
                'last_fiscal_year_ending_date_bs5' => $last_fiscal_year_ending_date_bs,
                'token_number9' => $token_number,
                'seniority_date_bs7' => $seniority_date_bs,
                'seniority_date_bs8' => $seniority_date_bs,
            ]);

        // dd($data['distance'], $district_id, $least_point, $seniority_date_bs, $token_number, $seniority_date_ad,
        //     $last_fiscal_year_ending_date_bs, $last_fiscal_year_ending_date_ad, $min_days_for_geo, $work_level_id->id);

        // $count = count($data['distance']);

        $working_start = Carbon::parse($seniority_date_ad);
        $working_end = Carbon::parse($data['distance'][0]->last_date_ad);
        $data['distance'][0]->difference_in_days = $working_end->diffInDays($working_start);
        //end of calculation for first row of working offfice
        $carry_over_days = 0;
        foreach ($data['distance'] as $key => $geo) {
            if ($carry_over_days == 0) {
                $carry_over_days = 0;
            }
            $diff_after_margin = $geo->difference_in_days;
            $diff_days = $diff_after_margin + 1;

            if ($diff_days <= $min_days_for_geo) {
                $carry_over_days += $diff_days;
            } else {
                $data['distance'][$key]->carry_over_days = $carry_over_days;
                $carry_over_days = 0;
            }
        }
        $carry_prev_days = 0;
        $reversed_data = array_reverse($data['distance']);
        foreach ($reversed_data as $key => $prev_geo) {
            if ($carry_prev_days == 0) {
                $carry_prev_days = 0;
            }
            $diff_prev_after_margin = $prev_geo->difference_in_days;
            $diff_prev_days = $diff_prev_after_margin + 1;
            if ($diff_prev_days <= $min_days_for_geo) {
                $carry_prev_days += $diff_prev_days;
            } else {
                $reversed_data[$key]->carry_prev_days = $carry_prev_days;
                break 1;
            }
        }
        $data['distance'] = array_reverse($reversed_data);

        // dd($data['distance']);
        //end of geographical calculation

        //start of office_incharge
        $data['annual_marks_for_office_incharge'] = DB::select('SELECT
        mes.annual_marks_rate,
        mec.name_np
    FROM
        mst_evaluation_setting mes
        LEFT JOIN mst_evaluation_criteria mec ON mes.criteria_id = mec.id
    WHERE
        mec.id =:id', ['id' => 5]);

        //dd($data['annual_marks_for_office_incharge']);

        $data['max_marks_obtainable_for_office_incharge'] = DB::select('SELECT mes.max_marks_obtainable FROM mst_evaluation_setting mes
     left join mst_evaluation_criteria mec on mes.criteria_id=mec.id
     where mec.id =:id', ['id' => 5]);

        $data['min_duration_months_for_office_incharge'] = DB::select('SELECT
     mes.min_duration_months
     FROM
     mst_evaluation_setting mes
     LEFT JOIN mst_evaluation_criteria mec ON mes.criteria_id = mec.id
     WHERE
     mec.id =:id', ['id' => 5]);

        // dd($data['min_duration_months_for_office_incharge'], $last_fiscal_year_ending_date_bs, $last_fiscal_year_ending_date_ad);

        $data['min_days_for_office_incharge'] = $data['min_duration_months_for_office_incharge'][0]->min_duration_months * 30;
        $min_days_for_office_incharge = $data['min_duration_months_for_office_incharge'][0]->min_duration_months * 30;

        $data['office_incharge'] = DB::select('SELECT
        mwo.name_np AS working_office,
        ash.is_office_incharge,
        ash.incharge_date_from_ad,
        ash.incharge_date_to_ad,
        ash.incharge_date_from_bs,
        ash.incharge_date_to_bs,
     case
		 when incharge_date_to_bs=\'2069-09-16\' then :last_fiscal_year_ending_date_bs
		 else incharge_date_to_bs
		 end last_incharge_date_bs,
         case
		 when incharge_date_to_ad=\'2012-12-31\' then  :last_fiscal_year_ending_date_ad
		 else incharge_date_to_ad
         end last_incharge_date_ad,
 DATEDIFF( if(incharge_date_to_ad=\'2012-12-31\',:last_fiscal_year_ending_date_ad1,incharge_date_to_ad),incharge_date_from_ad) as difference_in_days,
 case
 when
 DATEDIFF( if(incharge_date_to_ad=\'2012-12-31\',:last_fiscal_year_ending_date_ad2,incharge_date_to_ad),incharge_date_from_ad)<=:min_days_for_office_incharge then 0
 else
 DATEDIFF( if(incharge_date_to_ad=\'2012-12-31\',:last_fiscal_year_ending_date_ad3,incharge_date_to_ad),incharge_date_from_ad)
end total_diff_days
 FROM

      merged_applicant_service_history ash
     LEFT JOIN mst_working_office mwo ON ash.working_office = mwo.id

 WHERE
     ash.vacancy_apply_id =:token_number
     AND ash.is_office_incharge =:is_incharge
     AND incharge_date_from_bs >=:seniority_date_bs
     AND incharge_date_to_bs >=:last_fiscal_year_ending_date_bs1
     order by  incharge_date_from_bs asc',
            [
                'last_fiscal_year_ending_date_bs' => $last_fiscal_year_ending_date_bs,
                'last_fiscal_year_ending_date_ad' => $last_fiscal_year_ending_date_ad,
                'last_fiscal_year_ending_date_ad1' => $last_fiscal_year_ending_date_ad,
                'last_fiscal_year_ending_date_ad2' => $last_fiscal_year_ending_date_ad,
                'min_days_for_office_incharge' => $min_days_for_office_incharge,
                'last_fiscal_year_ending_date_ad3' => $last_fiscal_year_ending_date_ad,
                'token_number' => $token_number,
                'is_incharge' => 1,
                'seniority_date_bs' => $seniority_date_bs,
                'last_fiscal_year_ending_date_bs1' => $last_fiscal_year_ending_date_bs,
            ]

        );
        //dd($data['office_incharge']);

        //end of office_incharge

        //education details

        $data['min_education_requirements'] = DB::select('SELECT distinct edu_level_id from mst_edu_degree
        where id in(SELECT edu_degree_id from mst_designation_degree
        where designation_id=(select designation_id from vacancy_apply where token_number=:token_number))', ['token_number' => $token_number]);

        //dd($data['min_education_requirements']);

        $edu_level_id = $data['min_education_requirements'][0]->edu_level_id;

        $data['applied_education_details_minimum'] = DB::select('SELECT DISTINCT
    	aei.edu_degree_id as degree_id,
        aei.passed_year_ad,
    	medd.name_en AS degree_name,
    	med.name_en AS division,
        aei.division_id as division_id,
    	-- eps.minimum_points AS points
        COALESCE(eps.minimum_points,9.0)AS points
    FROM
    	merged_applicant_education aei
    	LEFT JOIN merged_applicant_service_history ash ON ash.applicant_id = aei.applicant_id
    	LEFT JOIN mst_edu_degree medd ON aei.edu_degree_id = medd.id
    	LEFT JOIN mst_edu_level mel ON medd.edu_level_id = mel.id
    	LEFT JOIN mst_edu_division med ON aei.division_id = med.id
    	LEFT JOIN edu_points_setting eps ON med.id = eps.edu_division_id
WHERE
	ash.vacancy_apply_id =:token_number
	AND medd.id IN (
SELECT
	mdd.edu_degree_id
FROM
	mst_designation md
	LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
	LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
WHERE
	md.CODE = ( SELECT designation_id FROM vacancy_apply WHERE id =:token_number1)
	AND mdd.is_for_internal =:is_for_internal
    )', ['token_number' => $token_number,
            'token_number1' => $token_number,
            'is_for_internal' => 1,
        ]);

        // dd($data['applied_education_details_minimum']);

        $data['education_details_maximum'] = DB::select('SELECT DISTINCT
        	aei.passed_year_ad,
            aei.edu_degree_id as degree_id,
        	medd.name_en AS degree_name,
        	med.name_en AS division,
            aei.division_id as division_id,
        	eps.minimum_points AS points ,
            eps.additional_points as additional_points
            FROM
            	merged_applicant_education aei
            	LEFT JOIN merged_applicant_service_history ash ON ash.applicant_id = aei.applicant_id
            	LEFT JOIN mst_edu_degree medd ON aei.edu_degree_id = medd.id
            	LEFT JOIN mst_edu_level mel ON medd.edu_level_id = mel.id
            	LEFT JOIN mst_edu_division med ON aei.division_id = med.id
            	LEFT JOIN edu_points_setting eps ON med.id = eps.edu_division_id
            WHERE
            	ash.vacancy_apply_id =:token_number
            	AND medd.id IN (
            SELECT
            	mdd.edu_degree_id
            FROM
            	mst_designation md
            	LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            	LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
            WHERE
            	md.CODE = ( SELECT designation_id FROM vacancy_apply WHERE id =:token_number1)
                AND mdd.is_additional =:is_additional
                AND mdd.is_for_internal =:is_for_internal
                )', ['token_number' => $token_number, 'token_number1' => $token_number, 'is_additional' => 1, 'is_for_internal' => 0]);

        // dd($data['education_details_maximum']);

        $data['max_marks_obtainable_for_education'] = DB::select('SELECT mes.max_marks_obtainable FROM mst_evaluation_setting mes
        left join mst_evaluation_criteria mec on mes.criteria_id=mec.id
         WHERE mec.id=:id', ['id' => 4]);

        //end of education calculation

        // dd()

        //start of education_leave calculation

        $data['leave_calculation'] = DB::select('SELECT distinct ald.leave_type_id,
             ald.date_from_bs,
             ald.date_to_bs ,
             ald.date_from_ad,
             ald.date_to_ad,
             mlt.name_en,
             mlt.name_np,
             (DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1) as difference_in_days,
             wo.last_date_bs,
             wo.start_date_bs,
             wo.rate,
             wo.working_office,
             case when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then ROUND((:least_point*((DATEDIFF( ald.date_to_bs,ald.date_from_bs) )+1))/365,3) end education_absent_point,
             wo.difference_in_days_in_working_office,

             ((wo.rate*(wo.difference_in_days_in_working_office))/365) as total_working_office_point,

             (ROUND((wo.rate*(wo.difference_in_days_in_working_office))/365,3)-case when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then
             ROUND((:least_point1*(DATEDIFF( ald.date_to_bs,ald.date_from_bs) ))/365,2) end) as total_point_after_deduction,
             (wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1)) as total_working_days_excluding_education_leave,
             ( ((wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*wo.rate)/365) as total_point_without,

             (Round(( ((wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*wo.rate)/365),3) +case
             when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then ((:least_point2*(DATEDIFF( ald.date_to_bs,ald.date_from_bs)+1 ))/365) end) as total_point_after_excluding

            --  from applicant_leave_details ald
             from merged_applicant_leave_detail ald
             left join(select distinct ap.nt_staff_code from applicant_profile ap
             left join vacancy_apply va on ap.id=va.applicant_id WHERE va.token_number=:token_number) ecode on ald.emp_no=ecode.nt_staff_code
             left join mst_leave_type mlt on ald.leave_type_id=mlt.id
             left join (SELECT mwo.name_en as working_office,
             va.token_number,
             ap.gender_id,
             eo.geo_category as varga,
             ash.date_from_ad,
             ash.date_to_ad,
             ash.date_from_bs,
             ash.date_to_bs,
             vacancy_apply_id,
             case when is_current=:is_current then :last_fiscal_year_ending_date_bs  else date_to_bs end last_date_bs,
             case when date_from_bs=(select date_from_bs from merged_applicant_service_history where vacancy_apply_id=:token_number1 order by date_from_bs asc limit 1) then :seniority_date_bs
             else date_from_bs end start_date_bs,(DATEDIFF(case when is_current=:is_current1 then :last_fiscal_year_ending_date_ad else date_to_ad end,
             case when date_from_ad=(select date_from_ad from merged_applicant_service_history where vacancy_apply_id=:token_number2
             order by date_from_ad asc limit 1) then :seniority_date_ad else ash.date_from_ad end)+1) as difference_in_days_in_working_office,
             mg.name_en as gender,gps.rate_male,gps.rate_female,gps.category,CASE when ap.gender_id=1 then gps.rate_male	else gps.rate_female END rate
             from vacancy_apply va
             left join merged_applicant_service_history ash on va.applicant_id=ash.applicant_id
             left join applicant_profile ap on ap.id=ash.applicant_id
             left join mst_gender mg on ap.gender_id=mg.id
             left join mst_working_office mwo on ash.working_office=mwo.id
             left join erp_organization eo ON eo.name =mwo.name_en
                        left join (select rate_male,rate_female,category,case
                         when category = 1 then \'A\'
                         when category = 2 then \'B\'
                         when category = 3 then \'C\'
                         when category = 4 then \'D\'
                         when category = 5 then \'E\'
                         end as varga
                         from geo_points_setting) gps on eo.geo_category=gps.varga
                         where va.token_number=:token_number3  AND work_level IN ( SELECT work_level FROM merged_applicant_service_history sh
                         left join vacancy_apply va on sh.applicant_id = va.applicant_id WHERE va.token_number=:token_number4 AND sh.work_level =:work_level)
                         and  date_from_bs >=case when date_from_bs=(select date_from_bs from merged_applicant_service_history where vacancy_apply_id=:token_number5 order by date_from_bs asc limit 1) then :seniority_date_bs1
                         else date_from_bs end
                         and
                         date_to_bs <=case when is_current=:is_current2 then :last_fiscal_year_ending_date_bs1 else date_to_bs end ORDER BY ash.date_from_ad desc) as wo on wo.vacancy_apply_id=:token_number6
                       where ald.emp_no=(select ap.nt_staff_code from applicant_profile ap
                       left join vacancy_apply va on ap.id=va.applicant_id WHERE va.token_number=:token_number7)

                       and ald.date_from_bs>=:seniority_date_bs2
                       and ald.date_to_bs<= :last_fiscal_year_ending_date_bs2
                        and ald.leave_type_id=3 and ald.is_deleted is false
                       ORDER BY date_from_bs desc
                       ',
            [
                'least_point' => $least_point,
                'least_point1' => $least_point,
                'least_point2' => $least_point,
                'token_number' => $token_number,
                'is_current' => 1,
                'last_fiscal_year_ending_date_bs' => $last_fiscal_year_ending_date_bs,
                'token_number1' => $token_number,
                'seniority_date_bs' => $seniority_date_bs,
                'is_current1' => 1,
                'last_fiscal_year_ending_date_ad' => $last_fiscal_year_ending_date_ad,
                'token_number2' => $token_number,
                'seniority_date_ad' => $seniority_date_ad,
                'token_number3' => $token_number,
                'token_number4' => $token_number,
                'work_level' => $work_level_id->id,
                'token_number5' => $token_number,
                'seniority_date_bs1' => $seniority_date_bs,
                'is_current2' => 1,
                'last_fiscal_year_ending_date_bs1' => $last_fiscal_year_ending_date_bs,
                'token_number6' => $token_number,
                'token_number7' => $token_number,
                'seniority_date_bs2' => $seniority_date_bs,
                'last_fiscal_year_ending_date_bs2' => $last_fiscal_year_ending_date_bs,
            ]

        );

        //dd($least_point, $token_number, $work_level_id->id, $count, $seniority_date_ad, $last_fiscal_year_ending_date_ad, $last_fiscal_year_ending_date_bs, $seniority_date_bs);

        if (!empty($data['leave_calculation'])) {
            $edu_leave_sum = 0;
            $edu_working_office = 0;
            foreach ($data['leave_calculation'] as $keys => $lc) {

                $particular_office_working_point = $lc->total_working_office_point;
                $point_after_excluding = $lc->total_point_after_excluding;

                $edu_working_office += $particular_office_working_point;
                $edu_leave_sum += $point_after_excluding;
            }
            $data['lc_point'] = $edu_leave_sum;
            $data['working_office_point'] = $edu_working_office;
        }
        // dd($data['leave_calculation']);
        //start of non-standard leave calculation
        $data['non_standard_leav'] = DB::select('SELECT distinct ald.leave_type_id,
          ald.date_from_bs,
          ald.date_to_bs,
          ald.date_from_ad,
          ald.date_to_ad,
          mlt.name_en,
          mlt.name_np,
         (DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1) as difference_in_days,
          wo.last_date_bs,
          wo.start_date_bs,
          wo.rate,
          (SELECT mes.annual_marks_rate FROM mst_evaluation_setting mes left join mst_evaluation_criteria mec on mes.criteria_id=mec.id WHERE mec.id=1)as seniority_rate,
     Round(((((DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*(SELECT mes.annual_marks_rate FROM mst_evaluation_setting mes
       left join mst_evaluation_criteria mec on mes.criteria_id=mec.id WHERE mec.id=1))/365),3) as seniority_points,
          wo.working_office,
         case when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then ROUND((:least_point*(DATEDIFF( ald.date_to_bs,ald.date_from_bs)+1 ))/365,3) end education_absent_point,
        wo.difference_in_days_in_working_office,
        ROUND((wo.rate*(wo.difference_in_days_in_working_office))/365,2) as total_working_office_point,
        (ROUND((wo.rate*(wo.difference_in_days_in_working_office))/365,2)-case when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then
        ROUND((2*(DATEDIFF( ald.date_to_bs,ald.date_from_bs) ))/365,2) end) as total_point_after_deduction,
        (wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1)) as total_working_days_excluding_education_leave,
        Round(( ((wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*wo.rate)/365),2) as total_point_without,
        (Round(( ((wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*wo.rate)/365),2) +case
         when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then
         ROUND((:least_point1*(DATEDIFF( ald.date_to_bs,ald.date_from_bs) ))/365,2) end) as total_point_after_excluding
         from merged_applicant_leave_detail ald

        left join(select distinct ap.nt_staff_code from applicant_profile ap
        left join vacancy_apply va on ap.id=va.applicant_id WHERE va.token_number=:token_number) ecode on ald.emp_no=ecode.nt_staff_code
        left join mst_leave_type mlt on ald.leave_type_id=mlt.code
        left join (SELECT mwo.name_en as working_office,va.token_number, ap.gender_id,eo.geo_category as varga,ash.date_from_ad,ash.date_to_ad,ash.date_from_bs,
        ash.date_to_bs,vacancy_apply_id,case when is_current=1 then :last_fiscal_year_ending_date_bs else date_to_bs end last_date_bs,
        case when date_from_bs=(select date_from_bs from merged_applicant_service_history
        where vacancy_apply_id=:token_number1 order by date_from_bs asc limit 1) then :seniority_date_bs else date_from_bs
        end start_date_bs,(DATEDIFF(case when is_current=1 then :last_fiscal_year_ending_date_ad else date_to_ad end,

        case when date_from_ad=(select date_from_ad from merged_applicant_service_history where vacancy_apply_id=:token_number2
        order by date_from_ad asc limit 1) then :seniority_date_ad else ash.date_from_ad end)+1) as difference_in_days_in_working_office,
        mg.name_en as gender,gps.rate_male,gps.rate_female,gps.category,
        CASE when ap.gender_id=1 then gps.rate_male	else gps.rate_female END rate
        from vacancy_apply va
        left join merged_applicant_service_history ash on va.applicant_id=ash.applicant_id
        left join applicant_profile ap on ap.id=ash.applicant_id
        left join mst_gender mg on ap.gender_id=mg.id
        left join mst_working_office mwo on ash.working_office=mwo.id
        left join erp_organization eo ON eo.name =mwo.name_en
        left join ( select rate_male,
                                      rate_female,
                                      category
                                 , case
                                 when category = 1 then \'A\'
                                 when category = 2 then \'B\'
                                 when category = 3 then \'C\'
                                 when category = 4 then \'D\'
                                 when category = 5 then \'E\'
                                     end as varga
                             from geo_points_setting) gps on eo.geo_category=gps.varga
               where va.token_number=:token_number3
               AND work_level IN ( SELECT work_level FROM merged_applicant_service_history sh
               left join vacancy_apply va on sh.applicant_id = va.applicant_id
               WHERE va.token_number=:token_number4 AND sh.work_level =:work_level)

               and  date_from_bs >=case
               when date_from_bs=(select date_from_bs from merged_applicant_service_history
               where vacancy_apply_id=:token_number5
               order by date_from_bs asc limit 1) then :seniority_date_bs1
               else
               date_from_bs
               end

               and
               date_to_bs <=  case
               when is_current=1 then :last_fiscal_year_ending_date_bs1
               else
               date_to_bs
               end

               ORDER BY ash.date_from_ad desc) as wo on wo.vacancy_apply_id=:token_number6

             where ald.emp_no=(select  ap.nt_staff_code  from
             applicant_profile ap
             left join vacancy_apply va on ap.id=va.applicant_id
             WHERE va.token_number=:token_number7)
             and ald.date_from_bs>=
             case when :count >1 then
             wo.start_date_bs
             else
             :seniority_date_bs2
             end
             and ald.date_to_bs<= case when :count1>1 then
             wo.last_date_bs
             else
             :last_fiscal_year_ending_date_bs2
             end
             and ald.leave_type_id=1
             ORDER BY date_from_bs desc
             ',
            [
                'least_point' => $least_point,
                'least_point1' => $least_point,
                'token_number' => $token_number,
                'last_fiscal_year_ending_date_bs' => $last_fiscal_year_ending_date_bs,
                'token_number1' => $token_number,
                'seniority_date_bs' => $seniority_date_bs,
                'last_fiscal_year_ending_date_ad' => $last_fiscal_year_ending_date_ad,
                'token_number2' => $token_number,
                'seniority_date_ad' => $seniority_date_ad,
                'token_number3' => $token_number,
                'token_number4' => $token_number,
                'work_level' => $work_level_id->id,
                'token_number5' => $token_number,
                'seniority_date_bs1' => $seniority_date_bs,
                'last_fiscal_year_ending_date_bs1' => $last_fiscal_year_ending_date_bs,
                'token_number6' => $token_number,
                'token_number7' => $token_number,
                'count' => $count,
                'seniority_date_bs2' => $seniority_date_bs,
                'count1' => $count,
                'last_fiscal_year_ending_date_bs2' => $last_fiscal_year_ending_date_bs,
            ]

        );

        //  dd($data['non_standard_leav']);

        if (!empty($data['non_standard_leav'])) {
            $leave_sum = 0;
            $seniority_leave_sum = 0;
            foreach ($data['non_standard_leav'] as $keys => $cnsl) {
                $leave_points = $cnsl->education_absent_point;
                $leave_sum += $leave_points;
                $seniority_leave_points = $cnsl->seniority_points;
                $seniority_leave_sum += $seniority_leave_points;
            }
            $data['nsl_point'] = $leave_sum;
            $data['snsl_point'] = $seniority_leave_sum;
        }
        // dd($data['nsl_point']);

        //end of non-standard leave_type

        //start of absent calculation
        $data['absent_leave_calculation'] = DB::select('SELECT ald.date_from_bs,ald.date_to_bs ,ald.date_from_ad,ald.date_to_ad,(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1) as difference_in_days,
     wo.last_date_bs,wo.start_date_bs,wo.rate,(SELECT mes.annual_marks_rate FROM mst_evaluation_setting mes left join mst_evaluation_criteria mec on mes.criteria_id=mec.id WHERE mec.id=1)as seniority_rate,
     Round(((((DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*(SELECT mes.annual_marks_rate FROM mst_evaluation_setting mes
       left join mst_evaluation_criteria mec on mes.criteria_id=mec.id WHERE mec.id=1))/365),3) as seniority_points,
     wo.working_office,case when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then  ROUND((:least_point*(DATEDIFF( ald.date_to_bs,ald.date_from_bs)+1 ))/365,3) end education_absent_point,
     wo.difference_in_days_in_working_office,ROUND((wo.rate*(wo.difference_in_days_in_working_office))/365,2) as total_working_office_point,
     (ROUND((wo.rate*(wo.difference_in_days_in_working_office))/365,2)-case when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then
     ROUND((:least_point1*(DATEDIFF( ald.date_to_bs,ald.date_from_bs) ))/365,2) end) as total_point_after_deduction,
     (wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1)) as total_working_days_excluding_education_leave,
      Round(( ((wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*wo.rate)/365),2) as total_point_without,
     (Round(( ((wo.difference_in_days_in_working_office-(DATEDIFF(ald.date_to_bs,ald.date_from_bs)+1))*wo.rate)/365),2) +case
     when DATEDIFF(ald.date_to_bs,ald.date_from_bs) is not null then ROUND((:least_point2*(DATEDIFF( ald.date_to_bs,ald.date_from_bs) ))/365,2) end) as total_point_after_excluding
     from applicant_absent_details ald
     left join(select distinct ap.nt_staff_code  from applicant_profile ap
     left join vacancy_apply va on ap.id=va.applicant_id WHERE va.token_number=:token_number) ecode on ald.emp_no=ecode.nt_staff_code
     left join (SELECT mwo.name_en as working_office, va.token_number,ap.gender_id,eo.geo_category as varga,ash.date_from_ad, ash.date_to_ad,
     ash.date_from_bs,ash.date_to_bs,vacancy_apply_id,
     case when is_current=1 then :last_fiscal_year_ending_date_bs else date_to_bs end last_date_bs,
     case when date_from_bs=(select date_from_bs from merged_applicant_service_history where vacancy_apply_id=:token_number1
     order by date_from_bs asc limit 1) then :seniority_date_bs else date_from_bs end start_date_bs,
     (DATEDIFF(case when is_current=1 then :last_fiscal_year_ending_date_ad else date_to_ad end,
     case when date_from_ad=(select date_from_ad from merged_applicant_service_history where vacancy_apply_id=:token_number2
     order by date_from_ad asc limit 1) then :seniority_date_ad else ash.date_from_ad end)+1) as difference_in_days_in_working_office,
     mg.name_en as gender, gps.rate_male,gps.rate_female,gps.category,
     CASE when ap.gender_id=1 then gps.rate_male else gps.rate_female END rate from vacancy_apply va
     left join merged_applicant_service_history ash on va.applicant_id=ash.applicant_id
     left join applicant_profile ap on ap.id=ash.applicant_id
     left join mst_gender mg on ap.gender_id=mg.id
     left join mst_working_office mwo on ash.working_office=mwo.id
     left join erp_organization eo ON eo.name =mwo.name_en
     left join (select rate_male,rate_female,category,case
     when category = 1 then \'A\'
     when category = 2 then \'B\'
     when category = 3 then \'C\'
     when category = 4 then \'D\'
     when category = 5 then \'E\' end as varga from geo_points_setting) gps on eo.geo_category=gps.varga
     where va.token_number=:token_number3
     AND work_level IN ( SELECT work_level FROM merged_applicant_service_history sh
     left join vacancy_apply va on sh.applicant_id = va.applicant_id
     WHERE va.token_number=:token_number4 AND sh.work_level =:work_level)

     and  date_from_bs >=case
     when date_from_bs=(select date_from_bs from merged_applicant_service_history where vacancy_apply_id=:token_number5
     order by date_from_bs asc limit 1) then :seniority_date_bs1 else date_from_bs end
     and
     date_to_bs <=case when is_current=1 then :last_fiscal_year_ending_date_bs1 else date_to_bs end
     ORDER BY ash.date_from_ad desc) as wo on wo.vacancy_apply_id=:token_number6

     where ald.emp_no=(select  ap.nt_staff_code  from applicant_profile ap
     left join vacancy_apply va on ap.id=va.applicant_id WHERE va.token_number=:token_number7)
     and ald.date_from_bs>=case when :count >1 then wo.date_from_bs else :seniority_date_bs2 end
     and ald.date_to_bs<=case when :count1 >1 then wo.date_to_bs else :last_fiscal_year_ending_date_bs2 end
     ORDER BY date_from_bs desc
     ',
            [
                'least_point' => $least_point,
                'least_point1' => $least_point,
                'least_point2' => $least_point,
                'token_number' => $token_number,
                'last_fiscal_year_ending_date_bs' => $last_fiscal_year_ending_date_bs,
                'token_number1' => $token_number,
                'seniority_date_bs' => $seniority_date_bs,
                'last_fiscal_year_ending_date_ad' => $last_fiscal_year_ending_date_ad,
                'token_number2' => $token_number,
                'seniority_date_ad' => $seniority_date_ad,
                'token_number3' => $token_number,
                'token_number4' => $token_number,
                'work_level' => $work_level_id->id,
                'token_number5' => $token_number,
                'seniority_date_bs1' => $seniority_date_bs,
                'last_fiscal_year_ending_date_bs1' => $last_fiscal_year_ending_date_bs,
                'token_number6' => $token_number,
                'token_number7' => $token_number,
                'count' => $count,
                'seniority_date_bs2' => $seniority_date_bs,
                'count1' => $count,
                'last_fiscal_year_ending_date_bs2' => $last_fiscal_year_ending_date_bs,
            ]
        );

// dd($data['absent_leave_calculation']);

        if (!empty($data['absent_leave_calculation'])) {
            $absent_sum = 0;
            $seniority_absent_sum = 0;
            foreach ($data['absent_leave_calculation'] as $keys => $alc) {
                $absent_points = $alc->education_absent_point;
                $absent_sum += $absent_points;
                $seniority_absent_points = $alc->seniority_points;
                $seniority_absent_sum += $seniority_absent_points;
            }
            $data['alc_point'] = $absent_sum;
            $data['salc_point'] = $seniority_absent_sum;
        }
        $Total_datas = session(['dat' => $data]);
        Session::put('evaluated_data', $data);
        $this->cbView('reports.individual_employee_eval', $data);
    }

    public function generatepdf($token_number)
    {
        $retrieved_data = Session::get('evaluated_data');
        $view = View::make('reports.pdf_individual_employee', $retrieved_data);
        $contents = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->inline();
    }
    public function generateExcel($token_number)
    {
        $excel_retrieved_data = Session::get('evaluated_data');
        ob_end_clean();
        ob_start();
        ini_set('memory_limit', '-1');
        \Excel::create('individaual_evaluation', function ($excel) use ($excel_retrieved_data) {
            $excel->sheet('New sheet', function ($sheet) use ($excel_retrieved_data) {
                $sheet->loadView('reports.excel_individual_employee', $excel_retrieved_data);
                $sheet->setOrientation('portrait');
            });
        })->download('xls');
        ob_flush();
    }
}
