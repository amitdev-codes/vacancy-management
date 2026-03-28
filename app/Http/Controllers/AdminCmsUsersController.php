<?php namespace App\Http\Controllers;

use CRUDbooster;
use DB;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Request;
use Session;
use Validator;

class AdminCmsUsersController extends BaseCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = 'cms_users';
        $this->primary_key = 'id';
        $this->title_field = "name";
        $this->button_action_style = 'button_icon';
        $this->button_import = false;
        $this->button_export = false;
        $this->button_bulk_action = false;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE

        $this->col = array();
        $this->col[] = array("label" => "Name", "name" => "name");
        $this->col[] = array("label" => "Email", "name" => "email");
        $this->col[] = array("label" => "Privilege", "name" => "id_cms_privileges", "join" => "cms_privileges,name");
        $this->col[] = array("label" => "Photo", "name" => "photo","image" => true);
        $this->col[] = array("label" => "Status", "name" => "status");
        $this->col[] = array("label" => "Is Activated","name" => "case when is_activated = 1 then 'YES' ELSE 'NO' END as is_activated");
        $this->col[] = array("label" => "Is Deleted","name" => "is_deleted");
        $this->col[] = array("label" => "Created Date", "name" => "created_at");
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = array();
        $this->form[] = array("label" => "Name", "name" => "name", 'required' => true, 'validation' => 'required|min:3');
        //$this->form[] = array("label"=>"Photo","name"=>"photo","type"=>"upload","help"=>"Recommended resolution is 200x200px",'required'=>false,'validation'=>'image|max:1000');
        if (Session::get("is_applicant") != 1) {
            $this->form[] = array("label" => "Email", "name" => "email", 'required' => true, 'type' => 'email', 'validation' => 'required|email|unique:cms_users,email,' . CRUDBooster::getCurrentId());
            $this->form[] = array("label" => "Privilege", "name" => "id_cms_privileges", "type" => "select", "datatable" => "cms_privileges,name", 'required' => true);
            $this->form[] = array("label" => "Mobile No.", "name" => "mobile_no", 'required' => true, 'validation' => 'required|digits:10', 'type' => 'number');
            $this->form[] = array("label" => "Is Activated","name" => "is_activated",'type' => 'radio','dataenum' => '1|Yes ; 0|No');
            $this->form[] = array("label" => "Is Deleted","name" => "is_deleted",'type' => 'radio','dataenum' => '1|Yes ; 0|No');
        } else {
            $this->form[] = array("label" => "Email", "name" => "email", 'required' => true, 'readonly' => true, 'type' => 'email', 'validation' => 'required|email|unique:cms_users,email,' . CRUDBooster::getCurrentId());
        }
        // $this->form[] = array("label"=>"Password","name"=>"password","validation"=>'min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',"type"=>"password","help"=>"Please leave empty if not change");

        $password = $this->generateStrongPassword();
        if ($this->is_add) {
            $this->form[] = array("label" => "Password", "name" => "password", 'required' => true, 'value' => $password);
        } else {
            $this->form[] = array("label" => "Password", "name" => "password", 'value' => $password, 'type' => 'password', "help" => "Please leave empty if not change");
        }

        $this->form[] = array("label" => "Password Changed", "name" => "password_changed", 'required' => true, 'value' => 0, "type" => "hidden");

        # END FORM DO NOT REMOVE THIS LINE
    }

    public function getProfile()
    {

        $this->button_addmore = false;
        $this->button_cancel = false;
        $this->button_show = false;
        $this->button_add = false;
        $this->button_delete = false;
        $this->hide_form = ['id_cms_privileges'];

        $data['page_title'] = trans("crudbooster.label_button_profile");
        $data['row'] = CRUDBooster::first('cms_users', CRUDBooster::myId());
        //$data['button_save']=true;
        $this->cbView('default.profile_edit', $data);
    }

    public function editProfile(Request $request)
    {
        $email = $request::get('existing_email');
        $id = DB::table('cms_users')
            ->select('id')
            ->where('email', $email)
            ->first();
        $c_id = CRUDBooster::myId();
        if ($id->id == $c_id) {
            //$email_up=$request::get('email');
            $name_up = $request::get('name');
            $pass_up = $request::get('password');
            $arr = $this->checkifUpdated($name_up, $pass_up);
            $errors = $this->validateData($arr);
            $arr['password_changed'] = 1;

            if (isset($errors)) {
                return Redirect::back()->with('Error', $errors['message']);

            } else {
                if (isset($arr['password'])) {
                    $arr['password'] = \Hash::make($arr['password']);
                }
                DB::table('cms_users')->where('id', $c_id)->update($arr);
                return Redirect::back()->with('success', 'Data Updated Successfully.');
            }

        } else {
            CRUDBooster::insertLog(trans("Tried to edit other users.", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));
            return Redirect::back()->with('Error', 'You do not have this previlage.');

        }
    }

    public function validateData($arr)
    {

        if (isset($arr['password'])) {
            $validator = Validator::make($arr, [
                'password' => 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            ]);
            if ($validator->fails()) {
                $errors['message'] = $errors['message'] . "Password must contain at least one capital letter, one number, one special character and must be more than 6 characters long.";
            }
            // $len=strlen($arr['password']);
            // if($len<6){
            //     $errors['message']=$errors['message']."Password length shoud be 6 or more.";
            // }
        }
        return $errors;

    }
    public function checkifUpdated($name_up, $pass_up)
    {
        $inputarr = array();
        $user = DB::table('cms_users')
            ->where('id', CRUDBooster::myId())
            ->first();

        if ($pass_up != "") {
            $inputarr['password'] = $pass_up;
        }
        if ($user->name != $name_up) {
            $inputarr['name'] = $name_up;
        }
        return $inputarr;

    }

    public function generateStrongPassword($length = 8, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false) {
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        }

        if (strpos($available_sets, 'u') !== false) {
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        }

        if (strpos($available_sets, 'd') !== false) {
            $sets[] = '23456789';
        }

        if (strpos($available_sets, 's') !== false) {
            $sets[] = '!@#$%&*?';
        }

        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }

        $password = str_shuffle($password);
        if (!$add_dashes) {
            return $password;
        }

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public function hook_after_add($id)
    {
        //Your code here
        $request = Request::all();
        $name = Request::input("name");
        $email = Request::input("email");
        $password = Request::input("password");
        $data['name'] = $name;
        $data['email'] = $email;
        $data["password"] = $password;
        CRUDBooster::sendEmail(['to' => $email, 'data' => $data, 'template' => 'user_registered_backend']);
        CRUDBooster::insertLog(trans("New user added: " . $name, ['email' => $email, 'ip' => Request::server('REMOTE_ADDR')]));

    }
}
