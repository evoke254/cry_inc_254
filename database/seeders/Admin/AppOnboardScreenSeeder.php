<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppOnboardScreens;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppOnboardScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_onboard_screens = array(
            array('id' => '2','title' => 'Secure Investment Platform','sub_title' => 'By investing money you can easily earn through this system.','image' => 'ff365b93-66c9-4c95-9263-e21fbdad8511.webp','status' => '1','last_edit_by' => '1','created_at' => '2023-07-29 12:53:18','updated_at' => '2023-07-29 12:53:18')
        );
        AppOnboardScreens::insert($app_onboard_screens);
    }
}
