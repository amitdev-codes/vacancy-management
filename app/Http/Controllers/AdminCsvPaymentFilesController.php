<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Illuminate\Support\Facades\Log;
use App\Helpers\PaymentLinker;

class AdminCsvPaymentFilesController extends BaseCBController
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
        //$this->button_action_style = "button_icon_text";
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "csv_payment_files";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Uploaded by User", "name" => "uploader_user_id", "join" => "cms_users,name"];
        $this->col[] = ["label" => "Uploaded Date Ad", "name" => "uploaded_date_ad"];
        $this->col[] = ["label" => "Uploaded Date Bs", "name" => "uploaded_date_bs"];
        $this->col[] = ["label" => "File Path", "name" => "file_path", "callback" => function ($row) {
            $f = explode("/", $row->file_path);
            if ($f && count($f) > 0) {
                return $f[count($f) - 1];
            }
            return $row->file_path;
        }];
        $this->col[] = ["label" => "File Path", "name" => "file_path", "download" => "Y"];
        $this->col[] = ["label" => "failed_receipts", "name" => "failed_receipts"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Uploader User', 'name' => 'uploader_user_id', 'type' => 'text-c', 'cmp-ratio' => '12:2:10', 'value' => CRUDBooster::me()->name, "readonly" => "readonly"];
        $this->form[] = ['label' => 'Date Bs', 'name' => 'uploaded_date_bs', 'type' => 'date-n', 'validation' => 'required|max:10', 'cmp-ratio' => '6:4:8'];
        $this->form[] = ['label' => 'Date Ad', 'name' => 'uploaded_date_ad', 'type' => 'date-c', 'validation' => 'required|date', 'cmp-ratio' => '6:4:8'];
        $this->form[] = ['label' => 'File Path', 'name' => 'file_path', 'type' => 'upload-c', 'validation' => 'required|mimes:csv,txt', 'cmp-ratio' => '12:2:10'];
        $this->form[] = ['label' => 'Failed Receipts', 'name' => 'failed_receipts', 'type' => 'textarea-c', 'validation' => 'max:2000', 'cmp-ratio' => '12:2:10', "readonly" => "readonly"];
        $this->form[] = ['label' => 'Task Status', 'name' => 'task_status', 'type' => 'textarea-c', 'validation' => 'max:2000', 'cmp-ratio' => '12:2:10', "readonly" => "readonly"];
        $this->form[] = ['label' => 'Remarks', 'name' => 'remarks', 'type' => 'textarea-c', 'validation' => 'max:500', 'cmp-ratio' => '12:2:10'];
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
        //$this->addaction = array();
        $this->addaction[] = ['label' => 'Import/Link', 'url' => CRUDBooster::mainpath('../csv_payment_files/import/[id]'), 'icon' => 'fa fa-link', 'color' => 'success'];
        //,'showIf'=>"[status] == 'pending'"
        ///[id]

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
        $this->script_js = "$(document).ready(function(){
			$('#uploaded_date_ad').change(function(){
				convertAdtoBs('#uploaded_date_ad','#uploaded_date_bs');
			});
				$('#uploaded_date_bs').change(function(){
							convertBstoAd('#uploaded_date_bs','#uploaded_date_ad');
					});
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
        $postdata["uploader_user_id"] = Session::get("admin_id");
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
    private $duplicate_receipt_numbers = array();
    private function process_row($row, $csv_payment_file_id)
    {
        $data = [];
        //if(count($row) == 5){
        $data["csv_payment_file_id"] = $csv_payment_file_id;
        $data["importer_user_id"] = CRUDBooster::myId();
        $data["imported_date_ad"] = date('Y-m-d H:i:s');
        $data["token_number_text"] = $row[4];
        $data["token_number"] = preg_replace("/[^0-9,.]/", "", $row[4]);
        $data["amount_paid"] = $row[1];
        $data["receipt_number"] = $row[3];
            // $data["receipt_date_ad"] =  ;
        if (strlen($row[2]) > 0) {
            $data["receipt_date_ad"] = date('Y-m-d', date_create_from_format('d-M-y', $row[2])->getTimestamp());
        } else {
            $data["receipt_date_ad"] = null;
        }
        $data["applicant_name"] = $row[0];
        // }
        // else{
        // 	$data["csv_payment_file_id"] =  $csv_payment_file_id;
        // 	$data["importer_user_id"] =  CRUDBooster::myId();
        // 	$data["imported_date_ad"] =  date('Y-m-d H:i:s');
        // 	$data["token_number_text"] =  $row[5];
        // 	$data["token_number"] =  preg_replace("/[^0-9,.]/", "", $row[5]);
        // 	$data["amount_paid"] =  $row[2];
        // 	$data["receipt_number"] =  $row[4];
        // 	// $data["receipt_date_ad"] =  ;
        // 	if(strlen($row[3])>0)
        // 		$data["receipt_date_ad"] = \App\Helpers\VAARS::DateFormated($row[3]);
        // 		//$data["receipt_date_ad"] = date('Y-m-d', date_create_from_format('d-M-y', $row[3])->getTimestamp());
        // 	else
        // 		$data["receipt_date_ad"] = null;
        // 		$data["applicant_name"] =  $row[0];
        // }
        return $data;
    }
    public function import($id = null)
    {
        if (isset($id) && $id > 0) {
            $id = \intval($id);
            $csvFile = DB::table("csv_payment_files")->where("id", "=", $id)->first();
            if (isset($csvFile)) {
                $skip_rows = 1;
                $count = 0;
                $arr = [];
                $arr_uq = [];
                //import data into the database.
                try {
                    if (($handle = fopen(storage_path() . "/app/" . $csvFile->file_path, 'r')) !== false) {
                        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                            $count++;
                            if ($count <= $skip_rows) {
                                continue;
                            }
                            // file_path
                            $data = [];
                            $data = $this->process_row($row, $id);
                            if (array_key_exists($data["receipt_number"], $arr)) {
                                //if receipt number exist then log it.
                                $arr_uq[$data["receipt_number"]] = $data["receipt_number"];
                            }

                            $arr[$data["receipt_number"]] = $data;
                            // $arr_uq_check[]=$data["receipt_number"];
                        }
                        fclose($handle);
                    }
                } catch (Exception $e) {
                    Log::error($e);
                    $msg = "Error while trying to process CSV File. <BR/>Please verify CSV file & re-upload and try importing again. <BR/>If problem comes again contact System Development Team or Repective Personnel.";
                    $res = redirect()->back()
                        //->with("errors",$message)
                        ->with(['message' => $msg, 'message_type' => 'warning'])
                        ->withInput();
                    \Session::driver()->save();
                    $res->send();
                    exit();
                }
            } else {
                $msg = "Error while trying to process CSV File. Please verify CSV file & re-upload and try importing again. If problem comes again contact System Development Team or Repective Personnel.";
                $res = redirect()->back()
                    //->with("errors",$message)
                    ->with(['message' => $msg, 'message_type' => 'warning'])
                    ->withInput();
                \Session::driver()->save();
                $res->send();
                exit();
            }
            if (count($arr_uq) > 0) {
                //
                $this->duplicate_receipt_numbers = $arr_uq;
                // $msg = "CSV being imported has duplicate Receipt Number in please check CSV & re-upload <BR/>
                // Duplicate Receipt Numbers are = ".implode(", ", $arr_uq);
                // $res = redirect()->back()
                // 	//->with("errors",$message)
                // 	->with(['message'=>$msg,'message_type'=>'warning'])
                // 	->withInput();
                // 	\Session::driver()->save();
                // 	$res->send();
                // exit();
            }
            //now insert the data into the database
            // var_dump($arr);
            $msg = $this->populateDB($id, $arr);
            $this->linkReceiptAndApplication($id);
            // $this->sendEmailAboutLinkage($id);

            $res = redirect()->back()
                //->with("errors",$message)
                ->with(['message' => $msg, 'message_type' => 'success'])
                ->withInput();
            \Session::driver()->save();
            $res->send();
            exit();
        }
        // error message
        $res = redirect()->back()
            //->with("errors",$message)
            ->with(['message' => "Import ID not provided", 'message_type' => 'warning'])
            ->withInput();
        \Session::driver()->save();
        $res->send();
        exit();
    }
    private function populateDB($id, &$dataArr)
    {
        $total = count($dataArr);
        $insert = 0;
        $update = 0;
        $neglected = 0;
        try {
            DB::beginTransaction();
            foreach ($dataArr as $itm) {
                if (in_array($itm["receipt_number"], $this->duplicate_receipt_numbers)) {
                    continue;
                }
                $dtls = DB::table("csv_payment_file_details")
                    ->where("receipt_number", $itm["receipt_number"])->first();
                if (isset($dtls) && count($dtls) > 0) {
                    if (isset($dtls->linked_application_id) && $dtls->linked_application_id > 0) {
                        $neglected++;
                    } else {
                        DB::table("csv_payment_file_details")
                            ->where("receipt_number", $itm["receipt_number"])
                            ->update($itm);
                        $update++;
                    }
                } else {
                    CRUDBooster::insert("csv_payment_file_details", $itm);
                    $insert++;
                }
            }
            $msg = "Out of $total records
				<BR/>$insert record(s) are Added
				<BR/>$update record(s) are Updated
				<BR/>$neglected record(s) are Ignored as they are already linked.";

            $failed = "";
            if (isset($this->duplicate_receipt_numbers) && count($this->duplicate_receipt_numbers) > 0) {
                $failed = implode(",", $this->duplicate_receipt_numbers);
            }
            DB::table("csv_payment_files")
                ->where("id", $id)
                ->update([
                    "failed_receipts" => $failed,
                    "task_status" => $msg
                ]);

            DB::commit();
        } catch (\PDOException $e) {
            Log::error($e);
            // error message
            $res = redirect()->back()
                //->with("errors",$message)
                ->with(['message' => "Error while trying to Import CSV file. <BR/>Try again. <BR/>If problem comes again contact System Development Team or Repective Personnel.", 'message_type' => 'error'])
                ->withInput();
            \Session::driver()->save();
            $res->send();
            exit();
        }

        $msg = "Out of $total records
			<BR/>$insert record(s) are Added
			<BR/>$update record(s) are Updated
			<BR/>$neglected record(s) are Ignored as they are already linked.";
        return $msg;
    }

    public static function linkReceiptAndApplication($id)
    {
        try {
            DB::beginTransaction();
            //link records
            DB::statement("UPDATE csv_payment_file_details cd
				INNER JOIN vacancy_apply va on cd.token_number = va.token_number
			SET cd.is_linked = 1
				, cd.linked_application_id = va.id
			WHERE cd.csv_payment_file_id = $id
				and (is_email_sent != 1
					OR va.is_cancelled != 1)");
            //QUERY to un-link which got cancelled.
            DB::statement("UPDATE csv_payment_file_details cd
					INNER JOIN vacancy_apply va on cd.token_number = va.token_number
				SET cd.is_linked = 0
					, cd.linked_application_id = null
				WHERE va.is_cancelled = 1");

            //update the paid applications
            DB::statement("UPDATE vacancy_apply v
					INNER JOIN (
						SELECT cd.linked_application_id, sum(cd.amount_paid) amount_paid, cd.receipt_number, cd.receipt_date_ad
						FROM csv_payment_file_details cd
							INNER JOIN vacancy_apply va on cd.linked_application_id = va.id
						WHERE cd.linked_application_id is not null
						GROUP BY cd.linked_application_id,  cd.receipt_number, cd.receipt_date_ad
					) d on v.id = d.linked_application_id
				SET v.total_paid_amount = d.amount_paid, v.paid_receipt_no = d.receipt_number, v.paid_date_ad = d.receipt_date_ad
					, v.is_paid = CASE WHEN d.amount_paid = v.total_amount THEN 1 ELSE 0 END
				");

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($err);
            // error message
            $res = redirect()->back()
                //->with("errors",$message)
                ->with(['message' => "Error while trying to link the receipt & application. <BR/>Try again. <BR/>If problem comes again contact System Development Team or Repective Personnel.", 'message_type' => 'error'])
                ->withInput();
            \Session::driver()->save();
            $res->send();
            exit();
        }
    }

    private function sendEmailAboutLinkage($id)
    {
        //List  those records which has been
        $list = DB::select('SELECT cd.linked_application_id, va.total_amount total_amount_payable, va.total_paid_amount, va.total_amount - va.total_paid_amount remaining_amount
			, cd.receipt_date_ad,cd.receipt_number,va.token_number, cd.amount_paid receipt_amount
			, va.applied_date_ad, va.applied_date_bs
			, d.name_en designation_name_en, d.name_np designation_name_np
			, Concat(ap.first_name_en, \' \', COALESCE(ap.mid_name_en,\'\'), \' \', ap.last_name_en) full_name_en
			, Concat(ap.first_name_np, \' \', COALESCE(ap.mid_name_np,\'\'), \' \', ap.last_name_np) full_name_np, ap.email
			, cd.id csv_payment_file_details_id, va.applicant_id, ap.user_id
			, va.is_paid, cd.id
		FROM csv_payment_file_details cd
			INNER JOIN vacancy_apply va on cd.linked_application_id = va.id
			INNER JOIN applicant_profile ap on va.applicant_id = ap.id
			LEFT JOIN mst_designation d on va.designation_id = d.id
			LEFT JOIN vacancy_post vp on va.vacancy_post_id = vp.id
		WHERE cd.linked_application_id is not null
			AND cd.is_email_sent = 0
			AND cd.csv_payment_file_id =:id',['id'=>$id]);

        if (isset($list) && count($list) > 0) {
            $sent_ids = [];
            foreach ($list as $item) {
                if ($item->is_paid == 1) {
                    \App\Helpers\VAARS::sendEmail(['to' => $item->email, 'data' => $item, 'template' => 'email_after_receipt_linked_full_payment']);
                } else {
                    \App\Helpers\VAARS::sendEmail(['to' => $item->email, 'data' => $item, 'template' => 'email_after_receipt_linked_partial_payment']);
                }
                $send_ids[] = $item->id;
            }
            //---
            DB::table('csv_payment_file_details')
                ->whereIn('id', $send_ids)
                ->update([
                    "is_email_sent" => 1,
                    "email_sent_date_ad" => date('Y-m-d H-i-s')
                ]);
        }
    }

    private function sendEmail($data)
    {
    }

    public function relink($id)
    {
        $this->relinkReceiptAndApplication($id);
        $this->sendEmailAboutReLinkage($id);
        DB::table('csv_payment_file_details')
            ->where('id', $id)
            ->update([
                "link_email_log_path" => '',
                "is_email_sent" => 0
            ]);
        PaymentLinker::sendLinkageEmail();
        CRUDBooster::redirect(CRUDBooster::adminPath() . '/csv_payment_file_details', trans("Relink success."), 'success');
    }

    public static function relinkReceiptAndApplication($id)
    {
        try {
            DB::beginTransaction();
            //link records
            DB::statement("UPDATE csv_payment_file_details cd
				INNER JOIN vacancy_apply va on cd.token_number = va.token_number
			SET cd.is_linked = 1
				, cd.linked_application_id = va.id
			WHERE cd.id = $id
				and (is_email_sent != 1
					OR va.is_cancelled != 1)");
            //QUERY to un-link which got cancelled.
            // DB::statement("UPDATE csv_payment_file_details cd
			// 		INNER JOIN vacancy_apply va on cd.token_number = va.token_number
			// 	SET cd.is_linked = 0
			// 		, cd.linked_application_id = null
			// 	WHERE va.is_cancelled = 1");

            //update the paid applications
            DB::statement("UPDATE vacancy_apply v
					INNER JOIN (
						SELECT cd.linked_application_id, sum(cd.amount_paid) amount_paid, cd.receipt_number, cd.receipt_date_ad
						FROM csv_payment_file_details cd
							INNER JOIN vacancy_apply va on cd.linked_application_id = va.id
						WHERE cd.linked_application_id is not null
						GROUP BY cd.linked_application_id,  cd.receipt_number, cd.receipt_date_ad
					) d on v.id = d.linked_application_id
				SET v.total_paid_amount = d.amount_paid, v.paid_receipt_no = d.receipt_number, v.paid_date_ad = d.receipt_date_ad
					, v.is_paid = CASE WHEN d.amount_paid = v.total_amount THEN 1 ELSE 0 END
				");

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($err);
            // error message
            $res = redirect()->back()
                //->with("errors",$message)
                ->with(['message' => "Error while trying to link the receipt & application. <BR/>Try again. <BR/>If problem comes again contact System Development Team or Repective Personnel.", 'message_type' => 'error']);

            $res->send();
            exit();
        }

    }

    private function sendEmailAboutReLinkage($id)
    {
        //List  those records which has been
        $list = DB::select('SELECT cd.linked_application_id, va.total_amount total_amount_payable, va.total_paid_amount, va.total_amount - va.total_paid_amount remaining_amount
			, cd.receipt_date_ad,cd.receipt_number,va.token_number, cd.amount_paid receipt_amount
			, va.applied_date_ad, va.applied_date_bs
			, d.name_en designation_name_en, d.name_np designation_name_np
			, Concat(ap.first_name_en, \' \', COALESCE(ap.mid_name_en,\'\'), \' \', ap.last_name_en) full_name_en
			, Concat(ap.first_name_np, \' \', COALESCE(ap.mid_name_np,\'\'), \' \', ap.last_name_np) full_name_np, ap.email
			, cd.id csv_payment_file_details_id, va.applicant_id, ap.user_id
			, va.is_paid, cd.id
		FROM csv_payment_file_details cd
			INNER JOIN vacancy_apply va on cd.linked_application_id = va.id
			INNER JOIN applicant_profile ap on va.applicant_id = ap.id
			LEFT JOIN mst_designation d on va.designation_id = d.id
			LEFT JOIN vacancy_post vp on va.vacancy_post_id = vp.id
		WHERE
        cd.linked_application_id is not null
			AND
            cd.id =:id',['id'=>$id]);


            // dd($list);

        if (isset($list) && count($list) > 0) {
            $sent_ids = [];
            foreach ($list as $item) {
                if ($item->is_paid == 1) {
                    \App\Helpers\VAARS::sendEmail(['to' => $item->email, 'data' => $item, 'template' => 'email_after_receipt_linked_full_payment']);
                    // $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "receipt_relinked", ['to'=>$applicant->email, 'data'=>$item, 'template'=>'email_after_receipt_linked_full_payment']);
                    // //update log
                    // DB::table('vacancy_apply')
                    //     ->where('id', $id)
                    //     ->update(['cancel_email_log_path' => $log_file]);
                } else {
                    \App\Helpers\VAARS::sendEmail(['to' => $item->email, 'data' => $item, 'template' => 'email_after_receipt_linked_partial_payment']);
                    // $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "receipt_relinked", ['to'=>$applicant->email, 'data'=>$item, 'template'=>'email_after_receipt_linked_partial_payment']);
                    // //update log
                    // DB::table('vacancy_apply')
                    //     ->where('id', $id)
                    //     ->update(['cancel_email_log_path' => $log_file]);
                }
                $send_ids[] = $item->id;
            }
            //---
            DB::table('csv_payment_file_details')
                ->whereIn('id', $send_ids)
                ->update([
                    "is_email_sent" => 1,
                    "email_sent_date_ad" => date('Y-m-d H-i-s')
                ]);
        }
    }
    //By the way, you can still create your own method in here... :)
}
