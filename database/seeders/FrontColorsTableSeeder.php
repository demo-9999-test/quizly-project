<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FrontColorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('front_theme_settings')->delete();

        \DB::table('front_theme_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
                'bg_blue' => '#293fcc',
                'bg_white' => '#ffffff',
                'bg_lgt_blue' => '#6949ff0d',
                'bg_yellow' => '#ff9f22',
                'bg_lgt_blue_2' => '#fafbff',
                'bg_grey' => '#00000080',
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
