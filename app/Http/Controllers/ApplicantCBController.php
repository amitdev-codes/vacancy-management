<?php namespace App\Http\Controllers;

// use crocodicstudio\crudbooster\controllers\Controller;
use App\Utils\CBFirewall;
use Carbon\Carbon;
//use Illuminate\Http\Request;
use CB;
use CRUDBooster;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
// use Junity\Hashids\Facades\Hashids;
use Schema;
use Vinkla\Hashids\Facades\Hashids;

class ApplicantCBController extends BaseCBController
{
    public $profile_module = false;
    public function CheckBlacklistedIP($email = null)
    {
        $ip = Request::server('REMOTE_ADDR');
        if (CBFirewall::IsBlacklistedIP($ip)) {
            CRUDBooster::insertLog("Access from Blacklisted IP. email = $email");
            Session::flush();
            return redirect()->route('getLogin')->with('message', trans("OOPS! Access from Blacklisted IP $ip. You are being MONITORED."));
        }
        return false;
    }
    public function CheckWhitelistedIP($email = null)
    {
        $ip = Request::server('REMOTE_ADDR');
        if (CBFirewall::IsWhitelistedIP($ip)) {
            return true;
        } else {
            CRUDBooster::insertLog(trans("Access from unauthorized IP", ['email' => $users->email, 'ip' => $ip]));
            Session::flush();
            return redirect()->route('getLogin')->with('message', trans("Invalid Access"));
        }
    }
    public function getIndex()
    {
        

        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

        $va_id = Request::get("va_id");
        if (Session::get("is_applicant") && $this->profile_module) {
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id)[0];
            return CRUDBooster::redirect(CRUDBooster::mainpath('edit/' . $applicant_id), "Sorry you do not have privilege to access Applicant Profile List !
            ");
        }
        $this->cbLoader();

        $module = CRUDBooster::getCurrentModule();
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }
        if (!CRUDBooster::isView() && $this->global_privilege == false) {
            if ($isApplicant) {
                $encoded_applicant_id = Session::get('applicant_id');
                $applicant_id = Hashids::decode($encoded_applicant_id)[0];
                CRUDBooster::insertLog(trans('crudbooster.log_try_view', ['module' => $module->name]) . " with applicant_id " . $applicant_id);
            } else {
                CRUDBooster::insertLog(trans('crudbooster.log_try_view', ['module' => $module->name]) . " with user_id " . CRUDBooster::myId());
            }

            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        if (request('parent_table')) {
            $parentTablePK = CB::pk(g('parent_table'));
            $data['parent_table'] = DB::table(request('parent_table'))->where($parentTablePK, request('parent_id'))->first();
            if (request('foreign_key')) {
                $data['parent_field'] = request('foreign_key');
            } else {
                $data['parent_field'] = CB::getTableForeignKey(g('parent_table'), $this->table);
            }

            if ($data['parent_field']) {
                foreach ($this->columns_table as $i => $col) {
                    if ($col['name'] == $data['parent_field']) {
                        unset($this->columns_table[$i]);
                    }
                }
            }
        }
        if (isset($va_id)) {
            if ($this->table != "applicant_service_history") {
                $this->table = 'applied_' . $this->table;
            }

        }

        $data['table'] = $this->table;
        $data['table_pk'] = CB::pk($this->table);
        $data['page_title'] = $module->name;
        $data['page_description'] = cbLang('default_module_description');
        $data['date_candidate'] = $this->date_candidate;
        $data['limit'] = $limit = (request('limit')) ? request('limit') : $this->limit;

        $tablePK = $data['table_pk'];
        $table_columns = CB::getTableColumns($this->table);
        $result = DB::table($this->table)->select(DB::raw($this->table . "." . $this->primary_key));

        if (request('parent_id')) {
            $table_parent = $this->table;
            $table_parent = CRUDBooster::parseSqlTable($table_parent)['table'];
            $result->where($table_parent . '.' . request('foreign_key'), request('parent_id'));
        }

        $this->hook_query_index($result);

        if (in_array('deleted_at', $table_columns)) {
            $result->where($this->table . '.deleted_at', null);
        }

        $alias = [];
        $join_alias_count = 0;
        $join_table_temp = [];
        $table = $this->table;
        $columns_table = $this->columns_table;
        foreach ($columns_table as $index => $coltab) {

            $join = @$coltab['join'];
            $join_where = @$coltab['join_where'];
            $join_id = @$coltab['join_id'];
            $field = @$coltab['name'];
            $join_table_temp[] = $table;

            if (!$field) {
                continue;
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
            } else {
                $table = $this->table;
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

                $result->leftjoin($join_table . ' as ' . $join_alias, $join_alias . (($join_id) ? '.' . $join_id : '.' . $joinTablePK), '=', DB::raw($table . '.' . $field . (($join_where) ? ' AND ' . $join_where . ' ' : '')));
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

                if (isset($field_array[1])) {
                    $result->addselect($table . '.' . $field . ' as ' . $table . '_' . $field);
                    $columns_table[$index]['type_data'] = CRUDBooster::getFieldType($table, $field);
                    $columns_table[$index]['field'] = $table . '_' . $field;
                    $columns_table[$index]['field_raw'] = $table . '.' . $field;
                } else {
                    $result->addselect($table . '.' . $field);
                    $columns_table[$index]['type_data'] = CRUDBooster::getFieldType($table, $field);
                    $columns_table[$index]['field'] = $field;
                    $columns_table[$index]['field_raw'] = $field;
                }

                $columns_table[$index]['field_with'] = $table . '.' . $field;
            }
        }
        if (request('q')) {
            $result->where(function ($w) use ($columns_table) {
                foreach ($columns_table as $col) {
                    if (!$col['field_with']) {
                        continue;
                    }
                    if ($col['is_subquery']) {
                        continue;
                    }
                    $w->orwhere($col['field_with'], "like", "%" . request("q") . "%");
                }
            });
        }

        if (request('where')) {
            foreach (request('where') as $k => $v) {
                $result->where($table . '.' . $k, $v);
            }
        }

        $filter_is_orderby = false;
        if (request('filter_column')) {

            $filter_column = request('filter_column');
            $result->where(function ($w) use ($filter_column) {
                foreach ($filter_column as $key => $fc) {

                    $value = @$fc['value'];
                    $type = @$fc['type'];

                    if ($type == 'empty') {
                        $w->whereNull($key)->orWhere($key, '');
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
                            $orderby_table = $this->table;
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
                            $orderby_table = $this->table;
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

        //LISTING INDEX HTML
        //LISTING INDEX HTML
        $addaction = $this->data['addaction'];

        if ($this->sub_module) {
            foreach ($this->sub_module as $s) {
                $table_parent = CRUDBooster::parseSqlTable($this->table)['table'];
                $addaction[] = [
                    'label' => $s['label'],
                    'icon' => $s['button_icon'],
                    'url' => CRUDBooster::adminPath($s['path']) . '?return_url=' . urlencode(Request::fullUrl()) . '&parent_table=' . $table_parent . '&parent_columns=' . $s['parent_columns'] . '&parent_columns_alias=' . $s['parent_columns_alias'] . '&parent_id=[' . (!isset($s['custom_parent_id']) ? "id" : $s['custom_parent_id']) . ']&foreign_key=' . $s['foreign_key'] . '&label=' . urlencode($s['label']),
                    'color' => $s['button_color'],
                    'showIf' => $s['showIf'],
                ];
            }
        }

        $mainpath = CRUDBooster::mainpath();
        $orig_mainpath = $this->data['mainpath'];
        $title_field = $this->title_field;
        $html_contents = [];
        $page = (request('page')) ? request('page') : 1;
        $number = ($page - 1) * $limit + 1;
        foreach ($data['result'] as $row) {
            $html_content = [];

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
                        $value = "<a  data-lightbox='roadtrip' rel='group_{{$table}}' title='$label: $title' href='" . asset('vendor/crudbooster/avatar.jpg') . "'><img width='40px' height='40px' src='" . asset('vendor/crudbooster/avatar.jpg') . "'/></a>";
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
                        if ($prevalue && count($prevalue)) {
                            $value = implode(", ", $prevalue);
                        }
                    }
                }

                $html_content[] = $value;
            } //end foreach columns_table

            if ($this->button_table_action):

                $button_action_style = $this->button_action_style;
                $html_content[] = "<div class='button_action' style='text-align:right'>" . view('crudbooster::components.action', compact('addaction', 'row', 'button_action_style', 'parent_field'))->render() . "</div>";

            endif; //button_table_action

            foreach ($html_content as $i => $v) {
                $this->hook_row_index($i, $v);
                $html_content[$i] = $v;
            }

            $html_contents[] = $html_content;
        }
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $data['applicantID']=CRUDBooster::myId();
            $isApplicant = true;
        }

        // dd('amit');

        $html_contents = ['html' => $html_contents, 'data' => $data['result']];
        $data['html_contents'] = $html_contents;
        if (!$isApplicant) {
            $applicant_id = Request::get("applicant_id");
        } else {
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id)[0];
        }

        $desc = "Acess route " . CRUDBooster::mainpath() . " with applicant_id " . $applicant_id;
        CRUDBooster::insertLog($desc);
        if (isset($applicant_id)) {
            $data['isNtStaff'] = $this->CheckIsNtStaff($applicant_id);
        }
        $data['applicant_id']=Request::get('applicant_id');
        $data['vaID']=Request::get('va_id');

        if (!isset($va_id)) {
            $data['isNtStaff'] = $this->CheckIsNtStaff($applicant_id);
            return view($this->getIndex_view, $data);
        } else {
            $data['va_id'] = $va_id;
            $data['id'] = $applicant_id;

            $data['isNtStaff'] = $this->CheckIsNtStaff($applicant_id);
            if (CRUDBooster::myPrivilegeId() == 1 || CRUDBooster::myPrivilegeId() == 5|| CRUDBooster::myPrivilegeId() == 3) {
                if (($this->table == 'applicant_service_history' || $this->table == 'applied_applicant_edu_info' || $this->table == 'applied_applicant_leave_details'|| $this->table == 'applied_applicant_training_info'|| $this->table == 'applied_applicant_exp_info' || $this->table == 'applied_applicant_council_certificate'|| $this->table == 'applied_applicant_privilege_certificate'|| $this->table == 'applied_applicant_leave_details')) {
                    $data['erp_data'] = $this->data['erp_data'];
                    $data['merged_data'] = $this->data['merged'];
                    return view($this->getIndex_view, $data);
                } else {
                    // return view('default.archive_applicant_index', $data);
                    return view($this->getIndex_view, $data);
                }
            } else {
                return view('default.archive_applicant_index', $data);
            }

        }

    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate query of index result
    | ----------------------------------------------------------------------
    | @query = current sql query
    |
     */
    public function postAddSave()
    {
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

        $this->is_add = true;
        $this->cbLoader();
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }

        if (!CRUDBooster::isCreate() && $this->global_privilege == false) {
            if ($isApplicant) {
                $applicant_id = Session::get('applicant_id');
                $applicant_id = Hashids::decode($applicant_id)[0];
                CRUDBooster::insertLog(trans('crudbooster.log_try_add_save', ['name' => Request::input($this->title_field), 'module' => CRUDBooster::getCurrentModule()->name]) . " with applicant_id " . $applicant_id);
            } else {
                CRUDBooster::insertLog(trans('crudbooster.log_try_add_save', ['name' => Request::input($this->title_field), 'module' => CRUDBooster::getCurrentModule()->name]) . " with user_id " . CRUDBooster::myId());
            }

            CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
        }

        $this->validation();
        $this->input_assignment();

        if (Schema::hasColumn($this->table, 'created_at')) {
            $this->arr['created_at'] = date('Y-m-d H:i:s');
        }
        if (Schema::hasColumn($this->table, 'is_deleted')) {
            $this->arr['is_deleted'] = false;
        }

        $this->hook_before_add($this->arr);

        if (!isset($this->arr[$this->primary_key])) {
            // $id = DB::table($this->table)->insertGetId($this->arr);
            $this->arr[$this->primary_key] = $id = CRUDBooster::newId($this->table);
        } else {
            $id = $this->arr[$this->primary_key];
        }
        DB::table($this->table)->insert($this->arr);

        //Looping Data Input Again After Insert
        foreach ($this->data_inputan as $ro) {
            $name = $ro['name'];
            if (!$name) {
                continue;
            }

            $inputdata = Request::get($name);

            //Insert Data Checkbox if Type Datatable
            if ($ro['type'] == 'checkbox' || $ro['type'] == 'checkbox-2') {
                if ($ro['relationship_table']) {
                    $datatable = explode(",", $ro['datatable'])[0];
                    $foreignKey2 = CRUDBooster::getForeignKey($datatable, $ro['relationship_table']);
                    $foreignKey = CRUDBooster::getForeignKey($this->table, $ro['relationship_table']);
                    DB::table($ro['relationship_table'])->where($foreignKey, $id)->delete();

                    if ($inputdata) {
                        $relationship_table_pk = CB::pk($ro['relationship_table']);
                        foreach ($inputdata as $input_id) {
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
                            $relationship_table_pk = CB::pk($row['relationship_table']);
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

                for ($i = 0; $i <= $count_input_data; $i++) {
                    $fk = $ro['foreign_key'];
                    $column_data = [];
                    $column_data[$fk] = $id;
                    foreach ($columns as $col) {
                        $colname = $col['name'];
                        $column_data[$colname] = Request::get($name . '-' . $colname)[$i];
                    }
                    $child_array[] = $column_data;
                }

                $childtable = CRUDBooster::parseSqlTable($ro['table'])['table'];
                DB::table($childtable)->insert($child_array);
            }
        }

        $this->hook_after_add($this->arr[$this->primary_key]);

        $this->return_url = ($this->return_url) ? $this->return_url : Request::get('return_url');
        if (Session::get('is_applicant') == 1) {
            $isApplicant = true;
        }
        //insert log
        if ($isApplicant) {
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id)[0];
            CRUDBooster::insertLog(trans("crudbooster.log_add", ['name' => $this->arr[$this->title_field], 'module' => CRUDBooster::getCurrentModule()->name]) . " with applicant_id " . $applicant_id);
        } else {
            CRUDBooster::insertLog(trans("crudbooster.log_add", ['name' => $this->arr[$this->title_field], 'module' => CRUDBooster::getCurrentModule()->name]) . " with user_id " . CRUDBooster::myId());
        }

        if ($this->return_url) {
            if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                CRUDBooster::redirect(Request::server('HTTP_REFERER'), trans("crudbooster.alert_add_data_success"), 'success');
            } else {
                CRUDBooster::redirect($this->return_url, trans("crudbooster.alert_add_data_success"), 'success');
            }
        } else {
            if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                CRUDBooster::redirect(CRUDBooster::mainpath('add'), trans("crudbooster.alert_add_data_success"), 'success');
            } else {
                $encoded_applicant_id = Session::get('applicant_id');
                $applicant_id = Hashids::decode($encoded_applicant_id)[0];
                CRUDBooster::redirect(CRUDBooster::mainpath() . '?applicant_id=' . $applicant_id, trans("crudbooster.alert_add_data_success"), 'success');
            }
        }
    }
    public function getAdd()
    {
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

        // $id = $this->checkApplicantInvalidAccess($id);
        return parent::getAdd($id);
    }
    public function hook_query_index(&$query)
    {
        $applicant_id = Request::get("applicant_id");
        $va_id = Request::get("va_id");
        if (Session::get('is_applicant') == 1) {
            $applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($applicant_id)[0];
        }

        if (!isset($applicant_id)) {
            $applicant_id = 0;
        }

        if ($this->profile_module == true) {
            if (Session::get('is_applicant') == 1) {
                $query->where($this->table . '.id', $applicant_id);
            }

        } else if (isset($va_id)) {
            if ($this->table != "applicant_service_history") {
                $tbl = $this->table;
                //$query->where([$tbl.'.user_id', '=',$applicant_id],[$tbl.'vacancy_apply_id', '=',$va_id]);
                //$query->whereRaw($tbl . '.applicant_id=' . $applicant_id . ' and ' . $tbl . '.vacancy_apply_id=' . $va_id);

                //  if($tbl==='applied_applicant_training_info'){
                //     $query->whereRaw($tbl . '.applicant_id=' . $applicant_id);
                // }
                //  if ($tbl === 'applied_applicant_council_certificate') {
                //     $query->whereRaw($tbl . '.applicant_id=' . $applicant_id);
                // }
                // if ($tbl === 'applied_applicant_privilege_certificate') {
                //     $query->whereRaw($tbl . '.applicant_id=' . $applicant_id);
                // }else{
                //     $query->whereRaw($tbl . '.applicant_id=' . $applicant_id . ' and ' . $tbl . '.vacancy_apply_id=' . $va_id);
                // }




                    if (!in_array($tbl, ['applied_applicant_training_info', 'applied_applicant_council_certificate', 'applied_applicant_privilege_certificate'])) {
                    $query->whereRaw($tbl . '.applicant_id=' . $applicant_id . ' and ' . $tbl . '.vacancy_apply_id=' . $va_id);
                } else {
                    $query->whereRaw($tbl . '.applicant_id=' . $applicant_id);
                }
            } else {
                $query->where($this->table . '.applicant_id', $applicant_id);
            }
        } else {
            $applicant_id=Hashids::decode($applicant_id)[0];
            $query->where($this->table . '.applicant_id', $applicant_id);

        }
        //Your code here
    }
    private function checkApplicantInvalidAccess($id)
    {

        if (Session::get("is_applicant") == 1) {
            $this->cbLoader();
            if ($this->profile_module) {
                if (Session::get("applicant_id") != $id) {
                    $id = Session::get("applicant_id");
                }
                if (!is_int($id)) {
                    $id = Hashids::decode($id)[0];
                }
            } else {

                // $applicant_id = Session::get("applicant_id");
                // $id = Hashids::decode($applicant_id);
                $data = DB::table($this->table)
                    ->where("id", $id)
                    ->select("applicant_id")->first();
                if (isset($data) && isset($data->applicant_id)) {
                    $app_id = $data->applicant_id;


                    // dd($data->applicant_id,$app_id);

                    // if (!is_numeric($id)) {
                    //     $app_id = Hashids::decode($id)[0];
                    // }

                    if ($data->applicant_id != $app_id) {
                        return CRUDBooster::redirect(CRUDBooster::mainpath('?applicant_id=' . $app_id), "Sorry you do not have privilege to ACCESS other Applicant Data.");
                    }
                } else {
                    return CRUDBooster::redirect(CRUDBooster::mainpath('?applicant_id=' . Session::get("applicant_id")), "Sorry you do not have privilege to ACCESS other Applicant Data.");
                }

            }
        }
        return $id;
    }
    public function getEditEncoded($id)
    {

        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $isApplicant = true;
        }

        $id = $this->checkApplicantInvalidAccess($id);

        // dd($id);
        $this->is_edit = true;
        $this->cbLoader();
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }

        $row = DB::table($this->table)->where($this->primary_key, $id)->first();
        // dd($this->global_privilege,$this->button_edit,CRUDBooster::isRead(),$row );

        if (!CRUDBooster::isRead() && $this->global_privilege == false || $this->button_edit == false) {
            if ($isApplicant) {
                $applicant_id = Session::get('applicant_id');
                $applicant_id = Hashids::decode($applicant_id)[0];
                CRUDBooster::insertLog(trans("crudbooster.log_try_edit", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]) . " with applicant_id " . $applicant_id);
            } else {
                CRUDBooster::insertLog(trans("crudbooster.log_try_edit", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]) . " with user_id " . CRUDBooster::myId());
            }

            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $page_menu = Route::getCurrentRoute()->getActionName();
        $page_title = trans("crudbooster.edit_data_page_title", ['module' => CRUDBooster::getCurrentModule()->name, 'name' => $row->{$this->title_field}]);
        $command = 'edit';
        Session::put('current_row_id', $id);

        $isNtStaff = $this->CheckIsNtStaff($id);
        if ($isApplicant) {
            $applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($applicant_id)[0];

            // dd($applicant_id,$id);
            $desc = "Acess route " . CRUDBooster::mainpath() . "/edit/" . $id . " with applicant_id " . $applicant_id;
        } else {
            $desc = "Acess route " . CRUDBooster::mainpath() . "/edit/" . $id . " with user_id " . CRUDBooster::myId();
        }

        CRUDBooster::insertLog($desc);
         $applicant_id=$id;
        return view($this->getEdit_view, compact('id', 'applicant_id','row', 'page_menu', 'page_title', 'command', 'isApplicant', 'isNtStaff'));
    }

    public function getEdit($id)
    {
        $applicant_id=Request::get('applicant_id');
        $vaID=Request::get('va_id');


        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

        if (!is_numeric($id)) {
            $id = Hashids::decode($id)[0];
        }
        $id = $this->checkApplicantInvalidAccess($id);
        $this->is_edit = true;
        $this->cbLoader();

        $priv_id = CRUDBooster::myPrivilegeId();
        $v_apply_id = (int) explode('va_id=', $_REQUEST['return_url'], 2)[1];
        if (isset($v_apply_id) && $v_apply_id != 0) {
            if ($priv_id != 4) {
                if ($this->table != 'applicant_service_history') {
                    $this->table = 'applied_' . $this->table;
                }

            }
        }

        $row = DB::table($this->table)->where($this->primary_key, $id)->first();

        //dd($row,$this->table);

        if (!CRUDBooster::isRead() && $this->global_privilege == false || $this->button_edit == false) {
            CRUDBooster::insertLog(trans("crudbooster.log_try_edit", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $page_menu = Route::getCurrentRoute()->getActionName();
        $page_title = trans("crudbooster.edit_data_page_title", ['module' => CRUDBooster::getCurrentModule()->name, 'name' => $row->{$this->title_field}]);
        $command = 'edit';
        Session::put('current_row_id', $id);
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $isApplicant = true;
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id)[0];
            $isNtStaff = $this->CheckIsNtStaff($applicant_id);
            $desc = "Acess route " . CRUDBooster::mainpath() . "/edit/" . $id . " with applicant_id " . $applicant_id;
            CRUDBooster::insertLog($desc);
        } else {
            $desc = "Acess route " . CRUDBooster::mainpath() . "/edit/" . $id . " with applicant_id " . Session::get('applicant_id');
            CRUDBooster::insertLog($desc);
            $applicant_id = $id;
            $isNtStaff = $this->CheckIsNtStaff($applicant_id);
        }
        $desc = "Acess route " . CRUDBooster::mainpath() . "/edit/" . $id . " with applicant_id " . Session::get('applicant_id');
        CRUDBooster::insertLog($desc);
        return view($this->getEdit_view, compact('id','vaID','applicant_id', 'row', 'page_menu','applicant_id', 'page_title', 'command', 'isApplicant', 'isNtStaff'));
    }

    public function getArchive($id,$applicant_id)
    {
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $isApplicant = true;
        }
        $applicant_id = $this->checkApplicantInvalidAccess($applicant_id);
        $this->cbLoader();
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }

        // dd($this->table);
        $this->table="applicant_profile";
        $row = DB::table('applied_' . $this->table)->where('vacancy_apply_id', $id)->first();
        if ($this->table = "applicant_profile") {
            if ($row->user_id == null) {
                $isNtStaff = $this->CheckIsNtStaff($row->applicant_id);
            } else {
                $isNtStaff = $this->CheckIsNtStaff($row->user_id);
            }
        } else {

            $isNtStaff = $this->CheckIsNtStaff($applicant_id);
        }



        if (!CRUDBooster::isRead() && $this->global_privilege == false || $this->button_edit == false) {
            if ($isApplicant) {
                $applicant_id = Session::get('applicant_id');
                $applicant_id = Hashids::decode($applicant_id)[0];
                CRUDBooster::insertLog(trans("crudbooster.log_try_edit", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]) . " with applicant_id " . $applicant_id);
            } else {
                CRUDBooster::insertLog(trans("crudbooster.log_try_edit", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]) . " with user_id " . CRUDBooster::myId());
            }

            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $page_menu = Route::getCurrentRoute()->getActionName();
        $page_title = trans("crudbooster.edit_data_page_title", ['module' => CRUDBooster::getCurrentModule()->name, 'name' => $row->{$this->title_field}]);
        $command = 'edit';
        Session::put('current_row_id', $id);

        if ($isApplicant) {
            return parent::getEdit($id);
        } else {
            if($id){
                $applicant=DB::table('vacancy_apply')->whereId($id)->select('applicant_id')->first();
                $applicant_id=$applicant->applicant_id;
            }
            return view("default.archive_applicant_form", compact('id','applicant_id', 'row', 'page_menu', 'page_title', 'command', 'isApplicant', 'isNtStaff'));
        }
    }
    public function getView($id)
    {
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP($email);
        if ($resp != false) {
            return $resp;
        }

        if (!is_numeric($applicant_id)) {
            $id = Hashids::decode($id)[0];
        }
        $id = $this->checkApplicantInvalidAccess($id);

        return parent::getView($id);
    }

    public function getDetail($id)
    {

        // dd('dev');
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

        $this->is_detail = true;
        $this->cbLoader();
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }

        $priv_id = CRUDBooster::myPrivilegeId();
        if ($priv_id != 4) {
            $va_id = (int) explode('va_id=', $_REQUEST['return_url'], 2)[1];
        } else {
            $va_id = Request::get("va_id");
        }

        if (isset($va_id) && $va_id != 0) {
            if ($priv_id != 4) {
                if ($this->table != 'applicant_service_history') {
                    $this->table = 'applied_' . $this->table;
                }

                if ($this->table == 'applied_applicant_profile') {
                    $id = DB::table($this->table)->where('user_id', $id)->first();
                    $id = $id->id;
                }
            }
        }
        $row = DB::table($this->table)->where($this->primary_key, $id)->first();

        if (!CRUDBooster::isRead() && $this->global_privilege == false || $this->button_detail == false) {
            if ($isApplicant) {
                $applicant_id = Session::get('applicant_id');
                $applicant_id = Hashids::decode($applicant_id)[0];
                CRUDBooster::insertLog(trans("crudbooster.log_try_view", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]) . ' with applicant_id ' . $applicant_id);
            } else {
                CRUDBooster::insertLog(trans("crudbooster.log_try_view", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]) . " with user_id " . CRUDBooster::myId());
            }
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }
        $module = CRUDBooster::getCurrentModule();

        $page_menu = Route::getCurrentRoute()->getActionName();
        $page_title = trans("crudbooster.detail_data_page_title", ['module' => $module->name, 'name' => $row->{$this->title_field}]);
        $command = 'detail';
        if ($isApplicant) {
            $applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($applicant_id)[0];
            $desc = 'View data of id ' . $id . ' on module ' . CRUDBooster::getCurrentModule()->name . ' with applicant_id ' . $applicant_id;
        } else {
            $desc = 'View data of id ' . $id . ' on module ' . CRUDBooster::getCurrentModule()->name . ' with user_id ' . CRUDBooster::myId();
        }

        CRUDBooster::insertLog($desc);
        Session::put('current_row_id', $id);

        return view('crudbooster::default.form', compact('row', 'page_menu', 'page_title', 'command', 'id'));
    }

    public function getDelete($id)
    {
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP($email);
        if ($resp != false) {
            return $resp;
        }

        if (!is_numeric($id)) {
            $id = Hashids::decode($id)[0];
        }
        $id = $this->checkApplicantInvalidAccess($id);

        return parent::getDelete($id);
    }

    public function getDeleteImage($id = null)
    {
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP($email);
        if ($resp != false) {
            return $resp;
        }

        $id = Request::get('id');
        if (!is_numeric($id)) {
            $id = Hashids::decode($id)[0];
        }
        $id = $this->checkApplicantInvalidAccess($id);

        return parent::getDeleteImage($id);
    }
    public function postEditSave($id)
    {
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }

        if (!is_numeric($id)) {
            $id = Hashids::decode($id)[0];
        }
        $id = $this->checkApplicantInvalidAccess($id);
        //Decode id
        // if (strlen($id[0]) == 10) {
        //     $hashid = Hashids::decode($id);
        //     $id = $hashid[0];
        // }
        return parent::postEditSaveApplicant($id);
    }
    public function CheckIsNtStaff($id)
    {
        // dd($id);
        //check here for BLACKLISTED IP
        $resp = $this->CheckBlacklistedIP();
        if ($resp != false) {
            return $resp;
        }
        if(!empty($id)){
            $row = DB::table('applicant_profile')->where('id', $id)->first();
        }

        $isNtStaff=$row->is_nt_staff;
        if($isNtStaff){
            return true;
        }else{
            return false;
        }

    }

    //delete, postEditSave, postAddSave

    //amit changes
    public function getpassword(Request $request)
    {

        $id = CRUDBooster::myId();
        //dd($id);
        $oldpassword = $request->get('current_password');
        $users = DB::table(config('crudbooster.USER_TABLE'))->where('id', $id)->first();
        $newpassword = $request->get('newpassword');

        $passwordconfirm = $request->get('password_confirmation');

        if (\Hash::check($oldpassword, $users->password) || $oldpassword == $users->password) {
            if ($newpassword == $passwordconfirm) {
                $date = Carbon::now();
                $data = array('password' => $newpassword, 'updated_at' => $date);

                $changed_password = DB::table('cms_users')
                    ->where('id', '=', $id)
                    ->update($data);
                // ->insert($data);

                return redirect(CRUDBooster::adminPath());

            } else {
                echo "<script>alert('new password and confirm password doesnot match');history.go(-1);</script>";
            }
        } else {
            echo "<script>alert('" . trans('crudbooster.alert_password_wrong') . "');history.go(-1);</script>";
        }
    }

    //end of amit changes

}
