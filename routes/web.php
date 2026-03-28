<?php
use App\Http\Controllers\Admin\BulkAppliedVacancyReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsrController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExamRollController;
use App\Http\Controllers\AdmitCardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\ApplicantCBController;
use App\Http\Controllers\Auth\CBAdminController;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\AdminCmsUsersController;
use App\Http\Controllers\AdminMergedDataController;
use App\Http\Controllers\AdminVacancyApplyController;
use App\Http\Controllers\ApplicationReportController;
use App\Http\Controllers\AdminReportLokSewaController;
use App\Http\Controllers\AdminVacancyPost60Controller;
use App\Http\Controllers\AdminWebPaymentLogController;
use App\Http\Controllers\AdminAdmitCardStatusController;
use App\Http\Controllers\AdminCsvPaymentFilesController;
use App\Http\Controllers\Report\FilePromotionController;
use App\Http\Controllers\AdminApplicantProfileController;
use App\Http\Controllers\Evaluation\EvaluationController;
use App\Http\Controllers\AdminCsvFilesUploadingController;
use App\Http\Controllers\AdminExamCenterSettingController;
use App\Http\Controllers\AdminVacancyApplicantsController;
use App\Http\Controllers\AdminMergedEducationDataController;
use App\Http\Controllers\AdminMergedApplicantLeaveController;
use App\Http\Controllers\InternalAppraisalRejectedController;
use App\Http\Controllers\Report\AppliedCountReportController;
use App\Http\Controllers\Report\SelectedCandidatesController;
use App\Http\Controllers\AdminApplicantServiceHistoryController;
use App\Http\Controllers\AdminTokenPaymentCredentialsController;
use App\Http\Controllers\Report\EvaluationSummaryListController;
use App\Http\Controllers\Payment\OnlinePayment\Ips\IpsController;
use App\Http\Controllers\Report\AppliedGroupWiseReportController;
use App\Http\Controllers\AdminInternalRejectedCandidatesController;
use App\Http\Controllers\Report\ApplicantRatioWiseReportController;
use App\Http\Controllers\Report\FilePromotionNotAcceptedController;
use App\Http\Controllers\Payment\OnlinePayment\WebPaymentController;
use App\Http\Controllers\AdminInsertAppliedApplicantDetailController;
use App\Http\Controllers\Payment\OnlinePayment\Esewa\EsewaController;
use App\Http\Controllers\Report\AppliedCountDateWiseReportController;
use App\Http\Controllers\Report\CandidateApplicationDetailsController;
use App\Http\Controllers\Payment\OnlinePayment\Khalti\KhaltiController;
use App\Http\Controllers\Report\ApplicantEligibleCountReportController;
use App\Http\Controllers\Report\EvaluationIndividualEmployeeController;
use App\Http\Controllers\Report\RegisteredAppliedUsersReportController;
use App\Http\Controllers\Payment\OnlinePayment\PaymentVerificationController;
use App\Http\Controllers\AdminPspTokenPaymentLogsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

#welcome blade
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/howto', [HomeController::class, 'howto'])->name('howto');
Route::get('/relatedstaffs', [HomeController::class, 'relatedstaff'])->name('relatedstaffs');
#testmail
Route::get('/testmail', [HomeController::class, 'testmail']);
#check validations
Route::get('/user/checkmobile', [HomeController::class, 'checkmobile'])->name('checkmobile');
Route::get('/user/checkemail', [HomeController::class, 'checkemail'])->name('checkemail');
//Route for notice
Route::get('/notice_detail/{id}', [HomeController::class, 'getNotice'])->name('notice');
Route::get('/otp', [HomeController::class, 'otp'])->name('otp');
Route::get('/validateOtp', [HomeController::class, 'validateOtp'])->name('validateOtp');
Route::get('/sendsms', [HomeController::class, 'sendsms'])->name('sms');
Route::get('/resendOtp/{id}', [OtpController::class, 'resendOtp'])->name('resendOtp');
Route::get('/getOtp/{id}', [OtpController::class, 'verify_otp'])->name('getOtp');
// Route::view('/getOtp', 'verify_otp')->name('getOtp');
Route::post('/verifyotp', [OtpController::class, 'verifyotp'])->name('verifyotp');
Route::view('/forgot', 'cbauth.forgot')->name('getForgot');
Route::post('forgot', [CBAdminController::class, 'postForgot'])->name('postForgot');
Auth::routes();
Route::post('/register_success', [CBAdminController::class, 'getRegisterSuccess'])->name('getRegisterSuccess');
// User activation
Route::post('/user/activation/{token}', [CBAdminController::class, 'userActivation']);
Route::get('/app/applicant_profile/openedit', function () {
    $user = CRUDBooster::first("cms_users", Session::get("admin_id"));
    //
    $encoded_id = Session::get("applicant_id");
    if (isset($user)) {
        if ($user->id_cms_privileges == 4) {
            return redirect()->route('applicant_profile_edit', ['id' => $encoded_id]);
        }
    }
});
    Route::get('login',function(){
        return view('cbauth.login');
      });
#authentication
#1.user authentication
Route::prefix('app')->group(function () {
    Route::view('/', 'cbauth.login')->name('applicantLogin');
    Route::get('login',function(){
        return view('cbauth.login');
      });
    Route::post('/login', [CBAdminController::class, 'postLogin'])->name('applicantPostLogin');
    #register
    Route::view('/register', 'cbauth.register')->name('applicantRegister');
    Route::post('/register', [CBAdminController::class, 'postRegister'])->name('applicantPostRegister');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('userDashboardController');

    #customemail
    Route::get('/viewEmail',[\App\Http\Controllers\ApplicationSettings\SendEmailController::class,'viewEmail'])->name('viewEmail');
    Route::get('/sendEmail',[\App\Http\Controllers\ApplicationSettings\SendEmailController::class,'SendEmail'])->name('sendEmail');

    #loksewa report
    Route::get('loksewaReport',[\App\Http\Controllers\Report\LoksewaReportController::class,'getCandidates'])->name('loksewaexport');
    Route::get('/loksewaReport/export-pdf', [\App\Http\Controllers\Report\LoksewaReportController::class, 'exportPDF'])->name('loksewaExportpdf');
    Route::get('/loksewaReport/export-excel', [\App\Http\Controllers\Report\LoksewaReportController::class, 'exportExcel'])->name('loksewaExportExcel');
    Route::get('/loksewaReport/export-loksewaReport', [\App\Http\Controllers\Report\LoksewaReportController::class, 'exportToLoksewa'])->name('loksewaExportReport');

});
#2.admin authentication
Route::prefix('admin')->group(function () {
    Route::get('/', [CBAdminController::class, 'adminLogin'])->name('adminLogin');
    Route::post('/login', [CBAdminController::class, 'adminPostLogin'])->name('adminPostLogin');
    Route::view('/register', 'cbauth.register')->name('adminRegister');
    Route::post('/register', [CBAdminController::class, 'postRegister'])->name('adminPostRegister');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('userDashboardController');
});

#old routes
// Middleware to check if login or not , if not redirect to login page
Route::group(['middleware' => ['checkauth']], function () {
    Route::get('/logout', [CBAdminController::class, 'getLogout'])->name('getLogout');
    Route::get('/totalapplicant', [AdminExamCenterSettingController::class, 'getTotalApplicant']);
    Route::get('/getcentercapacity', [AdminExamCenterSettingController::class, 'getCenterCapacity']);
    Route::get('/getopeningtype', [AdminVacancyPost60Controller::class, 'GetOpeningType']);
    Route::get('/app/users/profile', [AdminCmsUsersController::class, 'getProfile'])->name('getEditProfile');
    Route::post('/app/editProfile', [AdminCmsUsersController::class, 'editProfile'])->name('editProfile');
    //amit changes
    // Route::get('/loksewasearch', [AdminReportLokSewaController::class, 'getIndex'])->name('AdminReportLokSewaControllerGetIndex');
//    Route::get('/vacancy_applicants_search', [AdminVacancyApplicantsController::class, 'getsearch']);
//    Route::get('/Applicant_profile_search', [AdminApplicantProfileController::class, 'getsearch']);
    // end of amit changes
    #validation rules
    Route::get('/check_validage', [ValidationController::class, 'checkvalidage']);
    Route::get('/internal', [InternalAppraisalRejectedController::class, 'internal']);
    //REPORT related routes
    Route::prefix('admin/report')->group(function () {
        Route::get('/applied_count', [AppliedCountReportController::class, 'getIndex'])->name('Report\AppliedCountReportControllerGetIndex');
        Route::post('/applied_count/export-data', [AppliedCountReportController::class, 'postExportData'])->name('Report\AppliedCountReportControllerPostExportData');
        Route::get('/applied_groupwise', [AppliedGroupWiseReportController::class, 'getIndex'])->name('Report\AppliedGroupWiseReportControllerGetIndex');
        Route::post('/applied_groupwise/export-data', [AppliedGroupWiseReportController::class, 'postExportData'])->name('Report\AppliedGroupWiseReportControllerPostExportData');
        Route::get('/appliedcount_datewise', [AppliedCountDateWiseReportController::class, 'getIndex'])->name('Report\AppliedCountDateWiseReportControllerGetIndex');
        Route::post('/appliedcount_datewise/export-data', [AppliedCountDateWiseReportController::class, 'postExportData'])->name('Report\AppliedCountDateWiseReportControllerPostExportData');
        Route::get('/registeredvs_applied', [RegisteredAppliedUsersReportController::class, 'getIndex'])->name('Report\RegisteredAppliedUsersReportControllerGetIndex');
        Route::post('/registeredvs_applied/export-data', [RegisteredAppliedUsersReportController::class, 'postExportData'])->name('Report\RegisteredAppliedUsersReportControllerPostExportData');
        Route::get('/applicant_ratio', [ApplicantRatioWiseReportController::class, 'getIndex'])->name('Report\ApplicantRatioWiseReportControllerGetIndex');
        Route::post('/applicant_ratio/export-data', [ApplicantRatioWiseReportController::class, 'postExportData'])->name('Report\ApplicantRatioWiseReportControllerPostExportData');
        Route::get('/eligible_applicant', [ApplicantEligibleCountReportController::class, 'getIndex'])->name('Report\ApplicantEligibleCountReportControllerGetIndex');
        Route::post('/eligible_applicant/export-data', [ApplicantEligibleCountReportController::class, 'postExportData'])->name('Report\ApplicantEligibleCountReportControllerPostExportData');
        //new route added end
        // Route::get('/filepormotion', [FilePormotionReportController::class, 'getIndex'])->name('Report\FilePromotionControllerGetIndex');

        Route::get('/file_promotion', [FilePromotionController::class, 'getIndex'])->name('Report\FilePromotionControllerGetIndex');
        Route::get('/file_promotion/{id}', [FilePromotionController::class, 'getDesignationView'])->name('filepromotion_designation_view');
        Route::get('/file_promotion_designation/{id}', [FilePromotionController::class, 'getCandidates'])->name('filepromotion_getCandidates');
        Route::get('/file_promotion/export/{id}', [FilePromotionController::class, 'generateExcel']);

        Route::get('/file_promotion_not_accepted', [FilePromotionNotAcceptedController::class, 'getIndex'])->name('Report\FilePromotionNotAcceptedControllerGetIndex');
        Route::get('/file_promotion_not_accepted/{id}', [FilePromotionNotAcceptedController::class, 'getDesignationView'])->name('file_promotion_not_accepted_designation_view');
        Route::get('/file_promotion_not_accepted_designation/{id}', [FilePromotionNotAcceptedController::class, 'getCandidates'])->name('file_promotion_not_accepted_getcandidates');
        Route::get('/file_promotion_not_accepted/export/{id}', [FilePromotionNotAcceptedController::class, 'generateExcel']);

        Route::get('/evaluation_summary_list', [EvaluationSummaryListController::class, 'getIndex'])->name('Report\EvaluationSummaryListControllerGetIndex');
        Route::get('/evaluation_summary_list/{id}', [EvaluationSummaryListController::class, 'getDesignationView'])->name('GetDesignation');
        Route::get('/evaluation_summary_list/export/{id}', [EvaluationSummaryListController::class, 'generateExcel']);
        Route::get('/evaluation_summary_list/export/{id}', [EvaluationSummaryListController::class, 'generateExcel'])->name('exportcandidate');

        Route::get('/evaluation_summary_list_designation/{ad_id}/{id}', [EvaluationSummaryListController::class, 'getCandidates'])->name('getcandidates');
        Route::get('/evaluation_summary_list_designation/export/{ad}/{design}', [EvaluationSummaryListController::class, 'generateExcel'])->name('exportexcelcandidates');
        Route::get('/evaluation_summary_list_designation/exportpdf/{ad}/{design}', [EvaluationSummaryListController::class, 'generatepdf'])->name('exportpdfcandidates');

        // Route::get('/Internalpormotion', [FilePormotionReportController::class, 'getIndex']);
        //End Report Routes
    });
    #applicant related routes and menu
    Route::prefix('app')->group(function () {
        Route::get('/loksewasearch', [AdminReportLokSewaController::class, 'getIndex'])->name('AdminReportLokSewaControllerGetIndex');
        Route::get('/applicant_profile/edit/{id}', [AdminApplicantProfileController::class, 'getEdit'])->name('applicant_profile_edit');
        Route::get('/applicant_profile/edit-save/{id}', [AdminApplicantProfileController::class, 'postEditSave']);
        Route::get('/applicant_profile/delete-image', [AdminApplicantProfileController::class, 'getDeleteImage']);
        Route::get('/applicant_profile/data-table', [AdminApplicantProfileController::class, 'getDataTable']);

        Route::post('/post_expired', [DashboardController::class, 'getpassword'])->name('password.post_expired');

        // Route::get("merged_leave", [AdminApplicantLeaveDetailsController::class, 'merge_applicant_leave_details']);
        
        Route::get('/vacancy_applicants/applicant_profile/archive/{id}', [ApplicantCBController::class, 'getArchive'])->name('archive_applicant');
        Route::post('/vacancy_applicants/applicant_profile/archive', [ApplicantCBController::class, 'getIndex'])->name('ApplicantCBControllerGetIndex');
        // Route::get('/vacancy_applicants/applicant_profile/archive/{id}',function(){
        //     dd('devs');
        // });

      #applied applicants tabs

    //    Route::get('/applied_applicant_profile/archive/{id}', [AdminApplicantProfileController::class, 'getEdit'])->name('applied_applicantProfile');


      #insertdata
      Route::get('vacancy_applicants/insert/{va_id}/{applicant_id}', [AdminInsertAppliedApplicantDetailController::class, 'insertdata']);


        #webpayment
        Route::get('/paymentdata/view', [WebPaymentController::class, 'paymentparameters']);
        Route::get('/verifyTaxStatus', [WebPaymentController::class, 'verifytaxstatus'])->name('verifyTaxStatus');

        #esewa
        Route::get('/esewa/success', [EsewaController::class, 'paymentSuccess'])->name('esewaSuccess');
        Route::get('/esewa/failure', [EsewaController::class, 'paymentFailure'])->name('esewaFail');
        #esewa verify
        Route::get('verify_esewa',[PaymentVerificationController::class, 'getesewa'])->name('verify_payment_esewa');
        Route::get('verify_sajilopay',[PaymentVerificationController::class, 'getSajiloPay'])->name('verify_payment_sajilopay');
        #start of IPS connect
        Route::get('/connect-ips/view', [IpsController::class, 'view'])->name('ipsconnect_view');
        Route::get('/connect-ips/success', [IpsController::class, 'paymentvalidation'])->name('ipsConnectSuccess');
        Route::get('/connect-ips/failure', [IpsController::class, 'paymentFailure'])->name('ipsConnectFailure');
        #ips verify
        Route::get('verify_ips',[PaymentVerificationController::class, 'getips'])->name('verify_payment_ips');

        #start of khalti payment method

        Route::post('loadKhalti', [KhaltiController::class, 'loadKhaltiwallet'])->name('loadKhalti');
        Route::get('khalti/verify', [KhaltiController::class, 'verification'])->name('khalti_verification');
        Route::get('paymentstatus/reportsuccess', [WebPaymentController::class, 'paymentSuccess'])->name('paymentsuccess');
        #khalti verify
        Route::get('verify_khalti',[PaymentVerificationController::class, 'getkhalti'])->name('verify_payment_khalti');

        Route::get('Token_verify_khalti', [PaymentVerificationController::class, 'tokenVerifyKhalti'])->name('khalti_token_verification');
        Route::post('Token_verify_khalti', [PaymentVerificationController::class, 'tokenVerifyKhalti'])->name('khalti_token_verification');

        #payment reprocess
        Route::get('web_payment_log/Reprocess/{id}', [AdminWebPaymentLogController::class, 'getReprocess'])->name('reprocess');
        Route::get('psp_token_payment_logs/Reprocess/{id}', [AdminPspTokenPaymentLogsController::class, 'getReprocess']);
        Route::get('token_payment_credentials/pward/key', [AdminTokenPaymentCredentialsController::class, 'getclientdetail']);
        #pdf
        Route::get('/paymentreceipt/{id}', [WebPaymentController::class, 'generatePdf'])->name('receipt');

        // Vacancy Reject
        Route::get('/vacancy_apply/Cancel/{id}', [AdminVacancyApplyController::class, 'getCancel']);
        Route::get('/vacancy_apply/Reject/{id}', [AdminVacancyApplyController::class, 'getReject']);

        // Begin Vacancy Re-Apply
        Route::get('/vacancy_apply/reapply/{id}', [AdminVacancyApplyController::class, 'getReapply']);
        Route::post('/vacancy_apply/reapply-save', [AdminVacancyApplyController::class, 'postReapplySave']);
        // End Vacancy Re-Apply


        Route::get('/exam/schedule/{id}', [ExamScheduleController::class, 'getEdit']);
        Route::get('/exam/schedulegroupwise/{id}', [ExamScheduleController::class, 'getSchedule']);
        Route::get('/exam/updatecenter/{id}', [ExamScheduleController::class, 'updateCenter']);
        Route::get('/exam/schedule/generateRollNo/{id}', [ExamScheduleController::class, 'generateRollNo']);

        Route::post('/update_exam', [ExamScheduleController::class, 'postExamDetail'])->name('roll.new');
        // Route::get('/exam/admitcard/{id}', [ExamScheduleController::class, 'generateAdmitCardForUser'])->name('admitcard.generate');

        Route::get('/exam/admitcard/{id}/{exam_group_id}', [ExamScheduleController::class, 'generateAdmitCardForUser'])->name('admitcard.generate');

        Route::get('/exam/resendmail/{id}', [AdminAdmitCardStatusController::class, 'resendMail']);
        Route::get('/exam/pdfregenerate/{id}', [AdminAdmitCardStatusController::class, 'pdfRegenerate']);
        Route::get('/admit_card', [AdmitCardController::class, 'Index']);

        Route::get('/csv_payment_files/import/{id}', [AdminCsvPaymentFilesController::class, 'import']);
        Route::get('/csv_payment_files/relink/{id}', [AdminCsvPaymentFilesController::class, 'relink']);

        Route::get('/csv_files_uploading/import/{id}', [AdminCsvFilesUploadingController::class, 'importData'])->name('AdminCsvFilesUploadingControllerGetImport');

        Route::get('/merged_data_education/edit/{id}', [AdminMergedEducationDataController::class, 'getEdit'])->name('AdminMergedEducationDataControllerGetEdit');
        Route::get('/merged_data_education/delete/{id}', [AdminMergedEducationDataController::class, 'getDelete'])->name('AdminMergedEducationDataControllerGetDelete');
        Route::get('/merged_data_education', [AdminMergedEducationDataController::class, 'getIndex'])->name('AdminMergedEducationDataControllerGetIndex');
        Route::post('/merged_data_education/edit-save/{id}', [AdminMergedEducationDataController::class, 'postEditSave'])->name('AdminMergedEducationDataControllerPostEditSave');
        Route::get('/approve_merged_data_education/{id}/{va_id}', [AdminMergedEducationDataController::class, 'approveMergedData'])->name('AdminMergedEducationDataControllerGetApprove');
        Route::get('/remerge_education_data/{id}/{va_id}', [AdminMergedEducationDataController::class, 'reMergeData'])->name('AdminMergedEducationDataControllerGetRemerge');

        Route::get('/verify_merged_data_education/{id}/{va_id}', [AdminMergedEducationDataController::class, 'verifyMergedData'])->name('AdminMergedEducationDataControllerGetVerify');
    });
    #admin related routes
    Route::prefix('admin')->group(function () {
        //dashboard route
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('DashboardController');
        #charts
        #1.pspchart
        Route::get('/dashboard/psptotal', [DashboardController::class, 'psptotaldata'])->name('psptotal');
        Route::get('/dashboard/pspchart', [DashboardController::class, 'pspdata'])->name('pspchart');
        #1.barchat
        Route::get('/dashboard/chartdata', [DashboardController::class, 'getapplicantByPrivilegeFroup'])->name('Chartdata');
        #2.designation_chart
        Route::get('/dashboard/designation_chart', [DashboardController::class, 'designation_chart'])->name('designation_chart');
        #3.reg_user_chart
        Route::get('/dashboard/reg_user_chart', [DashboardController::class, 'reg_user_chart'])->name('reg_user_chart');
        #4.paid_cancelled_applicant_chart
        Route::get('/dashboard/paid_cancelled_applicant_chart', [DashboardController::class, 'paid_cancelled_applicant_chart'])->name('paid_cancelled_applicant_chart');

        Route::get('/admit_card/user/{id}', [DashboardController::class, 'generateAdminCardForUser']);

        Route::get('/applied_count', [ApplicationReportController::class, 'AllApplications']);
    

        Route::get('/vacancy_apply/add/{ad_id}', [AdminVacancyApplyController::class, 'getAdd'])->name('apply');
        Route::post('/vacancy_apply/add/{add-save}', [AdminVacancyApplyController::class, 'postAddSave']);

        // Vacancy Reject
        // Route::get('/vacancy_apply/Cancel/{id}', [AdminVacancyApplyController::class, 'getCancel']);
        // Route::get('/vacancy_apply/Reject/{id}', [AdminVacancyApplyController::class, 'getReject']);
        // END Vacancy
        // Begin Vacancy Re-Apply
        Route::get('/vacancy_apply/reapply/{id}', [AdminVacancyApplyController::class, 'getReapply']);
        Route::post('/vacancy_apply/reapply-save', [AdminVacancyApplyController::class, 'postReapplySave']);
        // End Vacancy Re-Apply

        Route::get('/export_service_history/{id}', [AdminApplicantServiceHistoryController::class, 'getExportPdf']);
        // Route::get('/applicant_profile/archive/{id}', [ApplicantCBController::class, 'getArchive'])->name('archive_applicant');

        //Exam Schedule

        Route::get('/selected_candidates', [SelectedCandidatesController::class, 'getIndex'])->name('Report\SelectedCandidatesControllerGetIndex');

        Route::get('/selected_candidates_designation/{ad_id}/{id}', [SelectedCandidatesController::class, 'getCandidates'])->name('SelectedCandidatesGetCandidates');

        Route::get('/downloadPDF/{id}', [SelectedCandidatesController::class, 'downloadPDF']);
        Route::get('/selected_candidates/export/{id}', [SelectedCandidatesController::class, 'generateExcel']);
        Route::get('/selected_candidates/loksewaexport/{id}', [SelectedCandidatesController::class, 'generateLoksewaExcel']);

        Route::get('/selected_candidates/{id}', [SelectedCandidatesController::class, 'getDesignationView'])->name('selected_candidatesGetdesignation');

        #Routes for rejected candidates
        Route::get('/rejected_candidates/{id}', [AdminInternalRejectedCandidatesController::class, 'getDesignationView'])->name('rejected_candidatesGetdesignation');
        Route::get('/rejected_candidates_designation/{ad_id}/{id}', [AdminInternalRejectedCandidatesController::class, 'getCandidates'])->name('RejectedCandidatesGetCandidates');

        //New routes added
        Route::get('/application_details', [CandidateApplicationDetailsController::class, 'getIndex'])->name('Report\CandidateApplicationDetailsControllerGetIndex');
        Route::get('/application_details/{id}', [CandidateApplicationDetailsController::class, 'getDesignationView'])->name('application_details_designation_view');
        Route::get('/candidate_application_details/{id}', [CandidateApplicationDetailsController::class, 'getCandidates'])->name('application_details_getCandidates');

        Route::get('/roll', [ExamRollController::class, 'getIndex']);
        Route::get('/roll_add', [ExamRollController::class, 'getAdd']);

        Route::get('/file_promotion', [FilePromotionController::class, 'getIndex']);
        Route::get('/file_promotion/{id}', [FilePromotionController::class, 'getDesignationView']);
        Route::get('/file_promotion_designation/{id}', [FilePromotionController::class, 'getCandidates']);
        Route::get('/file_promotion/export/{id}', [FilePromotionController::class, 'generateExcel']);

        Route::get('/evaluation_individual_employee', [EvaluationIndividualEmployeeController::class, 'getIndex']);
        Route::get('/evaluation_individual_employee/{id}', [EvaluationIndividualEmployeeController::class, 'getDesignationView']);
        Route::get('/evaluation_individual_employee_designation/{id}', [EvaluationIndividualEmployeeController::class, 'getCandidates']);
        Route::get('/evaluation_individual_employee/export/{id}', [EvaluationIndividualEmployeeController::class, 'generateExcel'])->name('evalreportexcel');
        Route::get('/evaluation_individual_employee/exportpdf/{id}', [EvaluationIndividualEmployeeController::class, 'generatepdf'])->name('evalreportpdf');

        // Evaluation Routes
        Route::get('/evaluation', [EvaluationController::class, 'index']);
        Route::get('/evaluation/{id}', [EvaluationController::class, 'openEvaluation']);

        Route::get('/applicant_profile/details/{id}', [AdminApplicantProfileController::class, 'getdetails']);
        Route::get('/applicant_service_history/marks', [AdminApplicantServiceHistoryController::class, 'senioritycalculation'])->name('marks');

        // End of Evaluation Routes
        Route::get('/individual_evaluation/{id}', [EvaluationIndividualEmployeeController::class, 'getIndividaualIndex']);

        Route::get('/merged_data/edit/{id}', [AdminMergedDataController::class, 'getEdit'])->name('AdminMergedDataControllerGetEdit');
        Route::get('/merged_data/delete/{id}', [AdminMergedDataController::class, 'getDelete'])->name('AdminMergedDataControllerGetDelete');
        Route::get('/merged_data', [AdminMergedDataController::class, 'getIndex'])->name('AdminMergedDataControllerGetIndex');
        Route::post('/merged_data/edit-save/{id}', [AdminMergedDataController::class, 'postEditSave'])->name('AdminMergedDataControllerPostEditSave');
        Route::get('/approve_merged_data/{id}/{va_id}', [AdminMergedDataController::class, 'approveMergedData'])->name('AdminMergedDataControllerGetApprove');
        Route::get('/verify_merged_data/{id}/{va_id}', [AdminMergedDataController::class, 'verifyMergedData'])->name('AdminMergedDataControllerGetVerify');
        Route::get('/remerge_data/{id}/{va_id}', [AdminMergedDataController::class, 'reMergeData'])->name('AdminMergedDataControllerGetRemerge');

        Route::get('/merged_data_leave/edit/{id}', [AdminMergedApplicantLeaveController::class, 'getEdit'])->name('AdminMergedApplicantLeaveControllerGetEdit');
        Route::get('/merged_data_leave/delete/{id}', [AdminMergedApplicantLeaveController::class, 'getDelete'])->name('AdminMergedApplicantLeaveControllerGetDelete');
        Route::get('/merged_data_leave', [AdminMergedApplicantLeaveController::class, 'getIndex'])->name('AdminMergedApplicantLeaveControllerGetIndex');
        Route::post('/merged_data_leave/edit-save/{id}', [AdminMergedApplicantLeaveController::class, 'postEditSave'])->name('AdminMergedApplicantLeaveControllerPostEditSave');
        Route::get('/approve_merged_data_leave/{id}/{va_id}', [AdminMergedApplicantLeaveController::class, 'approveMergedData'])->name('AdminMergedApplicantLeaveControllerGetApprove');
        Route::get('/verify_merged_data_leave/{id}/{va_id}', [AdminMergedApplicantLeaveController::class, 'verifyMergedData'])->name('AdminMergedApplicantLeaveControllerGetVerify');
        Route::get('/remerge_data_leave/{id}/{va_id}', [AdminMergedApplicantLeaveController::class, 'reMergeData'])->name('AdminMergedApplicantLeaveControllerGetRemerge');


        Route::get('bulk_file_promotion/report',[BulkAppliedVacancyReportController::class,'getFilePromotionReport'])->name('bulk_applied_file_promotion_report');
        Route::post('bulk_file_promotion/report',[BulkAppliedVacancyReportController::class,'getFilePromotionReport'])->name('post_bulk_applied_file_promotion_report');

        Route::get('bulk_internal/report/{id}',[BulkAppliedVacancyReportController::class,'getInternalReport'])->name('bulk_applied_internal_report');
        Route::get('bulk_open/report/{id}',[BulkAppliedVacancyReportController::class,'getOpenReport'])->name('bulk_applied_open_report');

    });
    Route::get('/csr', [CsrController::class, 'getIndex'])->name('CsrPayments');
    Route::get('/logout-all-users', function(){
        Session::regenerate(true);
        return redirect()->route('login');
    })->name('logout.all');

    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
});
