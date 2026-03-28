<?php

use App\Http\Controllers\API\TokenPayment\TokenPaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['throttle:60,1', 'pspkey', 'logroute'], 'prefix' => 'applicant'], function () {
    Route::post('validate', [TokenPaymentController::class, 'applicantValidation']);
    Route::post('inquiry', [TokenPaymentController::class, 'paymentinquiry']);
    Route::post('payment', [TokenPaymentController::class, 'payment']);
});
