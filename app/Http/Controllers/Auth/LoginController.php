<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth; 

class LoginController extends Controller {

    public function loginAdministrativo() {
        /* Validaciones */
        $request = $this->validate(request(), [
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);
        /* Login */
        if (Auth::attempt($request)) {
            switch (Auth::user()->tipoUsuario()) {
                case 'R':
                    return redirect()->route('inicio.responsable');
                    break;
                case 'D':
                    return redirect()->route('inicio.docencia');
                    break;
                case 'SE':
                    return redirect()->route('inicio.socialEscolares');
                    break;
                case 'A':
                    Auth::logout();
                    return redirect()->back()->withErrors(['usuario' => trans('auth.failed')])
                                ->withInput(['usuario' => $request['usuario']]);
                    break;
                default:
                    $this->logout();
                    break;
            }
        }
        /* Redireccion si no es un usuario */
        return redirect()->back()->withErrors(['usuario' => trans('auth.failed')])
                                ->withInput(['usuario' => $request['usuario']]);   
    }

    public function loginAlumno() {
        /* Validaciones */
        $request = $this->validate(request(), [
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);

        /* Login */
        if (Auth::attempt($request)) {
            switch (Auth::user()->tipoUsuario()) {
                case 'A':
                    return redirect()->route('inicio.alumno');
                    break;
                case 'R':
                case 'D':
                    Auth::logout();
                    return redirect()->back()->withErrors(['usuario' => trans('auth.failed')])
                                ->withInput(['usuario' => $request['usuario']]);
                    break;
                default:
                    $this->logout();
                    break;
            }
        }

        /* Redireccion si no es un usuario */
        return redirect()->back()->withErrors(['usuario' => trans('auth.failed')])
                                ->withInput(['usuario' => $request['usuario']]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
