<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /* Vistas */
    // Vista para administrar los usuarios
    public function index() {
        /* Extraer todos los usuarios */
        $usuarios = Usuario::where('id', '!=', Auth::user()->id)->orderBy('usuario')->get();

        /* Formatear los datos */
        foreach ($usuarios as $usuario) {
            /* Tipo de usuario y nombre del usuario */
            switch ($usuario->tipoUsuario()) {
                case 'D':
                    $usuario->tipo = 'Docencia';
                    $usuario->nombre = $usuario->proyectoDocencia->nombre.' '.$usuario->proyectoDocencia->apellido_paterno;
                    break;
                case 'R':
                    $usuario->tipo = 'Responsable';
                    $usuario->nombre = $usuario->responsableActividad->nombre.' '.$usuario->responsableActividad->apellido_paterno;
                    break;
                case 'SE':
                    $usuario->tipo = 'Social o Escolares';
                    $usuario->nombre = $usuario->socialEscolares->nombre.' '.$usuario->socialEscolares->apellido_paterno;
                    break;
                case 'A':
                        $usuario->tipo = 'Alumno';
                        $usuario->nombre = $usuario->alumno->nombre.' '.$usuario->alumno->apellido_paterno;
                    break;
            }
        }
        return view('proyectoDocencia.usuarios.index', compact('usuarios'));
    }

    /* Vista para cambiar contraseña */
    public function changePassword() {
        $usuario = Auth::user();
        $tipo = "";
        switch ($usuario->tipoUsuario()) {
            case 'D':
                $tipo = 'docencia';
                break;
            case 'R':
                $tipo = 'responsable';
                break;
            case 'SE':
                $tipo = 'socialEscolares';
                break;
            case 'A':
                $tipo = 'alumno';
                break;
        }
        return view('changePassword')->with(['usuario' => $usuario, 'tipo' => $tipo]);
    }

    /* Acciones */
    /* Cambiar contraseña */
    public function updatePassword(Request $request) {

        $rules = [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:6|max:32|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.-_@$!%*?&])[A-Za-z\d.-_@$!%*?&]{6,}$"',
            'new_confirm_password' => ['same:new_password'],
        ];

        $messages = [
            'new_password.regex' => 'La contreña debe tener al menos ocho caracteres, una letra mayuscula, un número y un caracter especial',
            'current_password.required' => 'La contraseña anterior es requerida',
            'new_password.min' =>'La contraseña debe tener al menos :min caracteres',
            'new_password.required' => 'La nueva contraseña es requerida',
            'new_confirm_password.same' => 'La nueva contraseña no coincide'
        ];

        //La contreña debe tener al menos ocho caracteres, una letra mayuscula, un número y un caracter especial.
        $this->validate($request, $rules, $messages);

        Usuario::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        $usuario = Auth::user();
        $inicio = "";
        switch ($usuario->tipoUsuario()) {
            case 'D':
                $inicio = 'inicio.docencia';
                break;
            case 'R':
                $inicio = 'inicio.responsable';
                break;
            case 'SE':
                $inicio = 'inicio.socialEscolares';
                break;
            case 'A':
                $inicio = 'inicio.alumno';
                break;
        }
        return redirect()->route($inicio)->with('mensaje', 'La contraseña se ha cambiado correctamente');
    }
    /* Restaurar las contraseñas de default */
    public function restorePassword(Request $request) {
        $this->validate(request(), [
            'usuario' => 'required|numeric'
        ]);

        $usuario = Usuario::find($request->usuario);
        $usuario->update([
            'password'=> Hash::make($usuario->default)
        ]);
        return redirect()->back()->with('mensaje', 'La contraseña default se restauro para el usuario '.$usuario->usuario);
    }
}
