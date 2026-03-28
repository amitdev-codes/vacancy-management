<?php
namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use App;
use PDF;

 use App\Utils\VaarsReport\applicant_count;
// use App\Utils\VaarsReport\soc_child_friendly_edu;
// use App\Utils\VaarsReport\soc_college_students;

class VaarsReportController extends Controller
{
    private $objectList = array();
    private $working_folder = null;
    private $final_html_filepath = "";

    public function Index()
    {
        $data = array("source" => "index");
        return view("Report/VaarsReport",
        $data);
    }

    public function CreateBook()
    {
        $data = array("source" => "CreateBook");
        $this->working_folder = time();
        $this->generateHtml(1, $this->working_folder);
        if (strlen($this->final_html_filepath) > 0) {
            $data["file_url"] = Storage::url($this->final_html_filepath);

            // Save into database
                    // $profileBook = new ProfileBook;
                    // $profileBook->local_level_id = 1;
                    // $profileBook->fiscal_year_id = 1;
                    // $profileBook->path = $data["file_url"];
                    // $profileBook->save();

            // Convert into pdf
            $html =  url('/').Storage::url($this->final_html_filepath);
            $pdf = App::make('snappy.pdf.wrapper');
            // $pdf->setOption('header-html', 'http://www.../testerpdf.html');
            // $pdf->setOption('footer-html', 'http://www.../testerpdf.html');
            $pdf->loadFile($html);
            return $pdf->inline();
        }
        return view("Report/VaarsReport", $data);
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
            $this->final_html_filepath = $working_path."/".$client_id."_VaarsReport_".$working_folder.".html";
            $a = View::make("report/VaarsReportContent/VaarsReportPdfHeader");
            Storage::put($this->final_html_filepath, $a);
        }
        
        //Generate & concatenate the files.
        for ($i =0; $i < $len; $i++) {
            //generate
            $arr[$i]->PrepareHtml($client_id, $working_folder);
            //concactenate
            $content = Storage::get($arr[$i]->filepath);
            Storage::append( $this->final_html_filepath, $content);
        }
        if ($len > 0) {
            //move file
            Storage::move($this->final_html_filepath, $storage_path."/".$client_id."_VaarsReport_".$working_folder.".html");
            $this->final_html_filepath = $storage_path."/".$client_id."_VaarsReport_".$working_folder.".html";
            //new delete the working directory
            Storage::deleteDirectory($working_path);
            //Storage::deleteDirectory($working_path);
        }
    }
    private function getGeneratorObjects()
    {
        $arr = array();
        array_push($arr, new applicant_count());
        // array_push($arr, new pop_personal_events());
        // array_push($arr, new pop_social_security_program());
          
       
        $this->objectList = $arr;
        return $arr;
    }
}
