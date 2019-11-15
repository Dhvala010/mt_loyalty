<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sqlPath = database_path('sqls/country.sql');
        $fileBuffer = File::get($sqlPath);
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::connection()->getPdo()->exec($fileBuffer);
        } catch (\Exception $exception) {
            dump($exception->getMessage());
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
