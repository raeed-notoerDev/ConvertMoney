<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            'key' => 'commission_admin',
            'value' => '1',
        ],[
            'key' => 'commission_currency',
            'value' => '0.01',
        ]);
    }
}
