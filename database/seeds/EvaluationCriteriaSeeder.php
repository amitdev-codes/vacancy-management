<?php

use Illuminate\Database\Seeder;

class EvaluationCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . '/database/mst_evaluation_criteria.json';
        $file = File::get($path);
        $data = json_decode($file, true);

        DB::table('mst_evaluation_criteria')->insert($data);
    }
}
