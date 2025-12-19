<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'UAE Dirham',
                'code' => 'AED',
                'symbol' => 'دإ‏',
                'format' => 'دإ‏ 1,0.00',
                'exchange_rate' => '3.6727',
                'active' => 1,
                'default' => 0,
                'created_at' => '2023-12-29 10:25:13',
                'updated_at' => '2023-12-29 10:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Indian Rupee',
                'code' => 'INR',
                'symbol' => '₹',
                'format' => '1,0.00₹',
                'exchange_rate' => '83.20655',
                'active' => 1,
                'default' => 0,
                'created_at' => '2023-12-29 10:25:34',
                'updated_at' => '2023-12-29 10:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Nigeria, Naira',
                'code' => 'NGN',
                'symbol' => '₦',
                'format' => '₦1,0.00',
                'exchange_rate' => '896.61',
                'active' => 1,
                'default' => 0,
                'created_at' => '2023-12-29 10:26:06',
                'updated_at' => '2023-12-29 10:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'format' => '$1,0.00',
                'exchange_rate' => '1',
                'active' => 1,
                'default' => 1,
                'created_at' => '2023-12-29 10:26:15',
                'updated_at' => '2023-12-29 10:00:00',
            ),
        ));
        
        
    }
}