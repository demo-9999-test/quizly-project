<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminColorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_colors')->delete();
        
        \DB::table('admin_colors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bg_light_grey' => '#f1f1f1',
                'bg_white' => '#ffffff',
                'bg_dark_blue' => '#131d5a',
                'bg_dark_grey' => '#e9e9eb',
                'bg_black' => '#000000',
                'bg_yellow' => '#f99d30',
                'text_black' => '#000000',
                'text_dark_grey' => '#747479',
                'text_light_grey' => '#f1f1f1',
                'text_dark_blue' => '#131d5a',
                'text_white' => '#ffffff',
                'text_red' => '#e92b2b',
                'text_yellow' => '#f99d30',
                'border_white' => '#ffffff',
                'border_black' => '#000000',
                'border_light_grey' => '#f1f1f1',
                'border_dark_grey' => '#747479',
                'border_dark_blue' => '#131d5a',
                'border_grey' => '#e9e9eb',
                'border_yellow' => '#f99d30',
                'created_at' => NULL,
                'updated_at' => '2024-01-04 05:55:57',
            ),
        ));
        
        
    }
}