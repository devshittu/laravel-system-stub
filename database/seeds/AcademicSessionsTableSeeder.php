<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicSessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("

            INSERT INTO `academic_sessions` (`id`, `title`, `code_name`) VALUES
            (1, '2016-2017', '2016/17'),
            (2, '2017-2018', '2017/18'),
            (3, '2018-2019', '2018/19');
        ");
    }
}
