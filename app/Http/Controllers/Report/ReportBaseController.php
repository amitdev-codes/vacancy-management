<?php namespace App\Http\Controllers\Report;

error_reporting(E_ALL ^ E_NOTICE);

use CB;
use CRUDBooster;
use DB;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Session;

class ReportBaseController extends \App\Http\Controllers\BaseCBController
{
    public function cbLoader()
    {
        if ($this->is_cbLoaded) {
            return;
        }

        $this->is_report = true;
        $this->getIndex_view = "default.vacancy.AdwiseIndex";
        $this->cbInit();
        $this->getAlias();
        $this->addCommonAssets();
        $this->checkHideForm();

        //$this->primary_key                      = CB::pk($this->table);
        $this->primary_key = $this->pk($this->table, $this->alias);
        $this->columns_table = $this->col;
        $this->data_inputan = $this->form;
        $this->data['is_report'] = $this->is_report;
        $this->data['report_name'] = $this->report_name;
        $this->data['pk'] = $this->primary_key;
        $this->data['forms'] = $this->data_inputan;
        $this->data['hide_form'] = $this->hide_form;
        $this->data['addaction'] = ($this->show_addaction) ? $this->addaction : null;
        $this->data['table'] = $this->table;
        $this->data['title_field'] = $this->title_field;
        $this->data['appname'] = CRUDBooster::getSetting('appname');
        $this->data['alerts'] = $this->alert;
        $this->data['index_button'] = $this->index_button;
        $this->data['show_numbering'] = $this->show_numbering;
        $this->data['button_detail'] = $this->button_detail;
        $this->data['button_edit'] = $this->button_edit;
        $this->data['button_show'] = $this->button_show;
        $this->data['button_add'] = $this->button_add;
        $this->data['button_delete'] = $this->button_delete;
        $this->data['button_filter'] = $this->button_filter;
        $this->data['button_export'] = $this->button_export;
        $this->data['button_addmore'] = $this->button_addmore;
        $this->data['button_cancel'] = $this->button_cancel;
        $this->data['button_save'] = $this->button_save;
        $this->data['button_table_action'] = $this->button_table_action;
        $this->data['button_bulk_action'] = $this->button_bulk_action;
        $this->data['button_import'] = $this->button_import;
        $this->data['button_action_width'] = $this->button_action_width;
        $this->data['button_selected'] = $this->button_selected;
        $this->data['index_statistic'] = $this->index_statistic;
        $this->data['index_additional_view'] = $this->index_additional_view;
        $this->data['table_row_color'] = $this->table_row_color;
        $this->data['pre_index_html'] = $this->pre_index_html;
        $this->data['post_index_html'] = $this->post_index_html;
        $this->data['load_js'] = $this->load_js;
        $this->data['load_css'] = $this->load_css;
        $this->data['script_js'] = $this->script_js;
        $this->data['style_css'] = $this->style_css;
        $this->data['sub_module'] = $this->sub_module;
        $this->data['parent_field'] = (g('parent_field')) ?: $this->parent_field;
        $this->data['parent_id'] = (g('parent_id')) ?: $this->parent_id;

        if (CRUDBooster::getCurrentMethod() == 'getProfile') {
            Session::put('current_row_id', CRUDBooster::myId());
            $this->data['return_url'] = Request::fullUrl();
        }
        view()->share($this->data);
        $this->is_cbLoaded = true;
    }

    public function getGender()
    {
        $data = DB::table('mst_gender')->get();
        // var_dump($data);
        // die();
        return view('reports.gender', ["data" => $data]);

        // $pdf = PDF::loadView('reports.gender', $data);
        // return $pdf->download('invoice.pdf');

    }
    public function getIndex()
    {
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

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
        $data['page_title'] = $this->report_name;
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
        if (in_array('is_deleted', $table_columns)) {
            $result->where($this->table . '.is_deleted', 0);
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

            $desc = "Search for " . Request::get('q') . " in module " . CRUDBooster::getCurrentModule()->name;
            CRUDBooster::insertLog($desc);
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
            $sfDesc = '';
            foreach ($filter_column as $key => $fc) {
                $value = @$fc['value'];
                $type = @$fc['type'];
                $sorting = @$fc['sorting'];
                if (isset($value)) {
                    $sfDesc = $sfDesc . ' ' . $key . ' ' . $type . ' ' . $value . ',';
                }

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
                $data['result'] = $result->paginate($limit);
            } else {
                $data['result'] = $result->orderby($this->table . '.' . $this->primary_key, 'desc')->paginate($limit);
            }
        }

        $data['columns'] = $columns_table;

        if ($this->index_return) {
            return $data;
        }
        $sfDesc = 'Filter on module ' . CRUDBooster::getCurrentModule()->name . ' with ' . $sfDesc;
        CRUDBooster::insertLog($sfDesc);
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
        $this->button_bulk_action = false;
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
        if ($check_if_nt_staff || (CRUDBooster::myPrivilegeId() == 1) || (CRUDBooster::myPrivilegeId() == 5)) {
            if ((CRUDBooster::myPrivilegeId() == 5) || (CRUDBooster::myPrivilegeId() == 1)) {
                $data['advertisement'] = DB::table('vacancy_ad as vad')
                    ->select('vad.*', 'mj.name_np')
                    ->leftjoin('mst_job_opening_type as mj', 'mj.id', '=', 'vad.opening_type_id')
                    ->where([['fiscal_year_id', Session::get('fiscal_year_id')], ['vad.is_published', 1], ['vad.is_deleted', false]])
                    ->orderBy('vad.id', 'desc')
                    ->get();
            } else {
                $data['advertisement'] = DB::table('vacancy_ad as vad')
                    ->select('vad.*', 'mj.name_np')
                    ->leftjoin('mst_job_opening_type as mj', 'mj.id', '=', 'vad.opening_type_id')
                    ->where([['fiscal_year_id', Session::get('fiscal_year_id')], ['vad.is_published', 1], ['vad.is_deleted', false]])
                    ->orderBy('vad.id', 'desc')
                    ->get();
            }
        } else {
            $data['advertisement'] = DB::table('vacancy_ad as vad')
                ->select('vad.*', 'mj.name_np')
                ->leftjoin('mst_job_opening_type as mj', 'mj.id', '=', 'vad.opening_type_id')
                ->where([['fiscal_year_id', Session::get('fiscal_year_id')], ['vad.is_published', 1], ['vad.opening_type_id', 1], ['vad.is_deleted', 0]])
                ->orderBy('id', 'desc')
                ->get();
        }

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
                ->select('md.id', 'md.name_np', 'md.name_en', 'vp.vacancy_ad_id')
                ->leftjoin('mst_designation as md', 'md.id', '=', 'vp.designation_id')
                ->where([['vacancy_ad_id', $data['ad_id']], ['vp.is_deleted', false]])
                ->distinct()
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
        $desc = "Acess route " . CRUDBooster::mainpath();
        CRUDBooster::insertLog($desc);

        return view($this->getIndex_view, $data);
    }

}
