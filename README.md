<<<<<<<< Update Guide >>>>>>>>>>>

Clone Version: 2.3.3
Immediate Older Version: 2.3.3
Current Version: 2.4.0

Update Features::
1. BUG Fix
2. 2FA Authentication In Admin Panel
3. Performance Improvement
--------------------------------------------------------------------------------

Please Use Those Command On Your Terminal To Update v2.3.3 to v2.4.0
1. To Added New Migration File
    php artisan migrate

2. To Update Version Related Feature Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\UpdateFeatureSeeder

3. To clear view file cache (Make Sure Your Targeted Location Is Project Root)
    php artisan view:clear
    
---------------------------------------------------------------------------------

Please Use Those Command On Your Terminal To Update version any to v2.3.4

1. To Add New Migration Changes Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan migrate

2. To Update Language Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\Admin\\LanguageSeeder

3. To Add Referral Settings Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\ReferralSettingSeeder

4. To Add Some Referral Level Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\ReferralLevelPackageSeeder

5. To Assign Exists Users Referral ID & Assign System Default Level Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\User\\UserUpdateSeeder

6. To Update Version Related Feature Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\UpdateFeatureSeeder

7. To Add New Payment Gateways Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\Admin\\PaymentGatewaySeeder

8. To clear view file cache (Make Sure Your Targeted Location Is Project Root)
    php artisan view:clear

---------------------------------------------------------------------------------