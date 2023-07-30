<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccessCodeController extends Controller
{
    public function generate()
    {
        $teacher = auth()->user();

        // Buscar en la tabla de cursos utilizando el id del profesor de la sesión actual
        $course = Course::where('teacher_id', $teacher->id)->first();

        if (!$course) {
            return redirect()->route('teacher_dashboard')->with('error', 'No tienes un curso asignado.');
        }

        // Obtiene el id del profesor
        $teacherId = $teacher->id;

        // Obtiene el id del curso asignado al profesor
        $courseId = $course->id;

        do {
            // Genera un código de acceso aleatorio
            $accessCode = $this->generateRandomCode();

            // Verifica si el código ya existe en la caché
            $existingCode = Cache::get($accessCode);
        } while ($existingCode);

        // Almacena el código de acceso y el id del profesor en la caché durante 30 minutos
        Cache::put($accessCode, ['teacher_id' => $teacherId, 'course_id' => $courseId], 30 * 60);

        // Calcula los minutos restantes
        $expirationMinutes = 30;

        // Muestra la vista con el código de acceso y los minutos restantes
        return view('access_code', compact('accessCode', 'expirationMinutes', 'course'));
    }

    public function generateCourse(Course $course)
    {
        do {
            // Genera un código de acceso aleatorio
            $accessCode = $this->generateRandomCode();

            // Verifica si el código ya existe en la caché
            $existingCode = Cache::get($accessCode);
        } while ($existingCode);

        // Almacena el código de acceso y el id del profesor en la caché durante 30 minutos
        Cache::put($accessCode, ['teacher_id' => $course->teacher_id, 'course_id' => $course->id], 30 * 60);

        // Calcula los minutos restantes
        $expirationMinutes = 30;

        // Muestra la vista con el código de acceso y los minutos restantes
        return view('access_code', compact('accessCode', 'expirationMinutes', 'course'));
    }

    public function generateTeacherCode()
    {
        // Obtiene la clave estática para la asociación de códigos
        $staticKey = 'admin_key';
    
        // Busca un código existente en la caché
        $existingCode = Cache::get($staticKey);
    
        // Si no existe, genera uno nuevo
        if (!$existingCode) {
            do {
                // Genera un código de acceso aleatorio
                $accessCode = $this->generateRandomCode();
    
                // Verifica si el código ya existe en la caché
                $existingCode = Cache::get($accessCode);
            } while ($existingCode);
    
            // Almacena el código de acceso y la clave estática en la caché durante 24 horas
            Cache::put($accessCode, ['key' => $staticKey], 24 * 60 * 60);
    
            // Almacena también la asociación entre la clave estática y el código de acceso
            Cache::put($staticKey, $accessCode, 24 * 60 * 60);
    
            // Almacena el tiempo de expiración
            $expirationTimestamp = time() + 24 * 60 * 60;
            Cache::put($accessCode . "_expiration", $expirationTimestamp, 24 * 60 * 60);
        } else {
            // Si ya existe un código, se usa ese
            $accessCode = $existingCode;
            
            // Obtiene el tiempo de expiración almacenado
            $expirationTimestamp = Cache::get($accessCode . "_expiration");
        }
    
        // Calcula las horas restantes para la expiración
        $expirationHours = round(($expirationTimestamp - time()) / 3600);
    
        // Muestra la vista con el código de acceso y las horas restantes
        return view('access_code_teacher', ['accessCode' => $accessCode, 'expirationHours' => $expirationHours]);
    }
    
    
    private function generateRandomCode()
    {
        // Genera el código de acceso aleatorio
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $accessCode = '';

        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $accessCode .= $characters[$index];
        }

        // Verifica si el código ya existe en la caché
        if (Cache::has($accessCode)) {
            // Genera uno nuevo si el código ya está en uso
            return $this->generateRandomCode();
        }

        return $accessCode;
    }
}
