<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\Admin\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
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
                'firstname'         => "AppDevs",
                'lastname'          => "User",
                'email'             => "user@appdevs.net",
                'username'          => "appdevsuser",
                'status'            => true,
                'password'          => Hash::make("appdevs"),
                'email_verified'    => true,
                'sms_verified'      => true,
                'created_at'        => now(),
                'referral_id'       => '00000001'
            ],
            [
                'firstname'         => "AppDevs",
                'lastname'          => "User2",
                'email'             => "user2@appdevs.net",
                'username'          => "appdevsuser2",
                'status'            => true,
                'password'          => Hash::make("appdevs"),
                'email_verified'    => true,
                'sms_verified'      => true,
                'created_at'        => now(),
                'referral_id'       => '00000002'
            ],
            [
                'firstname'         => "AppDevs",
                'lastname'          => "User3",
                'email'             => "user3@appdevs.net",
                'username'          => "appdevsuser3",
                'status'            => true,
                'password'          => Hash::make("appdevs"),
                'email_verified'    => true,
                'sms_verified'      => true,
                'created_at'        => now(),
                'referral_id'       => '00000003'
            ],
            [
                'firstname'         => "AppDevs",
                'lastname'          => "User4",
                'email'             => "user4@appdevs.net",
                'username'          => "appdevsuser4",
                'status'            => true,
                'password'          => Hash::make("appdevs"),
                'email_verified'    => true,
                'sms_verified'      => true,
                'created_at'        => now(),
                'referral_id'       => '00000004'
            ],
            [
                'firstname'         => "AppDevs",
                'lastname'          => "User5",
                'email'             => "user5@appdevs.net",
                'username'          => "appdevsuser5",
                'status'            => true,
                'password'          => Hash::make("appdevs"),
                'email_verified'    => true,
                'sms_verified'      => true,
                'created_at'        => now(),
                'referral_id'       => '00000005'
            ],
        ];

        User::upsert($data,['username'],['firstname','lastname','email','status','password','email_verified','sms_verified','referral_id']);
    }
}
