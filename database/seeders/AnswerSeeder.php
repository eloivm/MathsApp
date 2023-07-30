<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        for ($question_id = 247; $question_id <= 396; $question_id++) {
            $answers[] = [
                'content' => '5',
                'is_correct' => true,
                'question_id' => $question_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        DB::table('answers')->insert($answers);
        
        foreach ($answers as $answer) {
            $answer['created_at'] = now();
            $answer['updated_at'] = now();
            DB::table('answers')->insert($answer);
        }
    }
}
