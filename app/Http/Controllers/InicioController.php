<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

use Illuminate\Http\Request;

class InicioController extends Controller{
    /* Vistas del inicio y  login */
    public function inicio(){
        return view('inicio');
    }
    public function loginAdminsitrativo(){
        return view('loginAdminsitrativo');
    }
    public function loginAlumno(){
        return view('loginAlumno');
    }

    /* Obtener usuarios */
    public function getUsuarios() {
        /* Extraer datos de los usuarios */
        $usuarios = Usuario::all();
        $usuariosDocencia = [];
        $usuariosResponsable = [];
        $usuariosSocialEscolares = [];
        $usuariosAlumno = [];
        foreach ($usuarios as $usuario) {
            switch ($usuario->tipoUsuario()) {
                case 'D':
                    $usuariosDocencia[] = $usuario;
                    break;
                case 'R':
                    $usuariosResponsable[] = $usuario;
                    break;
                case 'SE':
                    $usuariosSocialEscolares[] = $usuario;
                    break;
                case 'A':
                    $usuariosAlumno[] = $usuario;
                    break;
            }
        }

        $file = "datos-usuarios.csv";
        $handle = fopen($file, 'w+');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        /* Usuarios de docencia */
        fputcsv($handle, array('Usuarios de proyecto docencia'));
        fputcsv($handle, array('Usuario', 'Contraseña', 'Nombre Completo', 'Departamento'));
        foreach ($usuariosDocencia as $usuario) {
            fputcsv(
                $handle, 
                array(
                    $usuario->usuario, 
                    $usuario->usuario, 
                    $usuario->proyectoDocencia->nombre.' '.$usuario->proyectoDocencia->apellido_paterno.' '.$usuario->proyectoDocencia->apellido_materno,
                    $usuario->proyectoDocencia->departamento->nombre
                )
            );
            
        }
        fputcsv($handle, array(''));

        /* Usuarios responsables de actividades complementarias */
        fputcsv($handle, array('Usuarios responsables de actividades complementarias'));
        fputcsv($handle, array('Usuario', 'Contraseña', 'Nombre Completo', 'Departamento'));
        foreach ($usuariosResponsable as $usuario) {
            fputcsv(
                $handle, 
                array(
                    $usuario->usuario, 
                    $usuario->usuario, 
                    $usuario->responsableActividad->nombre.' '.$usuario->responsableActividad->apellido_paterno.' '.$usuario->responsableActividad->apellido_materno,
                    $usuario->responsableActividad->departamento->nombre
                )
            );
            
        }
        fputcsv($handle, array(''));

        /* Usuarios jefes de servicios escolares o servicio social */
        fputcsv($handle, array('Usuarios jefes de servicio social o escolares'));
        fputcsv($handle, array('Usuario', 'Contraseña', 'Nombre Completo'));
        foreach ($usuariosSocialEscolares as $usuario) {
            fputcsv(
                $handle, 
                array(
                    $usuario->usuario, 
                    $usuario->usuario, 
                    $usuario->socialEscolares->nombre.' '.$usuario->socialEscolares->apellido_paterno.' '.$usuario->socialEscolares->apellido_materno
                )
            );
            
        }
        fputcsv($handle, array(''));

        /* Usuarios de alumnos */
        fputcsv($handle, array('Usuarios de alumnos'));
        fputcsv($handle, array('Usuario', 'Contraseña', 'Nombre Completo', 'Carrera', 'Expediente', 'Actividades subidas'));
        foreach ($usuariosAlumno as $usuario) {
            fputcsv(
                $handle, 
                array(
                    $usuario->usuario, 
                    $usuario->usuario, 
                    $usuario->alumno->nombre.' '.$usuario->alumno->apellido_paterno.' '.$usuario->alumno->apellido_materno,
                    $usuario->alumno->carrera->nombre,
                    $usuario->alumno->expedienteCreditos ? 'Abierto' : 'Sin Expediente',
                    $usuario->alumno->expedienteCreditos ? count($usuario->alumno->expedienteCreditos->actividadesRegistradas) : 0,
                )
            );
            
        }
        fputcsv($handle, array(''));

        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download($file, 'datos-usuarios-prueba.csv', $headers)->deleteFileAfterSend($shouldDelete = true);
    }
}
