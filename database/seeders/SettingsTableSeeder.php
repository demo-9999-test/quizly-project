<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('settings')->delete();
        
        DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => '2023-12-02 11:35:44',
                'updated_at' => '2024-01-08 12:28:40',
                'login_img' => '1704180687.png',
                'signup_img' => '1704180687.png',
                'right_click_status' => 0,
                'preloader_enable_status' => 0,
                'inspect_status' => 0,
                'ip_block_status' => 0,
                'mobile_status' => 0,
                'cookie_status' => 0,
                'device_status' => 0,
                'activity_status' => 0,
                'welcome_status' => 0,
                'verify_status' => 0,
                'admin_logo' => '1704351986.png',
            ),
        ));
        
        
    }
}