<?php

use App\Constants\GlobalConst;
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
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('duration');
            $table->enum('profit_return_type',[
                GlobalConst::INVEST_PROFIT_DAILY_BASIS,
                GlobalConst::INVEST_PROFIT_ONE_TIME,
            ]);
            $table->decimal('min_invest',28,8);
            $table->decimal('min_invest_offer',28,8)->default(0);
            $table->decimal('max_invest',28,8);
            $table->decimal('profit_fixed',28,8);
            $table->decimal('profit_percent',28,8);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment_plans');
    }
};
