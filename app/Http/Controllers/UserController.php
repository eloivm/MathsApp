<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Superadmin;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('change_password');
    }

    /**
     * Handle the password change.
     */
    public function changePassword(Request $request)
    {
        // Validate the form data
        $request->validate([
            'old_password'     => 'required',
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // Get authenticated user
        $user = null;

        // If the user type is Teacher
        if (Auth::guard('teacher')->check()) {
            $user = Teacher::find(Auth::guard('teacher')->id());
        }
        // If the user type is Student
        else if (Auth::guard('superadmin')->check()) {
            $user = Superadmin::find(Auth::guard('superadmin')->id());
        }
        else if (Auth::guard('student')->check()) {
            $user = Student::find(Auth::guard('student')->id());
        }


        // If the user type is either Teacher or Student
        if ($user) {
            // Check the old password
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'La contraseña actual es incorrecta']);
            }

            // Change the password
            $user->password = Hash::make($request->new_password);
            $user->save();

            // Redirect with success message
            if ($user instanceof Teacher) {
                return redirect()->route('teacher_dashboard')->with('success', 'La contraseña ha sido cambiada exitosamente!');
            } else if ($user instanceof Student) {
                return redirect()->route('student_dashboard')->with('success', 'La contraseña ha sido cambiada exitosamente!');
            }
            else if ($user instanceof Superadmin) {
                return redirect()->route('superadmin_dashboard')->with('success', 'La contraseña ha sido cambiada exitosamente!');
            }
        } else {
            // Error handling
            return back()->withErrors(['user' => 'Usuario no encontrado']);
        }
    }
}
