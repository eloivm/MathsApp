<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{

    public function run()
    {
        DB::table('teachers')->insert([
            [
            'name' => 'Elisa',
            'surname' => 'Pazos Soto',
            'dni' => '40830079L',
            'department' => 'Arquitectura',
            'email' => 'elisa@gmail.com',
            'password' => Hash::make('Elisalisa1.'),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Miranda',
            'surname' => 'Carou Laíño',
            'dni' => '25067544M',
            'department' => 'Repostería',
            'email' => 'miranda@gmail.com',
            'password' => Hash::make('Mirandaanda1.'),
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
    }
}
