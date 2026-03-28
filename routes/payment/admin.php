<?php

use App\Http\Controllers\Payment\OnlinePayment\Namastepay\NamastePayController;
use App\Http\Controllers\Payment\OnlinePayment\PaymentVerificationController;
use App\Http\Controllers\Payment\OnlinePayment\Sajilopay\SajiloPayController;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::get('namastepayLogin', [NamastePayController::class, 'login'])->name('namastePayLogin');
    Route::post('namastepayLogin', [NamastePayController::class, 'postLogin'])->name('namastePayLogin');
    Route::post('namastepayOtpValidation', [NamastePayController::class, 'otpValidation'])->name('namastePayOtpValidation');
    Route::get('namastePayResendOtp', [NamastePayController::class, 'resendOtp'])->name('resendNamastePayOtp');
    Route::get('namastePayInquiry', [PaymentVerificationController::class, 'namastePay'])->name('verify_payment_namastepay');
});
Route::prefix('app')->group(function () {
    Route::post('sajilopayLogin', [SajiloPayController::class, 'processPayment'])->name('sajilopayProcessPayment');
    Route::get('sajilopay/success', [SajiloPayController::class, 'paymentSuccess'])->name('sajilopaySuccess');
    Route::get('sajilopay/failure', [SajiloPayController::class, 'paymentFailure'])->name('sajilopayFailure');
});