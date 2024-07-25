<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\SetupPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SetupPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages =  [
            "Home"          => "frontend.index",
            "About"         => "frontend.about", 
            "Plan"          => "frontend.invest.plan.list", 
            "Announcement"  => "frontend.announcement.list", 
            "Contact"       => "frontend.contact",
        ];

        $data = [];
        foreach($pages as $item => $route_name) {
            $data[] = [
                'slug'          => Str::slug($item),
                'title'         => $item,
                'route_name'    => $route_name,
                'url'           => URL::route($route_name,[],false),
                'last_edit_by'  => 1,
                'created_at'    => now(),
            ];
        }   

        SetupPage::insert($data);
    }
}
