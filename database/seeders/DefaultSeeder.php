<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jobs_owl')->truncate();
        DB::table('recent_activity')->truncate();
        DB::table('expenses')->truncate();
        DB::table('debt')->truncate();
    }
}
