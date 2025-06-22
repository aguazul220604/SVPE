<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrera;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        $carreras = Carrera::all();
        return view('login', compact('carreras'));
    }

    // Procesar el login
    public function login(Request $request)
    {
        // Validación de campos con los nombres correctos
        $request->validate([
            'Correo' => 'required|email',
            'Contrasena' => 'required|string',
        ]);

        // Intentar autenticación usando los campos personalizados
        $credentials = [
            'Correo' => $request->Correo,
            'password' => $request->Contrasena,
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/proyectos');
        }else {
            dd('Falló el login'); // 👈 Esto te mostrará si fallan las credenciales
        }

        return back()->withErrors([
            'Correo' => 'Credenciales incorrectas',
        ]);
    }
    
    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Sobrescribir el campo que Laravel usa para login
    public function username()
    {
        return 'Correo';
    }
}
