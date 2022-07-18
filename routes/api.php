<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sms\MTNRouterController;
use App\Http\Controllers\sms\VodafoneRouterController;
use App\Http\Controllers\payment\MTNCallBackController;
use App\Http\Controllers\payment\TigoCallBackController;
use App\Http\Controllers\ussd\MTNUSSDCallBackController;
use App\Http\Controllers\ussd\TigoUSSDCallBackController;
use App\Http\Controllers\payment\StanbicCallBackController;
use App\Http\Controllers\sms\ReceiveSubscriptionController;
use App\Http\Controllers\payment\VodafoneCallBackController;
use App\Http\Controllers\ussd\VodafoneUSSDCallBackController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
	Route::post('sms/vodafone', [VodafoneRouterController::class, 'receiveCallBackResponse']);
    Route::post('sms/mtn', [MTNRouterController::class, 'receiveCallBackResponse']);

    Route::post('payment/mtn', [MTNCallBackController::class, 'receiveCallBackResponse']);
    Route::post('payment/vodafone', [VodafoneCallBackController::class, 'receiveCallBackResponse']);
    Route::post('payment/tigo', [TigoCallBackController::class, 'receiveCallBackResponse']);
    Route::post('payment/stanbic', [StanbicCallBackController::class, 'receiveCallBackResponse']);
    Route::post('ussd/mtn', [MTNUSSDCallBackController::class, 'receiveCallBackResponse']);
    Route::post('ussd/vodafone', [VodafoneUSSDCallBackController::class, 'receiveCallBackResponse']);
    Route::post('ussd/tigo', [TigoUSSDCallBackController::class, 'receiveCallBackResponse']);

    Route::post('receive-sub/{serviceid}', [ReceiveSubscriptionController::class, 'subscription']);
    Route::delete('receive-sub/{serviceid}', [ReceiveSubscriptionController::class, 'deletationStateChange']);
    Route::put('receive-sub/{serviceid}', 'App\Http\Controllers\sms\ReceiveSubscriptionController@updateStateChange');
    Route::get('receive-sub/{serviceid}', [ReceiveSubscriptionController::class, 'stateChange']);
    Route::patch('receive-sub/{serviceid}', [ReceiveSubscriptionController::class, 'stateChange']);
});


