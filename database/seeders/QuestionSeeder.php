<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            "Fracciones",
            "Múltiplos y divisores",
            "Números enteros y orden de operaciones",
            "Porcentajes",
            "Potencias",
            "Problemas",
        ];

        $levels = [5, 6, 2, 3, 4];

        foreach ($levels as $level) {
            $levelLabel = ($level === 5 || $level === 6) ? 'Primaria' : 'ESO';

            $questions = [];

            // Números enteros y orden de operaciones
            for ($i = 0; $i < 5; $i++) {
                $questions[] = [
                    'enunciation' => 'Pregunta de ejemplo ' . ($i + 1) . ' nivel ' . $level . 'º ' . $levelLabel . ' categoría Números enteros y orden de operaciones',
                    'course' => $level,
                    'topic' => $categories[0],
                    'type' => 'short_answer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Números enteros y orden de operaciones
            for ($i = 0; $i < 5; $i++) {
                $questions[] = [
                    'enunciation' => 'Pregunta de ejemplo ' . ($i + 1) . ' nivel ' . $level . 'º ' . $levelLabel . ' categoría Números enteros y orden de operaciones',
                    'course' => $level,
                    'topic' => $categories[2],
                    'type' => 'short_answer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Múltiplos y divisores
            for ($i = 0; $i < 5; $i++) {
                $questions[] = [
                    'enunciation' => 'Pregunta de ejemplo ' . ($i + 1) . ' nivel ' . $level . 'º ' . $levelLabel . ' categoría Múltiplos y divisores',
                    'course' => $level,
                    'topic' => $categories[1],
                    'type' => 'short_answer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Porcentajes
            for ($i = 0; $i < 3; $i++) {
                $questions[] = [
                    'enunciation' => 'Pregunta de ejemplo ' . ($i + 1) . ' nivel ' . $level . 'º ' . $levelLabel . ' categoría Porcentajes',
                    'course' => $level,
                    'topic' => $categories[3],
                    'type' => 'short_answer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Potencias
            for ($i = 0; $i < 6; $i++) {
                $questions[] = [
                    'enunciation' => 'Pregunta de ejemplo ' . ($i + 1) . ' nivel ' . $level . 'º ' . $levelLabel . ' categoría Potencias',
                    'course' => $level,
                    'topic' => $categories[4],
                    'type' => 'short_answer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Problemas
            for ($i = 0; $i < 6; $i++) {
                $questions[] = [
                    'enunciation' => 'Pregunta de ejemplo ' . ($i + 1) . ' nivel ' . $level . 'º ' . $levelLabel . ' categoría Problemas',
                    'course' => $level,
                    'topic' => $categories[5],
                    'type' => 'short_answer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach ($questions as $question) {
                DB::table('questions')->insert($question);
            }
        }
    }
}
