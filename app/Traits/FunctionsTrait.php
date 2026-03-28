<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
trait FunctionsTrait{

    static function get_trainings($fiscal_year_id=null,$vacancy_id=null,$vacancy_post_id=null,$vacancy_apply_id=null,
    $applicant_id=null,$from=0,$to=30){
        try {
            
            $fiscal_year_query=DB::table('mst_fiscal_year')->where('id_deleted',false);
            if($fiscal_year_id!=null){
             
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    static function get_advertisement(){
        try {
            $fiscal_year=DB::table('mst_fiscal_year')->orderby('id','desc')->first();
            $ads=DB::table('vacancy_ad')->where('is_deleted',false)
            ->where('fiscal_year_id',$fiscal_year->id)->get();
            $posts=DB::table('vacancy_post')
            ->leftjoin('mst_designation','vacancy_post.designation_id','mst_designation.id')
            ->select('vacancy_post.id','vacancy_post.ad_no','mst_designation.name_en','mst_designation.name_np')
            // ->join('vacancy_ad','vacancy_post.vacancy_ad_id','vacancy_ad.id')
            ->where('vacancy_post.is_deleted',false)
            ->where('vacancy_post.fiscal_year_id',$fiscal_year->id)->get();
            return ['success'=>true,'ads'=>$ads,'posts'=>$posts];
        } catch (\Throwable $th) {
            return ['success'=>false,'message'=>$th->getMessage()];
        }
    }

    static function get_opening_post_type(){
        try {
            $type=DB::table('mst_job_opening_type')->orderby('id','desc')->where('is_deleted',false)->get();
           
            return ['success'=>true,'types'=>$type];
        } catch (\Throwable $th) {
            return ['success'=>false,'message'=>$th->getMessage()];
        }
    }



    static function get_data_count($fiscal_year){
        try {
           
            $ads=DB::table('vacancy_ad')->where('is_deleted',false)
            ->where('fiscal_year_id',$fiscal_year->id)->whereIn('opening_type_id',[1,2])->get();

            $ad_ids=collect($ads)->pluck('id');

            $vac_post=collect(DB::table('vacancy_post')
            ->where('fiscal_year_id',$fiscal_year->id)
            ->whereIn('vacancy_ad_id',$ad_ids)->get())->pluck('id');

            
            $total_count = DB::table('vacancy_apply')
            ->join('applied_applicant_profile', 'vacancy_apply.id', '=',
             'applied_applicant_profile.vacancy_apply_id')
            ->select('vacancy_apply.applicant_id')
            ->where('vacancy_apply.fiscal_year_id', $fiscal_year->id)
            ->where('vacancy_apply.is_deleted', false)
            ->where('vacancy_apply.is_cancelled', false)
            ->where('vacancy_apply.is_rejected', false)
            ->where('vacancy_apply.is_paid', true)
            ->whereIn('vacancy_apply.vacancy_post_id',$vac_post)
            ->count('applicant_id');
            
            $inter_exter = DB::table('vacancy_apply')
            ->join('applied_applicant_profile', 'vacancy_apply.id', '=',
             'applied_applicant_profile.vacancy_apply_id')
            ->select('vacancy_apply.applicant_id')
            ->where('vacancy_apply.fiscal_year_id', $fiscal_year->id)
            ->where('vacancy_apply.is_deleted', false)
            ->where('vacancy_apply.is_cancelled', false)
            ->where('vacancy_apply.is_rejected', false)
            ->where('vacancy_apply.is_paid', true)
            ->whereIn('vacancy_apply.vacancy_post_id',$vac_post)
            ->groupBy('vacancy_apply.applicant_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();
            // dd($fiscal_year,$ads,$ad_ids,$vac_post,$total_count,$inter_exter);
            
            $total_rolls = DB::table('tbl_generated_roll_numbers')
            ->select('applicant_id')
            ->where('fiscal_year_id', $fiscal_year->id)
            ->whereIn('post_id', $vac_post)
            ->whereIn('ad_id', $ad_ids)
            ->count('applicant_id');
          
            $inter_exter_rolls = DB::table('tbl_generated_roll_numbers')
            ->select('applicant_id')
            ->where('fiscal_year_id', $fiscal_year->id)
            ->whereIn('post_id', $vac_post)
            ->whereIn('ad_id', $ad_ids)
            ->groupBy('applicant_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();

            $sent_mails = DB::table('tbl_generated_roll_numbers')
            ->select('mail_sent_status')
            ->where('fiscal_year_id', $fiscal_year->id)
            ->where('mail_sent_status', true)
            ->whereIn('post_id', $vac_post)
            ->whereIn('ad_id', $ad_ids)
            ->count('mail_sent_status');

            $unsent_mails = DB::table('tbl_generated_roll_numbers')
            ->select('mail_sent_status')
            ->where('fiscal_year_id', $fiscal_year->id)
            ->where('mail_sent_status', false)
            ->whereIn('post_id', $vac_post)
            ->whereIn('ad_id', $ad_ids)
            ->count('mail_sent_status');

     $unmatched = DB::table('vacancy_apply')
    ->select('applicant_id')
    ->where('fiscal_year_id', $fiscal_year->id)
    ->where('is_deleted', false)
    ->where('is_cancelled', false)
    ->where('is_rejected', false)
    ->where('is_paid', true)
    ->whereIn('vacancy_post_id', $vac_post)
    ->whereNotIn('applicant_id', function($query) {
        $query->select('applicant_id')
              ->from('tbl_generated_roll_numbers');
    })
    // ->distinct() // Ensure unique applicant_id
    ->get();

           

             
            $data=[
                'total_applicants'=>$total_count,
                'inter_exter'=>$inter_exter,
                'total_rolls'=>$total_rolls,
                'inter_exter_rolls'=>$inter_exter_rolls,
                'sent_mails'=>$sent_mails,
                'unsent_mails'=>$unsent_mails,
                'unmatched'=>$unmatched
            ];
            
           
            return ['success'=>true,'data'=>$data];
        } catch (\Throwable $th) {
            return ['success'=>false,'message'=>$th->getMessage()];
        }
    }

    
    static function get_latest_fiscal_year(){
       return DB::table('mst_fiscal_year')->orderby('id','desc')->first(); 
       
    }
   


static function get_images($path) {
    try {
        // Ensure the provided path is within the public directory
        $directoryPath = public_path($path);

        // Check if the directory exists
        if (!File::exists($directoryPath)) {
            throw new Exception('Directory does not exist');
        }

        // Get all files from the directory
        $files = File::allFiles($directoryPath);

        // Filter and list image files
        $imageFiles = array_filter($files, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file->getFilename());
        });

        // Start HTML output
        $html = '<ul>';

        foreach ($imageFiles as $file) {
            // Get the relative path for the image file
            $relativePath = str_replace(public_path(), '', $file->getPathname());
            // Generate HTML link
            $html .= '<li><a href="' .$relativePath . '" target="_blank">Click Me - ' . htmlspecialchars($file->getFilename()) . '</a></li>';
        }

        $html .= '</ul>';

        return $html;
    } catch (\Throwable $th) {
        return 'Error: ' . $th->getMessage();
    }
    
}




static function get_district_by_id($id){
    try {
        return DB::table('mst_district')->where('id',$id)->orWhere('code',$id)->first();
    } catch (\Throwable $th) {
       return $th->getMessage();
    }
}

static function ad_post_by_id($id){
    try {
        return DB::table('vacancy_post')->where('id',$id)->first();
    } catch (\Throwable $th) {
       return $th->getMessage();
    }
}

static function designation_by_id($id){
    try {
       

            return DB::table('mst_designation')
             ->join('mst_work_service','mst_work_service.id','mst_designation.work_service_id')
            ->join('mst_work_service_group','mst_work_service_group.id','mst_designation.service_group_id')
            ->join('mst_work_level','mst_work_level.id','mst_designation.work_level_id')
            ->select('mst_designation.name_np'
            ,'mst_work_service.name_np as service'
            ,'mst_work_service_group.name_np as group'
            ,'mst_work_level.name_np as level'
            )
            ->where('mst_designation.id',$id)->first();
        
    } catch (\Throwable $th) {
       return $th->getMessage();
    }
}



static function exam_details_by_ids($ad_id,$post_id,$fy_id){
    try {
        

        return DB::table('vacancy_post_exam')
            ->join('vacancy_post_paper', 'vacancy_post_paper.id', '=', 'vacancy_post_exam.paper_id')
            ->where('vacancy_post_exam.vacancy_ad_id', $ad_id)
            ->where('vacancy_post_exam.vacancy_post_id', $post_id)
            ->where('vacancy_post_paper.vacancy_post_id', $post_id)
            ->where('vacancy_post_paper.fiscal_year_id', $fy_id)
            ->where('vacancy_post_exam.fiscal_year_id', $fy_id)
            ->where('vacancy_post_exam.is_deleted',false)
            ->select('vacancy_post_paper.*',
                   'vacancy_post_exam.time_from',
                   'vacancy_post_exam.date_bs',
                   'vacancy_post_exam.paper_id',
             DB::raw('COUNT(vacancy_post_exam.id) as exam_count'))
            ->groupBy('vacancy_post_paper.id', 'vacancy_post_paper.paper_name_np')
            ->get();
        
        
    } catch (\Throwable $th) {
       return $th->getMessage();
    }
}

static function opening_type_by_ad_id($ad_id){
    try {
        

        return DB::table('vacancy_ad')
            ->join('mst_job_opening_type', 'vacancy_ad.opening_type_id', '=', 'mst_job_opening_type.id')
            ->select('mst_job_opening_type.name_np')
            ->where('vacancy_ad.id', $ad_id)
            ->first();
        
        
    } catch (\Throwable $th) {
       return $th->getMessage();
    }
}


static function get_exam_center($ad_id,$post_id,$fiscal_year_id,$paper_id,$roll_num){

     try {
        return DB::table('exam_center_setting')
    ->join('paper_exam_centers', 'exam_center_setting.id', '=', 'paper_exam_centers.center_id')
    ->where('paper_exam_centers.vacancy_ad_id', $ad_id)
    ->where('paper_exam_centers.vacancy_post_id', $post_id)
    ->where('paper_exam_centers.fiscal_year_id', $fiscal_year_id)
    ->where('paper_exam_centers.paper_id', $paper_id)
    ->whereRaw(' ? BETWEEN paper_exam_centers.roll_from AND paper_exam_centers.roll_to', [$roll_number])
    ->select('exam_center_setting.remarks')
    ->first();
    
     } catch (\Throwable $th) {
        //throw $th;
     }
}

static function applicant_name_by_applicant_id($applicant_id){
    try {
        
        return DB::table('applied_applicant_profile')           
            ->where('user_id', $applicant_id)
            ->first();        
        
    } catch (\Throwable $th) {
       return $th->getMessage();
    }
}

    

}


