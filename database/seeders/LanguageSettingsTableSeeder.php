<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('language_settings')->delete();
        
        DB::table('language_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'local' => 'en',
                'name' => 'English',
                'status' => 0,
                'image' => '1701926961.png',
                'created_at' => '2023-12-07 05:29:21',
                'updated_at' => '2024-01-11 11:31:58',
            ),
            1 => 
            array (
                'id' => 2,
                'local' => 'hi',
                'name' => 'Hindi',
                'status' => 0,
                'image' => '1701927023.png',
                'created_at' => '2023-12-07 05:30:23',
                'updated_at' => '2024-01-09 14:21:40',
            ),
            2 => 
            array (
                'id' => 4,
                'local' => 'zh',
                'name' => 'China',
                'status' => 0,
                'image' => '1704352382.png',
                'created_at' => '2024-01-04 07:13:02',
                'updated_at' => '2024-01-04 07:22:48',
            ),
            3 => 
            array (
                'id' => 5,
                'local' => 'ar',
                'name' => 'Arabic',
                'status' => 0,
                'image' => '1704459035.png',
                'created_at' => '2024-01-05 12:50:35',
                'updated_at' => '2024-01-05 12:50:35',
            ),
        ));
        
        
    }
}