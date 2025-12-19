<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AllcitiesTableSeeder::class);
        $this->call(AllcountryTableSeeder::class);
        $this->call(AllstatesTableSeeder::class);
        $this->call(AdminColorsTableSeeder::class);
        $this->call(GeneralSettingsTableSeeder::class);
        $this->call(SocialSettingsTableSeeder::class);
        $this->call(LanguageSettingsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(ApiSettingsTableSeeder::class);
    }
}
