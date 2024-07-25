<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\InvestmentPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $investment_plans = array(
            array('id' => '8','name' => 'Starter Plan','slug' => 'starter-plan','title' => 'Starter Plan','duration' => '1','profit_return_type' => 'DAILY-BASIS','min_invest' => '29.00000000','min_invest_offer' => '24.00000000','max_invest' => '49.00000000','profit_fixed' => '3.00000000','profit_percent' => '2.00000000','status' => '1','created_at' => '2023-08-10 20:27:28','updated_at' => '2023-08-10 20:27:28'),
            array('id' => '9','name' => 'Basic Investment','slug' => 'basic-investment','title' => 'Basic Investment','duration' => '3','profit_return_type' => 'DAILY-BASIS','min_invest' => '55.00000000','min_invest_offer' => '0.00000000','max_invest' => '99.00000000','profit_fixed' => '5.00000000','profit_percent' => '2.00000000','status' => '1','created_at' => '2023-08-10 20:28:18','updated_at' => '2023-08-10 20:28:18'),
            array('id' => '10','name' => 'Growth Plus','slug' => 'growth-plus','title' => 'Growth Plus','duration' => '7','profit_return_type' => 'ONE-TIME','min_invest' => '110.00000000','min_invest_offer' => '100.00000000','max_invest' => '299.00000000','profit_fixed' => '10.00000000','profit_percent' => '7.00000000','status' => '1','created_at' => '2023-08-10 20:29:03','updated_at' => '2023-08-10 20:29:03'),
            array('id' => '11','name' => 'Advanced Portfolio','slug' => 'advanced-portfolio','title' => 'Advanced Portfolio','duration' => '14','profit_return_type' => 'DAILY-BASIS','min_invest' => '310.00000000','min_invest_offer' => '0.00000000','max_invest' => '499.00000000','profit_fixed' => '14.00000000','profit_percent' => '9.00000000','status' => '1','created_at' => '2023-08-10 20:29:49','updated_at' => '2023-08-10 20:29:49'),
            array('id' => '12','name' => 'Premium Strategy','slug' => 'premium-strategy','title' => 'Premium Strategy','duration' => '21','profit_return_type' => 'DAILY-BASIS','min_invest' => '399.00000000','min_invest_offer' => '500.00000000','max_invest' => '799.00000000','profit_fixed' => '17.00000000','profit_percent' => '11.00000000','status' => '1','created_at' => '2023-08-10 20:30:53','updated_at' => '2023-08-10 20:30:53'),
            array('id' => '13','name' => 'Ultimate Wealth','slug' => 'ultimate-wealth','title' => 'Ultimate Wealth','duration' => '29','profit_return_type' => 'ONE-TIME','min_invest' => '699.00000000','min_invest_offer' => '645.00000000','max_invest' => '999.00000000','profit_fixed' => '22.00000000','profit_percent' => '18.00000000','status' => '1','created_at' => '2023-08-10 20:31:31','updated_at' => '2023-08-10 20:31:31')
        );

        InvestmentPlan::insert($investment_plans);
    }
}
