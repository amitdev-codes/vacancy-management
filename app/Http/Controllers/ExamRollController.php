<?php

namespace App\Http\Controllers;

use CRUDBooster;
use DB;

class ExamRollController extends BaseCBController
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
        $this->button_edit = false;
        $this->button_delete = true;
        $this->button_detail = false;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "vacancy_exam";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        # END FORM DO NOT REMOVE THIS LINE
    }

    public function getIndex()
    {
        //First, Add an auth
        if (!CRUDBooster::isView()) {
            CRUDBooster::denyAccess();
        }

        //Create your own query
        $data = [];
        $data['page_title'] = 'Roll List';
        $data['result'] = DB::table('vacancy_exam')->orderby('id', 'desc')->paginate(10);

        //Create a view. Please use `cbView` method instead of view method from laravel.
        $this->cbView('exam.roll', $data);
    }

    public function getAdd()
    {
        //Create an Auth
        if (!CRUDBooster::isCreate() && $this->global_privilege == false || $this->button_add == false) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
        }

        $data = [];
        $data['page_title'] = 'Add Data';

        //Please use cbView method instead view method from laravel
        $this->cbView('exam.roll', $data);
    }
}
