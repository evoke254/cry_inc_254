<?php

namespace Database\Seeders\Admin;

use App\Constants\GlobalConst;
use Illuminate\Database\Seeder;
use App\Models\Admin\TransactionSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            GlobalConst::TRANSFER   => 'Transfer Money Charges',
        ];
        $create = [];
        foreach($data as $slug => $item) {
            $create[] = [
                'admin_id'          => 1,
                'slug'              => $slug,
                'title'             => $item,
                'max_limit'         => 50000,
                'monthly_limit'     => 50000,
                'daily_limit'       => 5000,
                'fixed_charge'      => 0,
                'percent_charge'    => 2,
            ];
        }
        TransactionSetting::insert($create);
    }
}
