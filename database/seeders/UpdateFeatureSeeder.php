<?php

namespace Database\Seeders;

use App\Models\Admin\BasicSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(BasicSettings::first()) {
            BasicSettings::first()->update([
                'web_version'       => "2.3.4",
            ]);
        }
    }
}
