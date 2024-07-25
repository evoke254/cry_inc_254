<?php

use App\Http\Helpers\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\ProfileController;
use App\Http\Controllers\Api\V1\User\AddMoneyController;
use App\Http\Controllers\Api\V1\User\WithdrawController;
use App\Http\Controllers\Api\V1\User\DashboardController;
use App\Http\Controllers\Api\V1\User\InvestPlanController;
use App\Http\Controllers\Api\V1\User\TransactionController;
use App\Http\Controllers\Api\V1\User\MoneyTransferController;
use App\Http\Controllers\Api\V1\User\ReferLevelController;

Route::prefix("user")->name("api.user.")->group(function(){

    Route::controller(ProfileController::class)->prefix('profile')->group(function(){
        Route::get('info','profileInfo');
        Route::post('info/update','profileInfoUpdate')->middleware(['app.mode']);
        Route::post('password/update','profilePasswordUpdate')->middleware(['app.mode']);
    });

    // Logout Route
    Route::post('logout',[ProfileController::class,'logout']);

    // // Add Money Routes
    Route::controller(AddMoneyController::class)->prefix("add-money")->name('add.money.')->group(function(){
        Route::get("payment-gateways","getPaymentGateways");

        // Submit with automatic gateway
        Route::post("automatic/submit","automaticSubmit");

        // Automatic Gateway Response Routes
        Route::get('success/response/{gateway}','success')->withoutMiddleware(['auth:api'])->name("payment.success");
        Route::get("cancel/response/{gateway}",'cancel')->withoutMiddleware(['auth:api'])->name("payment.cancel");

        // POST Route For Unauthenticated Request
        Route::post('success/response/{gateway}', 'postSuccess')->name('payment.success')->withoutMiddleware(['auth:api']);
        Route::post('cancel/response/{gateway}', 'postCancel')->name('payment.cancel')->withoutMiddleware(['auth:api']);

        //redirect with Btn Pay
        Route::get('redirect/btn/checkout/{gateway}', 'redirectBtnPay')->name('payment.btn.pay')->withoutMiddleware(['auth:api']);

        Route::get('manual/input-fields','manualInputFields');

        // Submit with manual gateway
        Route::post("manual/submit","manualSubmit");

        // Automatic gateway additional fields
        Route::get('payment-gateway/additional-fields','gatewayAdditionalFields');

        Route::prefix('payment')->name('payment.')->group(function() {
            Route::post('crypto/confirm/{trx_id}','cryptoPaymentConfirm')->name('crypto.confirm');
        });

    });

    // // Dashboard, Notification, 
    Route::controller(DashboardController::class)->group(function(){
        Route::get("dashboard","dashboard");
        Route::get("notifications","notifications");
    });

    // // Money Transfer
    Route::controller(MoneyTransferController::class)->prefix("money-transfer")->group(function(){
        Route::get("wallets","getWallets");
        Route::post("submit","submit");
    });

    // // Transaction
    Route::controller(TransactionController::class)->prefix("transaction")->group(function(){
        Route::get("log","log");
    });

    Route::controller(InvestPlanController::class)->prefix('invest-plan')->group(function() {
        Route::get('list','investPlans');
        Route::post('purchase/{invest_plan}','planPurchase');
        Route::get('my-investments','myInvestments');
        Route::get('profit-log','profitLog');
    });

    // Withdraw
    Route::controller(WithdrawController::class)->prefix("withdraw")->group(function(){
        Route::get('wallet-gateways',"walletGateways");
        Route::get('gateway/input-fields','gatewayInputFields');
        Route::post("submit","submit");
    });

    // My Status
    Route::controller(ReferLevelController::class)->prefix('my-status')->group(function() {
        Route::get('refer-data','referData');
    });

});