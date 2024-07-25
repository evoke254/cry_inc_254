<?php

use App\Http\Controllers\Frontend\IndexController;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function() {

    Route::controller(IndexController::class)->group(function() {
        Route::get('/','index')->name('index');

        Route::get('/about','aboutView')->name('about');

        Route::get('invest/plan','investPlanView')->name('invest.plan.list');

        Route::get('announcements','announcementsView')->name('announcement.list');
        Route::get('announcement/details/{announcement?}','announcementDetails')->name('announcement.details');

        Route::get('contact','contactView')->name('contact');

        Route::post("subscribe","subscribe")->name("subscribe");

        Route::post("contact/message/send","contactMessageSend")->name("contact.message.send");

        Route::get('link/{slug}','usefulLink')->name('useful.links');

        Route::post('languages/switch','languageSwitch')->name('languages.switch');
    });

});