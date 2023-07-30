<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Superadmin;
use App\Rules\DniRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller
{
    public function index()
    {
        return view('principal_dashboard');
    }

    public function profile()
    {
        return view('principal_profile');
    }

    public function edit($id)
    {
        $superadmin = Superadmin::findOrFail($id);

        return view('edit_principal', compact('superadmin'));
    }

    public function update(Request $request, $id)
    {
        $superadmin = Superadmin::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'dni' => ['required', 'max:9', 'unique:teachers', new DniRule],
            'email' => 'required|email',
            'password' => 'nullable|confirmed',
        ]);
        

        $superadmin->update($validatedData);

        return redirect()->route('principal.profile', $superadmin->id)->with('success', 'Perfil actualizado correctamente');
    }

    // Método para mostrar la vista de transferencia de cuenta
public function transferAccount()
{
    return view('transfer');
}

// Método para transferir la cuenta a otro superadmin
public function transferAccountTo(Request $request)
{
    // Validar los datos ingresados (email, dni, contraseña, confirmación)
    $validatedData = $request->validate([
        'email' => 'required|email',
        'dni' => ['required', 'max:9', 'unique:superadmin', new DniRule],
        'password' => 'required|confirmed',
    ]);

    // Crear un nuevo Superadmin con los datos proporcionados
    $newSuperadmin = Superadmin::create([
        'name' => 'Administrador',
        'surname' => 'Tranferido',
        'dni' => $validatedData['dni'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Obtener el ID del superadmin actual
    $superadminId = Auth::guard('superadmin')->id();

    // Eliminar el superadmin actual utilizando una consulta de SQL
    DB::delete('DELETE FROM superadmin WHERE id = ?', [$superadminId]);

    // Redireccionar a la página de bienvenida o mostrar un mensaje de éxito
    return redirect()->route('login')->with('success', '¡La cuenta se ha transferido exitosamente!');
}


}
