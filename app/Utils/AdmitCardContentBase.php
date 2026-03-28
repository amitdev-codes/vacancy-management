<?php

namespace App\Utils;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\View;

class AdmitCardContentBase
{

    public $storage_path = "";

    public $working_folder = "";

    public $working_path = "";

    public $filepath = "";

    public $filename = "";

    public $client_id = 0;

    public $template_name ="";

    function __construct()
    {

        //$this->filename = "data_004_tourist_sites.html";
    }

    public function prepareFolder()
    {

        //Storage

        //$this->storage_path = storage_path().'/profile_book';

        $this->storage_path = 'public/admit_card';

        //File::isDirectory($this->storage_path) or File::makeDirectory($this->storage_path, 0777, true, true);

        $this->working_path = $this->storage_path."/".$this->working_folder;

        Storage::makeDirectory($this->working_path);

        //File::isDirectory($this->working_path) or File::makeDirectory($this->working_path, 0777, true, true);

        //$this->filename = "data_004_tourist_sites.html";

        $this->filepath = $this->working_path."/".$this->filename;
    }



    private function saveInFile($html)
    {

        if (Storage::exists($this->filepath)) {
            Storage::delete($this->filepath);
        }



        Storage::put($this->filepath, $html);

        return true;
    }



    public function LoadData($params)
    {

        return array();
    }


    public function PrepareHtml($client_id, $working_folder)
    {

        $this->client_id = $client_id;

        $this->working_folder = $working_folder;

        $this->prepareFolder();

        $data = $this->LoadData(array());



        $this->saveInFile(View::make($this->template_name, $data));
    }
}
