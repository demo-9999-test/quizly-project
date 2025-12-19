<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('general_settings')->delete();

        \DB::table('general_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
            'contact' => '+1 (783) 663-5703',
                'copyright_text' => 'In id in qui aut',
                'email' => 'dudibyqa@mailinator.com',
                'support_email' => 'dinakak126@roborena.com',
                'address' => 'Tempore sunt sint',
                'iframe_url' => '#000000',
                'promo_text' => 'Amet beatae placeat',
                'promo_link' => 'https://www.kobyfavabukevic.in',
                'logo' => '1704878412.png',
                'footer_logo' => '1704177540.png',
                'favicon_logo' => '1704524873.png',
                'preloader_logo' => '1704177462.png',
                'created_at' => '2023-11-21 08:37:40',
                'updated_at' => '2024-01-10 14:50:12',
            ),
        ));


    }
}
