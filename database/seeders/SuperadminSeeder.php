<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('superadmin')->insert(
            [
            'name' => 'Administrador',
            'surname' => 'De confianza',
            'dni' => '47523697Q',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Adminadmin1.'),
            'created_at' => now(),
            'updated_at' => now()
            ]);
    }

}
