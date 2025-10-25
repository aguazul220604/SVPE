<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Institucion;


class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        $instituciones = Institucion::all();
        return view('login', compact('instituciones'));
    }
    

    // Procesar el login
    public function login(Request $request)
    {
            $request->validate([
            'correo_institucional' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        $credentials = $request->only('correo_institucional', 'contrasena');

        if (Auth::attempt([
            'correo_institucional' => $credentials['correo_institucional'],
            'password' => $credentials['contrasena'], // Laravel buscará getAuthPassword()
        ])) {
            return redirect()->intended('/proyectos'); 
        }

    }
    public function getAuthPassword()
    {
        return $this->contrasena;
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
        return 'correo_institucional';
    }
}
