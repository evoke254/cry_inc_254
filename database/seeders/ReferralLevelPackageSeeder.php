<?php

namespace Database\Seeders;

use App\Models\ReferralLevelPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferralLevelPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $referral_level_packages = array(
            array('id' => '3','title' => 'Level One','refer_user' => '0','invested_amount' => '0','commission' => '1.00000000','default' => '1','created_at' => '2023-09-14 15:51:55','updated_at' => '2023-09-14 15:51:55'),
            array('id' => '4','title' => 'Level Two','refer_user' => '5','invested_amount' => '100','commission' => '2','default' => '0','created_at' => '2023-09-14 15:51:55','updated_at' => '2023-09-14 15:51:55'),
            array('id' => '5','title' => 'Level Three','refer_user' => '10','invested_amount' => '500','commission' => '3','default' => '0','created_at' => '2023-09-14 15:51:55','updated_at' => '2023-09-14 15:51:55'),
            array('id' => '6','title' => 'Level Four','refer_user' => '30','invested_amount' => '1000','commission' => '5','default' => '0','created_at' => '2023-09-14 15:51:55','updated_at' => '2023-09-14 15:51:55'),
            array('id' => '7','title' => 'Level Five','refer_user' => '50','invested_amount' => '5000','commission' => '10','default' => '0','created_at' => '2023-09-14 15:51:55','updated_at' => '2023-09-14 15:51:55'),
            array('id' => '8','title' => 'Level Six','refer_user' => '100','invested_amount' => '10000','commission' => '50','default' => '0','created_at' => '2023-09-14 15:51:55','updated_at' => '2023-09-14 15:51:55'),
        );
        
        ReferralLevelPackage::upsert($referral_level_packages,['id'],[]);
    }
}
