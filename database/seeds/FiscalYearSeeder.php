<?php

use Illuminate\Database\Seeder;

class FiscalYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . '/database/mst_fiscal_year.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        DB::table('mst_fiscal_year')->insert($data);
    }
}
