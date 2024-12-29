<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('todos')->insert([
            [
                'title'        => 'Complete project documentation',
                'description'  => 'Prepare and complete all necessary project documentation.',
                'status'       => 'Pending',
                'order'        => 1,
                'color'        => '#FF5733',
                'due_date'     => Carbon::now()->addDays(7),
                'completed_at' => null,
                'created_by'   => 1, // Replace it with a valid user ID
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'title'        => 'Fix bugs in the application',
                'description'  => 'Identify and fix critical bugs reported by QA team.',
                'status'       => 'In Progress',
                'order'        => 2,
                'color'        => '#33FF57',
                'due_date'     => Carbon::now()->addDays(3),
                'completed_at' => null,
                'created_by'   => 1, // Replace it with a valid user ID
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'title'        => 'Prepare for team meeting',
                'description'  => 'Create an agenda and gather materials for the weekly team meeting.',
                'status'       => 'Completed',
                'order'        => 3,
                'color'        => '#3357FF',
                'due_date'     => Carbon::now()->subDays(1),
                'completed_at' => Carbon::now()->subDays(1),
                'created_by'   => 1, // Replace it with a valid user ID
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ]);
    }
}
