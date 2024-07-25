<?php

namespace Database\Seeders\User;

use App\Models\ReferralLevelPackage;
use App\Models\User;
use App\Models\UserEarnReferralLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_users = User::all();
        $default_level = ReferralLevelPackage::default()->first();
        foreach($all_users as $user) {
            if(!$user->referral_id && $default_level) {
                $user->update([
                    'referral_id'       => generate_unique_string('users','referral_id',8,'number'),
                ]);
    
                // assign users to new level
                UserEarnReferralLevel::create([
                    'user_id'                       => $user->id,
                    'referral_level_package_id'     => $default_level->id,
                    'created_at'                    =>  now(),
                ]);
            }

        }
    }
}
