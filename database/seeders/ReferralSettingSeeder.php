<?php

namespace Database\Seeders;

use App\Models\Admin\ReferralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(!ReferralSetting::first()) {
            ReferralSetting::create(array('id' => '1','bonus' => '0.50000000','wallet_type' => 'c_balance','mail' => '1','status' => '1','created_at' => '2023-09-14 16:22:53','updated_at' => '2023-09-14 16:22:53'));
        }
    }
}
