<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApiSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('api_settings')->delete();
        
        DB::table('api_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
            'adsense_script' => 'console.log("Hello");',
                'ad_status' => 0,
            'analytics_script' => 'console.log("Hello2");',
                'an_status' => 0,
                'recaptcha_status' => 0,
                'aws_status' => 1,
                'youtube_status' => 1,
                'vimeo_status' => 1,
                'gtm_status' => 1,
                'mailchip_api_key' => 'eyJpdiI6ImxQVVVWQ3hJMC9jVVRVM2h4MEhPNWc9PSIsInZhbHVlIjoicGNicUFLTk1ycS9uR0J0UTI1OTViQT09IiwibWFjIjoiNmZmZmY2OGI5Y2EzNGExMTA4MjhjYWRjMDAzNDhhY2QwMWU4ZGVhMWNlNDAxZjMzNTIzZDE4ODdlZmM4NmU0MSIsInRhZyI6IiJ9',
                'mailchip_id' => NULL,
                'fb_pixel' => 'eyJpdiI6IkRhaVhtZzNmQ1VXbUVkYUwyb2R4N1E9PSIsInZhbHVlIjoiZi8rTERlemJaeEVnMHlUejN4NGJpQT09IiwibWFjIjoiZDE2ODQ2ZDI5MTAxZTNhYjFmN2M5ZWY3MjQzMzQ4YmEwZjI5OWRhNTdkMzAzMzRjOWNkMzA4MmQwZGM2MTUwMCIsInRhZyI6IiJ9',
                'created_at' => '2024-01-02 04:36:08',
                'updated_at' => '2024-01-11 14:17:50',
            ),
        ));
        
        
    }
}