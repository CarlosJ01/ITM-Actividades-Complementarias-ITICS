<?php

use App\Models\Usuario;
use App\Models\SGE\ProyectoDocencia;
use App\Models\SGE\ResponsableActividadComplementaria;
use App\Models\SGE\ServicioSocialEscolares;
use App\Models\SGE\Alumno;
use App\Models\ExpedienteCreditos\ActividadRegistrada;
use App\Models\CreditosComplementarios\RubricaEvaluacion;
use App\Models\ExpedienteCreditos\Expediente;
use App\Models\CreditosComplementarios\CreditoComplementario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Arreglo de nombres y apellido */
        $nombres = ['Juan', 'Jose Luis', 'Jose', 'Maria Guadalupe', 'Francisco', 'Guadalupe', 'Maria', 'Juana',
                    'Antonio', 'Jesus', 'Miguel Angel', 'Pedro', 'Alejandro', 'Manuel', 'Margarita', 
                    'Maria del Carmen', 'Juan Carlos', 'Roberto', 'Fernando', 'Daniel', 'Carlos', 'Jorge',
                    'Ricardo', 'Miguel', 'Eduardo', 'Yahir'];
        $apelidos = ['Hernandez', 'Garcia', 'Martines', 'Lopez', 'Gonzales', 'Perez', 'Rodriguez',
                    'Sanchez', 'Ramirez', 'Cruz', 'Flores', 'Gomez', 'Castro', 'Cazares', ' '];
        
        /* Usuarios de Proyecto Docencia */
        $numeroControl = 17121000;
        echo 'Usuarios de Proyecto Docencia'.PHP_EOL;
        for ($i=1; $i <= 10; $i++) { 
            ProyectoDocencia::create([
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'id_usuario' => Usuario::create(['usuario' => 'PD'.$numeroControl, 'password' => bcrypt('PD'.$numeroControl)])->id,
                'id_departamento' => $i
            ]);
            echo 'PD'.$numeroControl.PHP_EOL;
            $numeroControl++;
        }

        /* Responsable de actividades complementarias */
        $numeroControl = 17121000;
        echo 'Usuarios de Responsable de Actividad Complementarias'.PHP_EOL;
        for ($i=0; $i < 100; $i++) {
            ResponsableActividadComplementaria::create([
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'id_usuario' => Usuario::create(['usuario' => 'RA'.$numeroControl, 'password' => bcrypt('RA'.$numeroControl)])->id,
                'id_departamento' => rand(1, 10)
            ]);
            echo 'RA'.$numeroControl.PHP_EOL;
            $numeroControl++;
        }

        /* Jefes de servicios escolares o servicio social */
        echo 'Usuarios Jefes de servicio social y escolares'.PHP_EOL;
        echo 'SE17121000'.PHP_EOL;
        ServicioSocialEscolares::create([
            'nombre' => $nombres[array_rand($nombres)],
            'apellido_paterno' => $apelidos[array_rand($apelidos)],
            'apellido_materno' => $apelidos[array_rand($apelidos)],
            'id_usuario' => Usuario::create(['usuario' => 'SE17120151', 'password' => bcrypt('SE17120151')])->id
        ]);
        
        /* Alumnos */
        echo 'Usuarios de Alumnos'.PHP_EOL;
        Alumno::create([
            'no_de_control' => '17120151',
            'nombre' => 'Carlos Jahir',
            'apellido_paterno' => 'Castro',
            'apellido_materno' => 'Cazares',
            'semestre' => '8',
            'id_usuario' => Usuario::create(['usuario' => '17120151', 'password' => bcrypt('17120151')])->id,
            'id_carrera' => '11'
        ]);
        echo '17120151'.PHP_EOL;

        Alumno::create([
            'no_de_control' => '17120182',
            'nombre' => 'Giovanni Hasid',
            'apellido_paterno' => 'Martínez',
            'apellido_materno' => 'Reséndiz',
            'semestre' => '8',
            'id_usuario' => Usuario::create(['usuario' => '17120182', 'password' => bcrypt('17120182')])->id,
            'id_carrera' => '11'
        ]);
        echo '17120182'.PHP_EOL;
        
        $numeroControl = 17121000;
        $archivos = [
            'https://drive.google.com/file/d/1O_RyZLW1akQ1QechKPi7kVgFPEgV69f3/view?usp=sharing',
            'https://drive.google.com/file/d/1k3Es6bog4X51QeVaOSa2k9f9DMx6UO7Q/view?usp=sharing',
            'https://drive.google.com/file/d/1tEVSOVMf_bCo6iBppWX9ZmAIkweyJtW5/view?usp=sharing',
            'https://drive.google.com/file/d/1cXldXlTrD-W6DKaJ9dpOTz1tE82o-npW/view?usp=sharing',
            'https://drive.google.com/file/d/1l6AvlfvtEWdEkTZFZe8CzE67y60YhRtJ/view?usp=sharing'
        ];
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '1';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 100)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '2';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '3';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '4';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '5';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '6';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '7';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '8';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '9';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '10';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 120; $i++, $numeroControl++) {
            $carrera = '11';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
        for ($i = 0; $i < 80; $i++, $numeroControl++) {
            $carrera = '12';
            $alumno = Alumno::create([
                'no_de_control' => $numeroControl,
                'nombre' => $nombres[array_rand($nombres)],
                'apellido_paterno' => $apelidos[array_rand($apelidos)],
                'apellido_materno' => $apelidos[array_rand($apelidos)],
                'semestre' => rand(1, 7),
                'id_usuario' => Usuario::create(['usuario' => $numeroControl, 'password' => bcrypt($numeroControl)])->id,
                'id_carrera' => $carrera
            ]);
            if ($i >= 10) {
                $expediente = Expediente::create([
                    'no_de_control' => $numeroControl,
                    'fecha_apertura' => date('Y-m-d'),
                    'id_periodo' => '1'
                ]);
                $noCreditos = rand(0, 5);
                if ($noCreditos != 0) {
                    $idCreditos = CreditoComplementario::select('id')->where('valor', '<>', '0')->where('id_departamento', $alumno->carrera->departamento->id)->get();
                    $creditos = [];
                    foreach ($idCreditos as $idCredito) {
                        $creditos[] = $idCredito->id;
                    }
                    for ($j=0; $j < $noCreditos; $j++) {
                        ActividadRegistrada::create([
                            'no_de_control' => $numeroControl,
                            'id_credito_complementario' => $creditos[array_rand($creditos)],
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_fin' => date('Y-m-d' , strtotime('+7 day', strtotime(date('Y-m-d')))),
                            'enlace_evidencia' => $archivos[array_rand($archivos)],
                            'id_rubrica_evaluacion_credito' => RubricaEvaluacion::create(['id_responsable' => rand(1, 30)])->id,
                            'comentario' => 'Enviado a ser revisado por el responsable de la actividad complementaria',
                            'id_periodo' => '1'
                        ]);
                    }
                }
            }            
            echo $numeroControl.PHP_EOL;
        }
    }
}
