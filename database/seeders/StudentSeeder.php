<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'name' => 'Victoria',
                'surname' => 'Alonso Perez',
                'dob' => Carbon::createFromDate(2000, 5, 15),
                'course_id' => 5,
                'repeated_grade' => false,
                'repeated_courses' => Null,
                'nationality' => 'spanish',
                'origin' => Null,
                'arrival_date' => Null,
                'email' => 'vivi@gmail.com',
                'password' => Hash::make('Vivivivi1.'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'María Andrea',
                'surname' => 'Ugarte Valencia',
                'dob' => Carbon::createFromDate(2001, 12, 20),
                'course_id' => 7,
                'repeated_grade' => true,
                'repeated_courses' => '1, 2',
                'nationality' => 'spanish',
                'origin' => Null,
                'arrival_date' => Null,
                'email' => 'andrea@gmail.com',
                'password' => Hash::make('Andrea12'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ali',
                'surname' => 'Sambade Mata',
                'dob' => Carbon::createFromDate(2001, 7, 5),
                'course_id' => 7,
                'repeated_grade' => false,
                'repeated_courses' => Null,
                'nationality' => 'other',
                'origin' => 'Francia',
                'arrival_date' => Carbon::createFromDate(2012, 3, 20),
                'email' => 'ali@gmail.com',
                'password' => Hash::make('Alicia..'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Misgraylin',
                'surname' => 'Quilarque Mejías',
                'dob' => Carbon::createFromDate(2001, 9, 18),
                'course_id' => 5,
                'repeated_grade' => true,
                'repeated_courses' => '1, 3',
                'nationality' => 'other',
                'origin' => 'Canadá',
                'arrival_date' => Carbon::createFromDate(2010, 10, 25),
                'email' => 'misgra@gmail.com',
                'password' => Hash::make('Misgra1.'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($students as $student) {
            DB::table('students')->insert($student);
        }
    }
};
