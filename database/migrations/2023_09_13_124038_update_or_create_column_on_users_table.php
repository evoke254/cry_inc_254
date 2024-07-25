<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(Schema::hasColumn('users','refferal_user_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('refferal_user_id');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_id')->after('remember_token')->nullable();
            $table->unsignedBigInteger('current_referral_level_id')->after('referral_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('referral_id');
        });
    }
};
