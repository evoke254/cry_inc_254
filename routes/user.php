<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\User\KycController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\AddMoneyController;
use App\Http\Controllers\User\SecurityController;
use App\Http\Controllers\User\WithdrawController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\InvestmentController;
use App\Http\Controllers\User\InvestPlanController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\MoneyTransferController;
use App\Http\Controllers\User\ProfitLogController;
use App\Http\Controllers\User\ReferLevelController;
use App\Http\Controllers\User\SupportTicketController;

Route::prefix("user")->name("user.")->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('dashboard','index')->name('dashboard');
        Route::post('logout','logout')->name('logout');
    });

    Route::controller(ProfileController::class)->prefix("profile")->name("profile.")->group(function(){
        Route::get('/','index')->name('index');
        Route::put('update','update')->name('update')->middleware(['app.mode']);
        Route::post('delete','delete')->name('delete')->middleware(['app.mode']);
        Route::get('change-password','changePasswordView')->name('change.password.index')->middleware(['app.mode']);
        Route::put('password/update','passwordUpdate')->name('password.update')->middleware(['app.mode']);
    });

    Route::controller(SupportTicketController::class)->prefix("support-ticket")->name("support.ticket.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('conversation/{encrypt_id}','conversation')->name('conversation');
        Route::post('message/send','messageSend')->name('messaage.send');
    });

    Route::controller(SecurityController::class)->prefix("security")->name('security.')->group(function(){
        Route::get('google/2fa','google2FA')->name('google.2fa');
        Route::post('google/2fa/status/update','google2FAStatusUpdate')->name('google.2fa.status.update');
    });

    Route::controller(KycController::class)->prefix('kyc')->name('kyc.')->group(function() {
        Route::get('/','index')->name('index');
        Route::post('submit','store')->name('submit');
    });

    Route::controller(TransactionController::class)->prefix('transaction')->name('transaction.')->group(function() {
        Route::get('list','index')->name('index');
    });

    Route::controller(WithdrawController::class)->middleware(['kyc.verification.guard'])->prefix('withdraw')->name('withdraw.')->group(function() {
        Route::get('/','index')->name('index');
        Route::post('submit','submit')->name('submit');
        Route::get('instruction/{token}','instruction')->name('instruction');
        Route::post('instruction/submit/{token}','instructionSubmit')->name('instruction.submit');
    });

    Route::controller(MoneyTransferController::class)->prefix('money-transfer')->name('money.transfer.')->group(function() {
        Route::get('/','index')->name('index');
        Route::post('submit','submit')->name('submit');
    });

    Route::controller(AddMoneyController::class)->prefix('add-money')->name('add.money.')->group(function() {
        Route::get('/','index')->name('index');
        Route::post('submit','submit')->name('submit');

        Route::get('success/response/{gateway}','success')->name('payment.success');
        Route::get("cancel/response/{gateway}",'cancel')->name('payment.cancel');
        Route::post("callback/response/{gateway}",'callback')->name('payment.callback')->withoutMiddleware(['web','auth','verification.guard','user.google.two.factor']);

        // POST Route For Unauthenticated Request
        Route::post('success/response/{gateway}', 'postSuccess')->name('payment.success')->withoutMiddleware(['auth','verification.guard','user.google.two.factor']);
        Route::post('cancel/response/{gateway}', 'postCancel')->name('payment.cancel')->withoutMiddleware(['auth','verification.guard','user.google.two.factor']);

        // redirect with HTML form route
        Route::get('redirect/form/{gateway}', 'redirectUsingHTMLForm')->name('payment.redirect.form')->withoutMiddleware(['auth','verification.guard','user.google.two.factor']);

        //redirect with Btn Pay
        Route::get('redirect/btn/checkout/{gateway}', 'redirectBtnPay')->name('payment.btn.pay')->withoutMiddleware(['auth','verification.guard','user.google.two.factor']);

        Route::get('manual/{token}','showManualForm')->name('manual.form');
        Route::post('manual/submit/{token}','manualSubmit')->name('manual.submit');

        Route::prefix('payment')->name('payment.')->group(function() {
            Route::get('crypto/address/{trx_id}','cryptoPaymentAddress')->name('crypto.address');
            Route::post('crypto/confirm/{trx_id}','cryptoPaymentConfirm')->name('crypto.confirm');
        });
    });

    Route::controller(InvestPlanController::class)->prefix('invest-plan')->name('invest.plan.')->group(function() {
        Route::get('/','index')->name('index');
        Route::post('purchase/{invest_plan?}','purchase')->name('purchase');
    });

    Route::controller(InvestmentController::class)->prefix('my-invest')->name('my.invest.')->group(function() {
        Route::get('/','index')->name('index');
    });

    Route::controller(ProfitLogController::class)->prefix('profit-log')->name('profit.log.')->group(function() {
        Route::get('/','index')->name('index');
    });

    Route::controller(ReferLevelController::class)->prefix('refer/level')->name('refer.level.')->group(function() {
        Route::get('/','index')->name('index');
    });

    Route::post("info",[GlobalController::class,'userInfo'])->middleware('auth')->name('info');

});
