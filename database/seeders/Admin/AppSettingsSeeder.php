<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_settings = array('id' => '1','version' => '1.0.0','splash_screen_image' => 'c49384a9-fe99-48e6-ae4d-473768deb5a5.webp','url_title' => 'Download App From Store','android_url' => 'https://play.google.com/','iso_url' => 'https://www.apple.com/app-store/','created_at' => '2023-07-26 15:43:34','updated_at' => '2023-07-29 12:55:58');

        AppSettings::firstOrCreate($app_settings);
    }
}
