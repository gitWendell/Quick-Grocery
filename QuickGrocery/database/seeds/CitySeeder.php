<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cities')->insert([
            "id" => 884,
            "psgcCode" => "072226000",
            "citymunDesc" => "LAPU-LAPU CITY (OPON)",
            "regDesc" => "07",
            "provCode" => "0722",
            "citymunCode" => "072226"
        ]);
    }
}
