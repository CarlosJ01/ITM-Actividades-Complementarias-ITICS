<?php

use App\Models\SGE\ProyectoDocencia;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ITICSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder para la implementacion en el departamento de ITICS
     * @return void
     */
    
    public function run() {
        /* Actividades complementarias para el departamento de ITICS */
        echo 'Catalogo de Actividades Complementarias . . .'.PHP_EOL;
        $i = 11;
        DB::table('credito_complementario')->insert([
            ['numero' => '1', 'valor' => '1', 'descripcion' => 'Asistir a un Congreso', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '2', 'valor' => '0', 'descripcion' => 'Participar activamente en un Evento Académico', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '2.1', 'valor' => '1', 'descripcion' => 'Como Organizador', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '2.2', 'valor' => '2', 'descripcion' => 'Como Ponente, Conferencista o en la exposición de carteles', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '3', 'valor' => '1', 'descripcion' => 'Asesorar un Curso Académico Institucional', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '4', 'valor' => '2', 'descripcion' => 'Realizar una estancia Técnico-Científico (evento corto)', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '5', 'valor' => '0', 'descripcion' => 'Asistir a un Curso o un Taller de mínimo 20 horas', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '5.1', 'valor' => '1', 'descripcion' => 'MOOC del TNM', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => false], //Inactivo
            ['numero' => '5.2', 'valor' => '1', 'descripcion' => 'Curso o Taller en general', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => false],
            ['numero' => '6', 'valor' => '1', 'descripcion' => 'Aprobar, dentro de un Programa de Diplomado en su Área de Conocimiento con duración de 120 hrs, un módulo de mínimo 30 hrs.', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '7', 'valor' => '2', 'descripcion' => 'Impartir un Curso Extracurricular de mínimo de 20 hrs.', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '8', 'valor' => '0', 'descripcion' => 'Participar en Concursos/Eventos organizados por TecNM', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '8.1', 'valor' => '1', 'descripcion' => 'Regional', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '8.2', 'valor' => '2', 'descripcion' => 'Nacional', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '9', 'valor' => '0', 'descripcion' => 'Elaborar un Prototipo de su Área de Conocimiento', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '9.1', 'valor' => '1', 'descripcion' => 'Didáctico', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '9.2', 'valor' => '2', 'descripcion' => 'Industrial', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '9.3', 'valor' => '2', 'descripcion' => 'Con Solicitud de Patente', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '10', 'valor' => '0', 'descripcion' => 'Participar en un Proyecto de Investigación Registrad', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '10.1', 'valor' => '2', 'descripcion' => 'de Nivel Licenciatura', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '10.2', 'valor' => '2', 'descripcion' => 'de Nivel Maestría', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '10.3', 'valor' => '2', 'descripcion' => 'de Nivel Doctorado', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '11', 'valor' => '0', 'descripcion' => 'Realizar Difusión Científica en Publicaciones', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '11.1', 'valor' => '2', 'descripcion' => 'No indexada', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '11.2', 'valor' => '2', 'descripcion' => 'Indexada', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '12', 'valor' => '2', 'descripcion' => 'Obtener una Certificación propia de su ámbito laboral', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '13', 'valor' => '1', 'descripcion' => 'Participa en Actividades Extraescolares, culturales o deportivas, durante mínimo un periodo', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '14', 'valor' => '0', 'descripcion' => 'Participación en Eventos de Gestión Tecnológica y Vinculación', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '14.1', 'valor' => '1', 'descripcion' => 'Impulsa', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '14.2', 'valor' => '1', 'descripcion' => 'Finanzas para Emprender y Crecer (BBVA) 20 hrs', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '14.3', 'valor' => '1', 'descripcion' => 'Talento Emprendedor', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '14.4', 'valor' => '1', 'descripcion' => 'Programa Verano Científico de la Investigación (AMC, DELFIN) hasta el 5º Semestre, después será para Residencias Profesionales', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '15', 'valor' => '0', 'descripcion' => 'Ciclo de Conferencias Organizadas por CEIT', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '15.1', 'valor' => '1', 'descripcion' => '8 ponencias genéricas supervisadas por Jefes Departamentales al semestre', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '16', 'valor' => '0', 'descripcion' => 'Participación en Actividades de Desarrollo Académico', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '16.1', 'valor' => '1', 'descripcion' => 'Tutoría Presencial solo en PRIMER Semestre', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '16.2', 'valor' => '1', 'descripcion' => 'Participación en aplicación EXANII II y Asistencia Conferencia Magistral', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '17', 'valor' => '0', 'descripcion' => 'Participación en Actividades de Ingeniería Bioquímica', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '17.1', 'valor' => '1', 'descripcion' => 'Concurso de Prácticas de Laboratorio (Primer Lugar)', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '17.2', 'valor' => '1', 'descripcion' => 'Curso de Análisis Proximal de 30 hrs', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '17.3', 'valor' => '1', 'descripcion' => 'Curso de Habilidades Gerenciales de 20 hrs', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '18', 'valor' => '0', 'descripcion' => 'Participación en Actividades de Ingeniería en Materiales', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '18.1', 'valor' => '1', 'descripcion' => 'Jornadas Académicas', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '18.2', 'valor' => '1', 'descripcion' => 'Expositor en Círculos de Estudio', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '19', 'valor' => '0', 'descripcion' => 'Participación en Actividades de Ingeniería y Computación', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '19.1', 'valor' => '1', 'descripcion' => 'Asesor de Círculos de Estudio', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '19.2', 'valor' => '1', 'descripcion' => 'Asistente de Laboratorio', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '20', 'valor' => '0', 'descripcion' => 'Participación en Actividades de Ciencias Básicas', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '20.1', 'valor' => '1', 'descripcion' => 'Concurso de Ciencias Básicas', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '20.2', 'valor' => '1', 'descripcion' => 'En fase local los diez primeros clasificados de TECnM', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21', 'valor' => '0', 'descripcion' => 'Participación en Actividades de Ingeniería Industrial', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.1', 'valor' => '1', 'descripcion' => 'Concurso de Taller Herramientas Lean', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.2', 'valor' => '1', 'descripcion' => 'Certificación Six Sigma Green Belt', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.3', 'valor' => '1', 'descripcion' => 'Primeros Auxilios y Combate contra Incendios', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.4', 'valor' => '1', 'descripcion' => 'Solución de Problemas de Ingeniería en Excel', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.5', 'valor' => '1', 'descripcion' => 'Manejo de Riesgos', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.6', 'valor' => '1', 'descripcion' => 'Habilidades Directivas para Ingenieros', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.7', 'valor' => '1', 'descripcion' => 'Taller Haciendo Competitivas a las Micro y Pequeñas Empresas', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '21.8', 'valor' => '1', 'descripcion' => 'Cátedral INEGI', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '22', 'valor' => '0', 'descripcion' => 'Participación en Actividades para el Sistema No Escolarizado', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '22.1', 'valor' => '1', 'descripcion' => 'Ciclo de Conferencias ex profeso', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '22.2', 'valor' => '2', 'descripcion' => 'Constancia de experiencia laboral por 2 años en área de formación', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '22.3', 'valor' => '2', 'descripcion' => 'Asistencia a Conferencias con Memoria de Evento', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '22.4', 'valor' => '1', 'descripcion' => 'En fase local los diez primeros clasificados de TecNM', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '23', 'valor' => '0', 'descripcion' => 'Participación en Actividades para Ingeniería Electrónica e Ingeniería Mecánica', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '23.1', 'valor' => '1', 'descripcion' => 'Concurso de Robótica', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '24', 'valor' => '0', 'descripcion' => 'Participación en Actividades para Ingeniería en Gestión Empresarial', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '24.1', 'valor' => '1', 'descripcion' => 'Brigada de Seguridad', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
            ['numero' => '25', 'valor' => '1', 'descripcion' => 'Participación en Comité de Contraloría Social de la Beca de Manutención', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true]
        ]);

        /* Usuarios Proyecto Docencia */
        echo 'Usuarios de Proyecto Docencia . . .'.PHP_EOL;
        ProyectoDocencia::create([
            'nombre' => 'Aurelio Amaury',
            'apellido_paterno' => 'Coria',
            'apellido_materno' => 'Ramirez',
            'id_usuario' => Usuario::create(['usuario' => 'CORA750528GK6', 'password' => bcrypt($p='CORA750528GK6'), 'default' =>$p])->id,
            'id_departamento' => 11
        ]);

        /* Usuarios Servidores Sociales */
        DB::table('proyecto_docencia')->insert([
            [
                'nombre' => 'Servidor Social',
                'apellido_paterno' => 'ITIC',
                'apellido_materno' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120000', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_departamento' => 11
            ],
            [
                'nombre' => 'Servidor Social',
                'apellido_paterno' => 'ITIC',
                'apellido_materno' => '2',
                'id_usuario' => Usuario::create(['usuario' => '22120999', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_departamento' => 11
            ]
        ]);

        /* Usuarios Responsable Actividad Complementaria */
        echo 'Usuarios de Responsables de Actividades . . .'.PHP_EOL;
        DB::table('responsable_actividad_complementaria')->insert([
            [ 
                'nombre' => 'Aurelio Amaury',
                'apellido_paterno' => 'Coria',
                'apellido_materno' => 'Ramirez',
                'id_usuario' => Usuario::create(['usuario' => 'CORA750528GK6-RA', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_departamento' => 11
            ],
            [
                'nombre' => 'Carol Aidee',
                'apellido_paterno' => 'Martinez',
                'apellido_materno' => 'Rosiles',
                'id_usuario' => Usuario::create(['usuario' => 'MARC7503263A5', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_departamento' => 11
            ],
            [
                'nombre' => 'Juan Manuel',
                'apellido_paterno' => 'Garcia',
                'apellido_materno' => 'Garcia',
                'id_usuario' => Usuario::create(['usuario' => 'GAGJ6707234S8', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_departamento' => 11
            ],
            [
                'nombre' => 'Wendy Yunuen',
                'apellido_paterno' => 'Arevalo',
                'apellido_materno' => 'Espinal',
                'id_usuario' => Usuario::create(['usuario' => 'AEEW960304000', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_departamento' => 11
            ],
            [
                'nombre' => 'Javier',
                'apellido_paterno' => 'Vargas',
                'apellido_materno' => 'Arias',
                'id_usuario' => Usuario::create(['usuario' => 'VAAJ810126LQ5', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_departamento' => 11
            ],
        ]);
        
        /* Usuarios Jefes de servicios escolares o servicio social */
        echo 'Usuarios de Servicios Escolares o Servicio Social . . .'.PHP_EOL;
        DB::table('jefe_servicios_social_escolares')->insert([
            [
                'nombre' => 'Margarita',
                'apellido_paterno' => 'Lopez',
                'apellido_materno' => 'Perea',
                'id_usuario' => Usuario::create(['usuario' => 'LOPM010101000', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id
            ],
            [
                'nombre' => 'Gabriela',
                'apellido_paterno' => 'Garcia',
                'apellido_materno' => 'Zepeda',
                'id_usuario' => Usuario::create(['usuario' => 'GAZG010101000', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id
            ]
        ]);
        
        /* Usuarios Alumnos */
        echo 'Usuarios de Alumnos . . .'.PHP_EOL;
        DB::table('alumno')->insert([
            /* Alumnos Primer Semestre */
            [
                'no_de_control' => '22120090',
                'nombre' => 'Nayeli',
                'apellido_paterno' => 'Arriola',
                'apellido_materno' => 'Salmerón',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120090', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120092',
                'nombre' => 'Osmar Farid',
                'apellido_paterno' => 'Balcazar',
                'apellido_materno' => 'Torres',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120092', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120091',
                'nombre' => 'Hector',
                'apellido_paterno' => 'Barriga',
                'apellido_materno' => 'Moreno',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120091', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ]
            ,[
                'no_de_control' => '22120093',
                'nombre' => 'Ricardo Alberto',
                'apellido_paterno' => 'Bofill',
                'apellido_materno' => 'Corona',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120093', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ]
            ,[
                'no_de_control' => '22120094',
                'nombre' => 'Samuel Andres',
                'apellido_paterno' => 'Camarillo',
                'apellido_materno' => 'López',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120094', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120096',
                'nombre' => 'José María',
                'apellido_paterno' => 'Chiquito',
                'apellido_materno' => 'García',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120096', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120097',
                'nombre' => 'Christian',
                'apellido_paterno' => 'Colorado',
                'apellido_materno' => 'Cerda',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120097', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120095',
                'nombre' => 'Eduardo',
                'apellido_paterno' => 'Cortez',
                'apellido_materno' => 'Garcia',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120095', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120099',
                'nombre' => 'Jesus Alberto',
                'apellido_paterno' => 'Cuiniche',
                'apellido_materno' => 'Balderaz',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120099', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120103',
                'nombre' => 'Luis Martín',
                'apellido_paterno' => 'Garcia',
                'apellido_materno' => 'Garcia',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120103', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120104',
                'nombre' => 'Joshua',
                'apellido_paterno' => 'García',
                'apellido_materno' => 'Gamiño',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120104', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120101',
                'nombre' => 'Victor Darío',
                'apellido_paterno' => 'Gaspar',
                'apellido_materno' => 'Quijano',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120101', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120105',
                'nombre' => 'Sergio',
                'apellido_paterno' => 'Gomez',
                'apellido_materno' => 'López',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120105', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120106',
                'nombre' => 'María De Los Ángeles',
                'apellido_paterno' => 'Herrera',
                'apellido_materno' => 'Mejía',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120106', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => 'C20120128',
                'nombre' => 'Abiel de Jesús',
                'apellido_paterno' => 'Juárez',
                'apellido_materno' => 'Gallegos',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => 'C20120128', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120109',
                'nombre' => 'Alan Diosimar',
                'apellido_paterno' => 'Lopez',
                'apellido_materno' => 'Lopez',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120109', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120110',
                'nombre' => 'Gohan Aldahir',
                'apellido_paterno' => 'López',
                'apellido_materno' => 'Melchor',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120110', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            [
                'no_de_control' => '22120111',
                'nombre' => 'Luis Ernesto',
                'apellido_paterno' => 'Martinez',
                'apellido_materno' => 'Ruiz',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120111', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120113',
                'nombre' => 'Luis Angel',
                'apellido_paterno' => 'Mendoza',
                'apellido_materno' => 'Lopez',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120113', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120114',
                'nombre' => 'Vanessa',
                'apellido_paterno' => 'Monter',
                'apellido_materno' => 'Garcia',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120114', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120442',
                'nombre' => 'Joseph Austreberto',
                'apellido_paterno' => 'Nava',
                'apellido_materno' => 'Mendoza',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120442', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120115',
                'nombre' => 'Sergio Eduardo',
                'apellido_paterno' => 'Olvera',
                'apellido_materno' => 'Hernández',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120115', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120116',
                'nombre' => 'Victor Manuel',
                'apellido_paterno' => 'Quiroz',
                'apellido_materno' => 'Hernández',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120116', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120117',
                'nombre' => 'Luis Ángel',
                'apellido_paterno' => 'Razo',
                'apellido_materno' => 'Camarena',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120117', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120118',
                'nombre' => 'Leonardo',
                'apellido_paterno' => 'Sanchez',
                'apellido_materno' => 'Piñon',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120118', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120119',
                'nombre' => 'Dante Ivan',
                'apellido_paterno' => 'Saucedo',
                'apellido_materno' => 'Luna',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120119', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120734',
                'nombre' => 'Oscar Emanuel',
                'apellido_paterno' => 'Sosa',
                'apellido_materno' => 'Escobedo',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120734', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120120',
                'nombre' => 'Ricardo Iair',
                'apellido_paterno' => 'Toledo',
                'apellido_materno' => 'Mora',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120120', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120122',
                'nombre' => 'José Manuel',
                'apellido_paterno' => 'Vargas',
                'apellido_materno' => 'García',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120122', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120123',
                'nombre' => 'Jose Alberto',
                'apellido_paterno' => 'Velazquez',
                'apellido_materno' => 'Flores',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120123', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120121',
                'nombre' => 'Martin Guadalupe',
                'apellido_paterno' => 'Villanueva',
                'apellido_materno' => 'Reyes',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120121', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '22120124',
                'nombre' => 'Luis Brayan',
                'apellido_paterno' => 'Zalapa',
                'apellido_materno' => 'Morales',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120124', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
            
            /* Alumnos Segundo Semestre */
            [
                'no_de_control' => '21121598',
                'nombre' => 'Gabriel',
                'apellido_paterno' => 'Aguilar',
                'apellido_materno' => 'Almazán',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121598', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121599',
                'nombre' => 'Rafael',
                'apellido_paterno' => 'Barba',
                'apellido_materno' => 'Hernandez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121599', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121600',
                'nombre' => 'David Alejandro',
                'apellido_paterno' => 'Cabrera',
                'apellido_materno' => 'Aguilar',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121600', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121601',
                'nombre' => 'Alvaro Diego',
                'apellido_paterno' => 'Farías',
                'apellido_materno' => 'Hernández',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121601', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121602',
                'nombre' => 'David',
                'apellido_paterno' => 'Fernández',
                'apellido_materno' => 'Pascual',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121602', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121603',
                'nombre' => 'Leonardo Daniel',
                'apellido_paterno' => 'García',
                'apellido_materno' => 'Hernández',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121603', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121604',
                'nombre' => 'David',
                'apellido_paterno' => 'Hernández',
                'apellido_materno' => 'Nieto',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121604', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121605',
                'nombre' => 'Nalani',
                'apellido_paterno' => 'Hernández',
                'apellido_materno' => 'Villalobos',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121605', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121606',
                'nombre' => 'Ignacio',
                'apellido_paterno' => 'Medina',
                'apellido_materno' => 'Gutiérrez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121606', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121608',
                'nombre' => 'Irma Cecilia',
                'apellido_paterno' => 'Páramo',
                'apellido_materno' => 'Guillén',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121608', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121610',
                'nombre' => 'Diego Alexis',
                'apellido_paterno' => 'Reyes',
                'apellido_materno' => 'Hernández',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121610', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121609',
                'nombre' => 'Abraham',
                'apellido_paterno' => 'Rodriguez',
                'apellido_materno' => 'Ochoa',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121609', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121611',
                'nombre' => 'Mauricio Erick',
                'apellido_paterno' => 'Soria',
                'apellido_materno' => 'Cisneros',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121611', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121612',
                'nombre' => 'José Ramses',
                'apellido_paterno' => 'Sánchez',
                'apellido_materno' => 'Solís',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121612', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121613',
                'nombre' => 'Emilio',
                'apellido_paterno' => 'Sánchez',
                'apellido_materno' => 'Vital',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121613', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121614',
                'nombre' => 'Kevin Naim',
                'apellido_paterno' => 'Valencia',
                'apellido_materno' => 'Chávez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121614', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],[
                'no_de_control' => '21121616',
                'nombre' => 'Fabian Sebastian',
                'apellido_paterno' => 'Zurita',
                'apellido_materno' => 'Ramirez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121616', 'password' => bcrypt($p=generatePassword(7)), 'default' =>$p])->id,
                'id_carrera' => '12'
            ],
        ]);

        /* Usuarios Debug */
        // ProyectoDocencia::create([
        //     'nombre' => 'Debug',
        //     'apellido_paterno' => 'Proyecto',
        //     'apellido_materno' => 'Docencia',
        //     'id_usuario' => Usuario::create(['usuario' => 'Debug-PD', 'password' => bcrypt('12345')])->id,
        //     'id_departamento' => 11
        // ]);
        // DB::table('responsable_actividad_complementaria')->insert([
        //     [ 
        //         'nombre' => 'Debug',
        //         'apellido_paterno' => 'Responsable',
        //         'apellido_materno' => 'Actividad',
        //         'id_usuario' => Usuario::create(['usuario' => 'Debug-RAC', 'password' => bcrypt('12345')])->id,
        //         'id_departamento' => 11
        //     ]
        // ]);
        // DB::table('jefe_servicios_social_escolares')->insert([
        //     [
        //         'nombre' => 'Debug',
        //         'apellido_paterno' => 'Social',
        //         'apellido_materno' => 'Escolares',
        //         'id_usuario' => Usuario::create(['usuario' => 'Debug-SSE', 'password' => bcrypt('12345')])->id,
        //         'id_departamento' => 11
        //     ]
        // ]);
        // DB::table('alumno')->insert([
        //     /* Alumnos Primer Semestre */
        //     [
        //         'no_de_control' => 'Debug-AL',
        //         'nombre' => 'Debug',
        //         'apellido_paterno' => 'Alumno',
        //         'apellido_materno' => 'Normal',
        //         'semestre' => '1',
        //         'id_usuario' => Usuario::create(['usuario' => 'Debug', 'password' => bcrypt('12345')])->id,
        //         'id_carrera' => '12'
        //     ],
        // ]);
    }
}
