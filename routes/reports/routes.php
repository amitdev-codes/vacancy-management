<?php

use App\Http\Controllers\Admin\ApplicantCountReportController;
use App\Http\Controllers\Admin\BulkApplicantDesignationBasedReportController;
use App\Http\Controllers\Admin\Reports\DesignationGroupBasedReportController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->group(function () {
    Route::get('report/open-candidates',[ApplicantCountReportController::class,'openCandidatesReport'])->name('open_candidates_report');
    Route::get('report/internal-candidates',[ApplicantCountReportController::class,'internalCandidatesReport'])->name('internal_candidates_report');
    Route::get('report/designation/open-candidates',[BulkApplicantDesignationBasedReportController::class,'openCandidatesReport'])->name('openCandidatesDesignationBasedReport');


    Route::get('report/openingTypeBasedPayment',[DesignationGroupBasedReportController::class,'vacancyPaymentReport'])->name('openingTypeBasedPayment');
    Route::get('report/groupBased',[DesignationGroupBasedReportController::class,'report'])->name('groupBasedReport');
    Route::get('report/groupBasedDoublePayment',[DesignationGroupBasedReportController::class,'doublePaymentReport'])->name('groupBasedDoublePaymentReport');
    Route::get('report/groupBasedPspPayment',[DesignationGroupBasedReportController::class,'pspPaymentReport'])->name('groupBasedPspPaymentReport');
});