<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\User\UserSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\CurrencySeeder;
use Database\Seeders\Admin\LanguageSeeder;
use Database\Seeders\Admin\SetupKycSeeder;
use Database\Seeders\Admin\SetupSeoSeeder;
use Database\Seeders\Admin\ExtensionSeeder;
use Database\Seeders\Admin\SetupPageSeeder;
use Database\Seeders\Admin\UsefulLinkSeeder;
use Database\Seeders\Admin\AppSettingsSeeder;
use Database\Seeders\Admin\AdminHasRoleSeeder;
use Database\Seeders\Admin\AnnouncementSeeder;
use Database\Seeders\Admin\SiteSectionsSeeder;
use Database\Seeders\Admin\BasicSettingsSeeder;
use Database\Seeders\Admin\InvestmentPlanSeeder;
use Database\Seeders\Admin\PaymentGatewaySeeder;
use Database\Seeders\Admin\MoneyOutSettingSeeder;
use Database\Seeders\Admin\AppOnboardScreenSeeder;
use Database\Seeders\Admin\DemoFixer;
use Database\Seeders\Admin\TransactionSettingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            AdminSeeder::class,
            RoleSeeder::class,
            TransactionSettingSeeder::class,
            CurrencySeeder::class,
            BasicSettingsSeeder::class,
            SetupSeoSeeder::class,
            AppSettingsSeeder::class,
            SiteSectionsSeeder::class,
            SetupKycSeeder::class,
            ExtensionSeeder::class,
            AdminHasRoleSeeder::class,
            SetupPageSeeder::class,
            PaymentGatewaySeeder::class,
            MoneyOutSettingSeeder::class,
            LanguageSeeder::class,
            AppOnboardScreenSeeder::class,
            UsefulLinkSeeder::class,
            ReferralSettingSeeder::class,
            ReferralLevelPackageSeeder::class,
            
            // Demo Seeder Files
            // UserSeeder::class,
            // InvestmentPlanSeeder::class,
            // AnnouncementSeeder::class,
            // DemoFixer::class,
        ]);
    }
}
