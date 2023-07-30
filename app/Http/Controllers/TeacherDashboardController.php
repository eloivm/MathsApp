<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function show()
    {
        return view('teacher_dashboard');
    }
}
