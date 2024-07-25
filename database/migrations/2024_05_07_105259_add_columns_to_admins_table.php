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
        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('two_factor_verified')->default(false);
            $table->boolean('two_factor_status')->default(false);
            $table->string('two_factor_secret')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('two_factor_verified');
            $table->dropColumn('two_factor_status');
            $table->dropColumn('two_factor_secret');
        });
    }
};
