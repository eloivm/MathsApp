<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('courses')->insert([
            [
                'grade' => 1,
                'class_letter' => 'A',
                'description' => 'Curso 1A',
                'teacher_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grade' => 1,
                'class_letter' => 'B',
                'description' => 'Curso 1B',
                'teacher_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grade' => 1,
                'class_letter' => 'C',
                'description' => 'Curso 1C',
                'teacher_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grade' => 2,
                'class_letter' => 'A',
                'description' => 'Curso 2A',
                'teacher_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grade' => 2,
                'class_letter' => 'B',
                'description' => 'Curso 2B',
                'teacher_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grade' => 3,
                'class_letter' => 'A',
                'description' => 'Curso 3A',
                'teacher_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grade' => 4,
                'class_letter' => 'C',
                'description' => 'Curso 4C',
                'teacher_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'grade' => 4,
                'class_letter' => 'H',
                'description' => 'Curso 4H',
                'teacher_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
