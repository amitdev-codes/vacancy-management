<?php

namespace App\Http\Controllers\Report;

use App\Exports\combined\LokSewaCombinedNewReportExportExcel;
use App\Exports\combined\LokSewaCombinedReportExportExcel;
use App\Exports\combined\LokSewaCombinedLargeSheetReportExportExcel;
use App\Exports\largeSheet\LokSewaNewReportExportExcel;
use App\Exports\LokSewaReportExport;
use App\Exports\LokSewaReportExportExcel;
use App\Exports\LokSewaReportInternalExportExcel;
use App\Exports\openloksewaMultipleSheetexport;
use App\Http\Controllers\Controller;
use App\Models\LoksewaReport;
use App\Models\MstDesignation;
use App\Models\VacancyAd;
use App\Models\VacancyPost;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use ZipArchive;


class LoksewaReportController extends Controller
{
    public function getCandidates(){
        $data = [];
        $data['page_title'] = 'Lok Sewa Report';
        $data['adno_data'] =VacancyAd::query()->Search()->leftjoin('mst_job_opening_type','vacancy_ad.opening_type_id','mst_job_opening_type.id')->select('vacancy_ad.id','ad_title_en','mst_job_opening_type.name_np as opening_type')->get();
        $data['md_id']=null;
        $data['designation_data']=null;
        $candidate_data=LoksewaReport::query();
        if(!empty(Request::all())){
           $ad_id=Request::input('id');
           if(!empty($ad_id)) {
               $data['id'] = $ad_id;
               $data['ad_id'] = $ad_id;
               $data['md_id'] = $ad_id;
               $candidate_data->filter($ad_id);
               $data['vacancy_ad_id'] = $ad_id;
               $data['designation_data'] = VacancyPost::query()->filter($ad_id)->with('designation:id,name_en,name_np')->select('vacancy_post.designation_id', 'vacancy_post.id')->get();
               $designation=Request::input('designation_id');
               if(!empty($designation)){
                   $data['designation_id'] = $designation;
                   $candidate_data->designation($designation);
               }
           }
        }
        $limit=Request::input('limit');
        if(empty($limit)){
            $limit=10;
        }

        $data['candidate_data']= $candidate_data->orderBy('full_name','asc')->paginate($limit);

      return view('loksewa.index',$data);
    }
    public function exportPDF(){
        $ad_id=Request::input('id');
        $designation=Request::input('designation_id');

        $data['candidate_data'] = LoksewaReport::query()->filter($ad_id)->designation($designation)->get();
        $pdf = PDF::loadView('loksewa.pdf',$data);
        return $pdf->download('invoice.pdf');
    }
    public function exportExcel(){
        $ad_id=Request::input('id');
        $designation=Request::input('designation_id');
        $designation_name=MstDesignation::query()->filter()->whereId($designation)->pluck('name_en');
        $filename=$designation_name[0].'.xlsx';
        $filename = str_replace('/', '_', $filename);
        
        return Excel::download(new loksewaReportExport($ad_id,$designation),$filename);

        // return Excel::download(new openloksewaMultipleSheetexport($ad_id,$designation),$filename);
    }
    public function exportToLoksewa(){
        $ad_id=Request::input('id');
        $designation=Request::input('designation_id');
        $designation_name=MstDesignation::query()->filter()->whereId($designation)->pluck('name_en');
        $filename=$designation_name[0].'.xlsx';
        $filename = str_replace('/', '_', $filename);

        $opening_type=VacancyAd::where('id',$ad_id)->where('fiscal_year_id',Session::get('fiscal_year_id'))->value('opening_type_id');
        //  return Excel::download(new loksewaNewReportExportExcel($ad_id,$designation),$filename);

        // dd($designation,$ad_id);
      $count= VacancyPost::where('designation_id',$designation)->where('fiscal_year_id',Session::get('fiscal_year_id'))->count();
    //   dd($count);
       if($count >1){
        // return Excel::download(new lokSewaCombinedReportExportExcel($ad_id,$designation),$filename);

        return Excel::download(new lokSewaCombinedLargeSheetReportExportExcel($ad_id,$designation),$filename);
       }
       return Excel::download(new loksewaNewReportExportExcel($ad_id,$designation),$filename);
    //    $export = new LokSewaNewReportExportExcel($ad_id, $designation);
    //    $sheets = $export->sheets();
    //    foreach ($sheets as $index => $sheet) {
    //     // Generate a filename for each sheet
    //     $filename = "export_part_{$index}.xlsx";
        
    //     // Store the sheet temporarily
    //     $path = storage_path("app/public/{$filename}");
    //     Excel::store($sheet, "public/{$filename}");

    //     // Stream the file to the user
    //     return response()->download($path, $filename)->deleteFileAfterSend(true);
    // }



    //    $filePaths = [];
    //    foreach ($sheets as $index => $sheet) {
    //        $filename = "export_part_{$index}.xlsx";
    //        $path = storage_path("app/public/{$filename}");
    //        \Maatwebsite\Excel\Facades\Excel::store($sheet, "public/{$filename}");
    //        $filePaths[] = $path;
    //    }

    //    $zipFileName = $designation_name.'.zip';
    //     $zipFilePath = storage_path("app/public/{$zipFileName}");
    //     $zip = new ZipArchive;
    //     if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
    //         foreach ($filePaths as $file) {
    //             $zip->addFile($file, basename($file));
    //         }
    //         $zip->close();
    //     }
    //     return response()->download($zipFilePath)->deleteFileAfterSend(true);



        
       
        // if($opening_type==1){
        //     //khulla
        //     return Excel::download(new loksewaReportExportExcel($ad_id,$designation),$filename);
        // }else{
        //     //antarik
        //     return Excel::download(new loksewaReportInternalExportExcel($ad_id,$designation),$filename);
        // }
        
    
    }

}
