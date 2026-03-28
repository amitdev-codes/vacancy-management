<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use App;
use PDF;
use App\ProfileBook;
use App\Utils\admit_card;

class AdmitCardController extends Controller
{
    private $objectList = array();
    private $working_folder = null;
    private $final_html_filepath = "";
    public function Index()
    {
        $data = array("source" => "index");
        return view("admit_card/admit_card", $data);
    }

    public function CreateBook()
    {
        $data = array("source" => "CreateBook");
        $this->working_folder = time();
        $this->generateHtml(1, $this->working_folder);
        if (strlen($this->final_html_filepath) > 0) {
            $data["file_url"] = Storage::url($this->final_html_filepath);
            // Convert into pdf
            $html =  url('/') . Storage::url($this->final_html_filepath);
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadFile($html);
            return $pdf->inline();
        }
        return view("admit_card/admit_card", $data);
    }

    private function generateHtml($client_id, $working_folder)
    {
        $arr = $this->getGeneratorObjects();
        $len = count($arr);
        $working_path = "";
        $storage_path = "";
        if ($len > 0) {
            $arr[0]->working_folder = $working_folder;
            $arr[0]->prepareFolder();
            $storage_path = $arr[0]->storage_path;
            $working_path = $arr[0]->working_path;
            Storage::makeDirectory($working_path);
            $this->final_html_filepath = $working_path . "/" . $client_id . "_AdmitCard_" . $working_folder . ".html";
            $a = View::make("admit_card/admit_card_header");
            Storage::put($this->final_html_filepath, $a);
        }


        //Generate & concatenate the files.
        for ($i = 0; $i < $len; $i++) {
            //generate
            $arr[$i]->PrepareHtml($client_id, $working_folder);
            //concactenate
            $content = Storage::get($arr[$i]->filepath);
            Storage::append($this->final_html_filepath, $content);
        }

        if ($len > 0) {
            //move file
            Storage::move($this->final_html_filepath, $storage_path . "/" . $client_id . "_AdmitCard_" . $working_folder . ".html");
            $this->final_html_filepath = $storage_path . "/" . $client_id . "_AdmitCard_" . $working_folder . ".html";
            //new delete the working directory
            Storage::deleteDirectory($working_path);
            //Storage::deleteDirectory($working_path);
        }
    }

    private function getGeneratorObjects()
    {
        $arr = array();
        array_push($arr, new admit_card());
        $this->objectList = $arr;
        return $arr;
    }
}
