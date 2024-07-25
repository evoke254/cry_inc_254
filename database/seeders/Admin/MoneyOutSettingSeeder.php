<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\MoneyOutSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoneyOutSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MoneyOutSetting::firstOrCreate([
            'c_balance'     => false,
            'p_balance'     => true,
        ]);
    }
}
