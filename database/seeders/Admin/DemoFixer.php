<?php

namespace Database\Seeders\Admin;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\Admin\Admin;
use App\Models\Admin\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\ReferralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DemoFixer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'firstname'     => "Ad",
                'lastname'      => "Min",
                'username'      => "admin",
                'email'         => "admin@appdevs.net",
                'password'      => Hash::make("appdevs"),
                'created_at'    => now(),
                'status'        => true,
            ],
            [
                'firstname'     => "Sub",
                'lastname'      => "Admin",
                'username'      => "subadmin",
                'email'         => "subadmin@appdevs.net",
                'password'      => Hash::make("appdevs"),
                'created_at'    => now(),
                'status'        => true,
            ],

        ];

        Admin::insert($data);

        // Insert Wallets with Balance
        $all_user_ids = User::pluck("id")->toArray();
        $currency_id = Currency::default()->first()->id;
        $wallets = [];
        foreach($all_user_ids as $id) {
            $wallets[] = [
                'user_id'       => $id,
                'currency_id'   => $currency_id,
                'balance'       => 2000,
                'status'        => true,
                'created_at'    => now(),
            ];
        }

        UserWallet::insert($wallets);
    }
}
