<?php

namespace App\Http\Controllers\Report;

use CB;
use CRUDBooster;
use DB;
use Request;
use Session;

class ApplicantEligibleCountReportController extends ReportBaseController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        // $this->table               = "vacancy_apply";
        $this->report_name = "Eligible Applicant with Roll No. Count";
        $this->title_field = "work_code";
        $this->limit = 20;
        $this->orderby = "work_code,desc";
        $this->show_numbering = true;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_delete = false;
        $this->button_edit = false;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = false;
        $this->button_export = true;
        $this->button_import = false;
        $this->button_bulk_action = false;
        //$this->getIndex_view  = "default.AdwiseIndex";

        # END CONFIGURATION DO NOT REMOVE THIS LINE
        // $this->table   = "vacancy_apply";
        // $this->alias = "count_sql";
        $this->table = "vw_eligible_applicant";
        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => "Level", "name" => "work_code");
        $this->col[] = array("label" => "Designation", "name" => "designation");
        $this->col[] = array("label" => "Applicant Name", "name" => "applicant_name");
        $this->col[] = array("label" => "Roll No.", "name" => "exam_roll_no");
        $this->col[] = array("label" => "Exam Center", "name" => "name_np");

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];

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

        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-remove','confirmation'=>true,'confirmation_text'=>"Are you sure you want to cancel?","confirmation_title"=>"Cancel",'color'=>'danger','url'=>CRUDBooster::mainpath('../vacancy_apply_cancelation/edit').'/[id]','showIf'=>'[is_cancelled] == 0'];
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-pencil','confirmation'=>true,'confirmation_text'=>"Are you sure you want to edit record?","confirmation_title"=>"Edit",'color'=>'warning','url'=>CRUDBooster::mainpath('../vacancy_apply/edit').'/[id]','showIf'=>'[is_cancelled] == 0'];
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-eye','color'=>'primary','url'=>CRUDBooster::mainpath('../vacancy_apply/view').'/[id]'];
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-user','color'=>'success','url'=>CRUDBooster::mainpath('../applicant_profile/edit').'/[applicant_id]'];
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-remove','color'=>'warning','url'=>CRUDBooster::mainpath('set-status/1/[id]')];

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
        //$this->index_button[] = ["label"=>"Print Report","icon"=>"fa fa-print","url"=>CRUDBooster::mainpath('print-report')];

        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
         */
        $this->table_row_color = array();
        $this->table_row_color[] = ['condition' => "[is_cancelled] == 1", "color" => "danger"];

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
        $this->script_js = "$(document).ready(function(){
            $('td:nth-child(15), th:nth-child(15)').hide();
            $('td:nth-child(16), th:nth-child(16)').hide();
            $('td:nth-child(17), th:nth-child(17)').hide();
            $('td:nth-child(18), th:nth-child(18)').hide();
            $('td:nth-child(19), th:nth-child(19)').hide();
            $('td:nth-child(20), th:nth-child(20)').hide();
            $('td:nth-child(21), th:nth-child(21)').hide();

        });";

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

    public function getIndex()
    {
        $this->is_index = true;
        $this->cbLoader();

        $module = CRUDBooster::getCurrentModule();
        if (CRUDBooster::myPrivilegeId() == 4) {
            if (!CRUDBooster::isView() && $this->global_privilege == false) {
                CRUDBooster::insertLog(trans('crudbooster.log_try_view', ['module' => $module->name]));
                CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
            }
        }

        if (Request::get('parent_table')) {
            $parentTablePK = CB::pk(g('parent_table'));
            $data['parent_table'] = DB::table(Request::get('parent_table'))->where($parentTablePK, Request::get('parent_id'))->first();
            if (Request::get('foreign_key')) {
                $data['parent_field'] = Request::get('foreign_key');
            } else {
                $data['parent_field'] = CB::getTableForeignKey(g('parent_table'), $this->table);
            }

            if ($parent_field) {
                foreach ($this->columns_table as $i => $col) {
                    if ($col['name'] == $parent_field) {
                        unset($this->columns_table[$i]);
                    }
                }
            }
        }
        $this->getAlias();
        $data['table'] = $this->table;
        // $data['table_pk'] = CB::pk($this->table);
        $data['table_pk'] = $this->pk($this->table, $this->alias);
        $data['page_title'] = $module->name;
        $data['page_description'] = trans('crudbooster.default_module_description');
        $data['date_candidate'] = $this->date_candidate;
        $data['limit'] = $limit = (Request::get('limit')) ? Request::get('limit') : $this->limit;

        $tablePK = $data['table_pk'];
        //$table_columns = CB::getTableColumns($this->table);
        $table_columns = $this->getTableColumns($this->table, $this->alias);
        $result = DB::table(DB::raw($this->table))->select(DB::raw($this->alias . "." . $this->primary_key));

        if (Request::get('parent_id')) {
            $table_parent = $this->table;
            $table_parent = CRUDBooster::parseSqlTable($table_parent)['table'];
            $result->where($table_parent . '.' . Request::get('foreign_key'), Request::get('parent_id'));
        }

        $this->hook_query_index($result);

        if (in_array('deleted_at', $table_columns)) {
            $result->where($this->table . '.deleted_at', null);
        }

        $alias = array();
        $join_alias_count = 0;
        $join_table_temp = array();
        // $table            = $this->table;
        $table = $this->alias;

        $columns_table = $this->columns_table;
        foreach ($columns_table as $index => $coltab) {

            $join = @$coltab['join'];
            $join_where = @$coltab['join_where'];
            $join_id = @$coltab['join_id'];
            $field = @$coltab['name'];
            $join_table_temp[] = $table;

            if (!$field) {
                die('Please make sure there is key `name` in each row of col');
            }

            if (strpos($field, ' as ') !== false) {
                $field = substr($field, strpos($field, ' as ') + 4);
                $field_with = (array_key_exists('join', $coltab)) ? str_replace(",", ".", $coltab['join']) : $field;
                $result->addselect(DB::raw($coltab['name']));
                $columns_table[$index]['type_data'] = 'varchar';
                $columns_table[$index]['field'] = $field;
                $columns_table[$index]['field_raw'] = $field;
                $columns_table[$index]['field_with'] = $field_with;
                $columns_table[$index]['is_subquery'] = true;
                continue;
            }

            if (strpos($field, '.') !== false) {
                $result->addselect($field);
            } else {
                $result->addselect($table . '.' . $field);
            }

            $field_array = explode('.', $field);

            if (isset($field_array[1])) {
                $field = $field_array[1];
                $table = $field_array[0];
            }

            if ($join) {

                $join_exp = explode(',', $join);

                $join_table = $join_exp[0];
                $joinTablePK = CB::pk($join_table);
                $join_column = $join_exp[1];
                $join_alias = str_replace(".", "_", $join_table);

                if (in_array($join_table, $join_table_temp)) {
                    $join_alias_count += 1;
                    $join_alias = $join_table . $join_alias_count;
                }
                $join_table_temp[] = $join_table;

                $result->leftjoin($join_table . ' as ' . $join_alias, $join_alias . (($join_id) ? '.' . $join_id : '.' . $joinTablePK), '=', DB::raw($this->alias . '.' . $field . (($join_where) ? ' AND ' . $join_where . ' ' : '')));
                $result->addselect($join_alias . '.' . $join_column . ' as ' . $join_alias . '_' . $join_column);

                $join_table_columns = CRUDBooster::getTableColumns($join_table);
                if ($join_table_columns) {
                    foreach ($join_table_columns as $jtc) {
                        $result->addselect($join_alias . '.' . $jtc . ' as ' . $join_alias . '_' . $jtc);
                    }
                }

                $alias[] = $join_alias;
                $columns_table[$index]['type_data'] = CRUDBooster::getFieldType($join_table, $join_column);
                $columns_table[$index]['field'] = $join_alias . '_' . $join_column;
                $columns_table[$index]['field_with'] = $join_alias . '.' . $join_column;
                $columns_table[$index]['field_raw'] = $join_column;

                @$join_table1 = $join_exp[2];
                @$joinTable1PK = CB::pk($join_table1);
                @$join_column1 = $join_exp[3];
                @$join_alias1 = $join_table1;

                if ($join_table1 && $join_column1) {

                    if (in_array($join_table1, $join_table_temp)) {
                        $join_alias_count += 1;
                        $join_alias1 = $join_table1 . $join_alias_count;
                    }

                    $join_table_temp[] = $join_table1;

                    $result->leftjoin($join_table1 . ' as ' . $join_alias1, $join_alias1 . '.' . $joinTable1PK, '=', $join_alias . '.' . $join_column);
                    $result->addselect($join_alias1 . '.' . $join_column1 . ' as ' . $join_column1 . '_' . $join_alias1);
                    $alias[] = $join_alias1;
                    $columns_table[$index]['type_data'] = CRUDBooster::getFieldType($join_table1, $join_column1);
                    $columns_table[$index]['field'] = $join_column1 . '_' . $join_alias1;
                    $columns_table[$index]['field_with'] = $join_alias1 . '.' . $join_column1;
                    $columns_table[$index]['field_raw'] = $join_column1;
                }

            } else {

                $result->addselect($table . '.' . $field);
                $columns_table[$index]['type_data'] = CRUDBooster::getFieldType($table, $field);
                $columns_table[$index]['field'] = $field;
                $columns_table[$index]['field_raw'] = $field;
                $columns_table[$index]['field_with'] = $table . '.' . $field;
            }
        }

        if (Request::get('q')) {
            $result->where(function ($w) use ($columns_table, $request) {
                foreach ($columns_table as $col) {
                    if (!$col['field_with']) {
                        continue;
                    }

                    if ($col['is_subquery']) {
                        continue;
                    }

                    $w->orwhere($col['field_with'], "like", "%" . Request::get("q") . "%");
                }
            });
        }

        if (Request::get('where')) {
            foreach (Request::get('where') as $k => $v) {
                $result->where($table . '.' . $k, $v);
            }
        }

        $filter_is_orderby = false;
        if (Request::get('filter_column')) {

            $filter_column = Request::get('filter_column');
            $result->where(function ($w) use ($filter_column, $fc) {
                foreach ($filter_column as $key => $fc) {

                    $value = @$fc['value'];
                    $type = @$fc['type'];

                    if ($type == 'empty') {
                        $w->whereRaw("($key is null or $key = '' or $key = 0)");
                        //$w->whereNull($key)->orWhere($key,'');
                        continue;
                    }

                    if ($value == '' || $type == '') {
                        continue;
                    }

                    if ($type == 'between') {
                        continue;
                    }

                    switch ($type) {
                        default:
                            if ($key && $type && $value) {
                                $w->where($key, $type, $value);
                            }

                            break;
                        case 'like':
                        case 'not like':
                            $value = '%' . $value . '%';
                            if ($key && $type && $value) {
                                $w->where($key, $type, $value);
                            }

                            break;
                        case 'in':
                        case 'not in':
                            if ($value) {
                                $value = explode(',', $value);
                                if ($key && $value) {
                                    $w->whereIn($key, $value);
                                }

                            }
                            break;
                    }

                }
            });

            foreach ($filter_column as $key => $fc) {
                $value = @$fc['value'];
                $type = @$fc['type'];
                $sorting = @$fc['sorting'];

                if ($sorting != '') {
                    if ($key) {
                        $result->orderby($key, $sorting);
                        $filter_is_orderby = true;
                    }
                }

                if ($type == 'between') {
                    if ($key && $value) {
                        $result->whereBetween($key, $value);
                    }

                } else {
                    continue;
                }
            }
        }

        if ($filter_is_orderby == true) {
            $data['result'] = $result->paginate($limit);

        } else {
            if ($this->orderby) {
                if (is_array($this->orderby)) {
                    foreach ($this->orderby as $k => $v) {
                        if (strpos($k, '.') !== false) {
                            $orderby_table = explode(".", $k)[0];
                            $k = explode(".", $k)[1];
                        } else {
                            $orderby_table = $table;
                        }
                        $result->orderby($orderby_table . '.' . $k, $v);
                    }
                } else {
                    $this->orderby = explode(";", $this->orderby);
                    foreach ($this->orderby as $o) {
                        $o = explode(",", $o);
                        $k = $o[0];
                        $v = $o[1];
                        if (strpos($k, '.') !== false) {
                            $orderby_table = explode(".", $k)[0];
                        } else {
                            $orderby_table = $table;
                        }
                        $result->orderby($orderby_table . '.' . $k, $v);
                    }
                }
                $result->columns[0] = 'vw_eligible_applicant.work_code';
                $data['result'] = $result->paginate($limit);
            } else {
                $data['result'] = $result->orderby($this->table . '.' . $this->primary_key, 'desc')->paginate($limit);
            }
        }

        $data['columns'] = $columns_table;

        if ($this->index_return) {
            return $data;
        }

        //LISTING INDEX HTML
        $addaction = $this->data['addaction'];

        if ($this->sub_module) {
            foreach ($this->sub_module as $s) {
                $table_parent = CRUDBooster::parseSqlTable($this->table)['table'];
                $addaction[] = [
                    'label' => $s['label'],
                    'onclick' => $s['onclick'],
                    'icon' => $s['button_icon'],
                    'url' => CRUDBooster::adminPath($s['path']) . '?parent_table=' . $table_parent . '&parent_columns=' . $s['parent_columns'] . '&parent_columns_alias=' . $s['parent_columns_alias'] . '&parent_id=[' . (!isset($s['custom_parent_id']) ? "id" : $s['custom_parent_id']) . ']&return_url=' . urlencode(Request::fullUrl()) . '&foreign_key=' . $s['foreign_key'] . '&label=' . urlencode($s['label']),
                    'color' => $s['button_color'],
                    'showIf' => $s['showIf'],
                ];
            }
        }

        $mainpath = CRUDBooster::mainpath();
        $orig_mainpath = $this->data['mainpath'];
        $title_field = $this->title_field;
        $html_contents = array();
        $page = (Request::get('page')) ? Request::get('page') : 1;
        $number = ($page - 1) * $limit + 1;
        foreach ($data['result'] as $row) {
            $html_content = array();

            if ($this->button_bulk_action) {

                $html_content[] = "<input type='checkbox' class='checkbox' name='checkbox[]' value='" . $row->{$tablePK} . "'/>";
            }

            if ($this->show_numbering) {
                $html_content[] = $number . '. ';
                $number++;
            }

            foreach ($columns_table as $col) {
                if ($col['visible'] === false) {
                    continue;
                }

                $value = @$row->{$col['field']};
                $title = @$row->{$this->title_field};
                $label = $col['label'];

                if (isset($col['image'])) {
                    if ($value == '') {
                        $value = "<aa  data-lightbox='roadtrip' rel='group_{{$table}}' title='$label: $title' href='" . asset('images/no-user-image.gif') . "'><img width='40px' height='40px' src='" . asset('images/no-user-image.gif') . "'/></a>";
                    } else {
                        $pic = (strpos($value, 'http://') !== false) ? $value : asset($value);
                        $value = "<a data-lightbox='roadtrip'  rel='group_{{$table}}' title='$label: $title' href='" . $pic . "'><img width='40px' height='40px' src='" . $pic . "'/></a>";
                    }
                }

                if (@$col['download']) {
                    $url = (strpos($value, 'http://') !== false) ? $value : asset($value) . '?download=1';
                    if ($value) {
                        $value = "<a class='btn btn-xs btn-primary' href='$url' target='_blank' title='Download File'><i class='fa fa-download'></i> Download</a>";
                    } else {
                        $value = " - ";
                    }
                }

                if (@$col['link']) {
                    $url = (strpos($value, 'http://') !== false) ? $value : asset($value);
                    if ($value) {
                        $label = "link";
                        if (strlen(@$col['link']) > 0) {
                            $label = @$col['link'];
                        }

                        $value = "<a class='' href='$url' target='_blank' title='link'>$label</a>";
                    } else {
                        $value = " - ";
                    }
                }

                if ($col['str_limit']) {
                    $value = trim(strip_tags($value));
                    $value = str_limit($value, $col['str_limit']);
                }

                if ($col['nl2br']) {
                    $value = nl2br($value);
                }

                if ($col['callback_php']) {
                    foreach ($row as $k => $v) {
                        $col['callback_php'] = str_replace("[" . $k . "]", $v, $col['callback_php']);
                    }
                    @eval("\$value = " . $col['callback_php'] . ";");
                }

                //New method for callback
                if (isset($col['callback'])) {
                    $value = call_user_func($col['callback'], $row);
                }

                $datavalue = @unserialize($value);
                if ($datavalue !== false) {
                    if ($datavalue) {
                        $prevalue = [];
                        foreach ($datavalue as $d) {
                            if ($d['label']) {
                                $prevalue[] = $d['label'];
                            }
                        }
                        if (count($prevalue)) {
                            $value = implode(", ", $prevalue);
                        }
                    }
                }

                $html_content[] = $value;
            } //end foreach columns_table
            $isApplicant = false;
            if (Session::get('is_applicant') == 1) {
                $data['isApplicant'] = true;
                $isApplicant = true;
            }
            if ($this->button_table_action):

                $button_action_style = $this->button_action_style;
                $html_content[] = "<div class='button_action' style='text-align:right'>" . view('crudbooster::components.action', compact('addaction', 'row', 'button_action_style', 'parent_field'))->render() . "</div>";

            endif; //button_table_action

            foreach ($html_content as $i => $v) {
                $this->hook_row_index($i, $v);
                $html_content[$i] = $v;
            }

            $html_contents[] = $html_content;
        } //end foreach data[result]

        $html_contents = ['html' => $html_contents, 'data' => $data['result']];

        $data['html_contents'] = $html_contents;
        $data['advertisement'] = DB::table('vacancy_ad as vad')
            ->select('vad.*', 'mj.name_np')
            ->leftjoin('mst_job_opening_type as mj', 'mj.id', '=', 'vad.opening_type_id')
            ->get();

        // dd($data);
        // dd(CRUDBooster::getCurrentMethod());
        //return view("crudbooster::default.index",$data);
        $data['ad_id'] = $this->ad_id = Request::get('ad');
        if ($data['ad_id'] == null) {
            $last_url = Request::get('lasturl');
            $gettingAdId = explode('ad=', $last_url);
            $id = $gettingAdId[1];
            if ($id != 0) {
                $data['ad_id'] = $id;
            }
        }
        if (isset($data['ad_id'])) {
            $data['md_id'] = $this->md_id = Request::get('md');
            if ($data['md_id'] == null) {
                $last_url = Request::get('lasturl');
                $gettingMdId = explode('md=', $last_url);
                $id = $gettingMdId[1];
                if ($id != 0) {
                    $data['md_id'] = $id;
                }
            }
            $data['designation'] = DB::table('vacancy_post as vp')
                ->select('md.id', 'md.name_np', 'vp.vacancy_ad_id')
                ->leftjoin('mst_designation as md', 'md.id', '=', 'vp.designation_id')
                ->where('vacancy_ad_id', $data['ad_id'])
                ->get();

        }

        // job opening types
        $data['opening_types'] = DB::table('mst_job_opening_type')->get();
        $data['opening_type_id'] = $this->opening_type_id = Request::get('ot');
        if ($data['opening_type_id'] == null) {
            $last_url = Request::get('lasturl');
            $gettingOtId = explode('ot=', $last_url);
            $id = $gettingOtId[1];
            if ($id != 0) {
                $data['opening_type_id'] = $id;
            }
        }
        return view($this->getIndex_view, $data);
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

        // var_dump($id_selected);
        // var_dump($button_name);
        // dd('s');
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
        // $query->where('vw_vacancy_applicant.is_cancelled', 0);
        // $ad_id=Request::get('ad');
        // if($ad_id!=0){
        //     $ad=DB::table('vacancy_ad')->where('id',$ad_id);
        //     if($ad->count()==0){
        //     CRUDBooster::redirect(CRUDBooster::mainpath(),trans("Not any advertisement with that id."),'warning');
        //     }
        //     else{
        //     $query->where('vacancy_ad_id', $ad_id);
        //     }

        // }
        // else{
        //     $ad_id=DB::table('vacancy_ad')->max('id');
        //     $query->where('vacancy_ad_id', $ad_id);
        // }

        $ad_id = Request::get('ad');
        if ($ad_id != 0) {
            $md_id = Request::get('md');
            if ($md_id != 0) {
                $query->where([['vacancy_ad_id', $ad_id], ['designation_id', $md_id]])
                    ->orderby('vacancy_ad_id');
            } else {
                $query->where('vacancy_ad_id', $ad_id)
                    ->orderby('vacancy_ad_id');
            }
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

}
