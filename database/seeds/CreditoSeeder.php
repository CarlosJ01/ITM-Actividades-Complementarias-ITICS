<?php

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class CreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10; $i++) { 
            DB::table('credito_complementario')->insert([
                ['numero' => '1', 'valor' => '1', 'descripcion' => 'Asistir a un Congreso', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
                ['numero' => '2', 'valor' => '0', 'descripcion' => 'Participar activamente en un Evento Académico', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
                ['numero' => '2.1', 'valor' => '1', 'descripcion' => 'Como Organizador', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
                ['numero' => '2.2', 'valor' => '2', 'descripcion' => 'Como Ponente, Conferencista o en la exposición de carteles', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
                ['numero' => '3', 'valor' => '1', 'descripcion' => 'Asesorar un Curso Académico Institucional', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
                ['numero' => '4', 'valor' => '2', 'descripcion' => 'Realizar una estancia Técnico-Científico (evento corto)', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
                ['numero' => '5', 'valor' => '0', 'descripcion' => 'Asistir a un Curso o un Taller de mínimo 20 horas', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
                ['numero' => '5.1', 'valor' => '1', 'descripcion' => 'MOOC del TNM', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => false], //Inactivo
                ['numero' => '5.2', 'valor' => '1', 'descripcion' => 'Curso o Taller en general', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
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
                ['numero' => '13', 'valor' => '1', 'descripcion' => 'Participa en Actividades Extraescolares, culturales o deportivas, durante mínimo un periodo semestral', 'id_departamento' => $i, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'), 'activo' => true],
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
        }
    }
}
