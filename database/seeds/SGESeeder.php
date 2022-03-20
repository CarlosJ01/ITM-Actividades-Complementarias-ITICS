<?php

use App\Models\SGE\Periodo;
use App\Models\SGE\Departamento;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SGESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        /* Periodo actual de la escuela */
        Periodo::create([
            'nombre' => 'ENERO - JUNIO / 2020'
        ]);
        
        /* Departamentos */
        DB::table('departamento')->insert([
            ['nombre' => 'Ciencias Económico-Administrativas', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Eléctrica', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Gestión Empresarial', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Bioquímica', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Industrial', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería en Materiales', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Mecánica', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Mecatrónica', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería en Electronica', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Sistemas y Computación', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Tecnologías de la Información y Comunicaciones', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]
        ]);
        
        /* Carreras */
        DB::table('carrera')->insert([
            ['nombre' => 'Licenciatura en Administración','id_departamento' => '1', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Licenciatura en Contaduría', 'id_departamento' => '1', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Eléctrica', 'id_departamento' => '2', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería en Gestión Empresarial', 'id_departamento' => '3', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Bioquímica', 'id_departamento' => '4', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Industrial', 'id_departamento' => '5', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería en Materiales', 'id_departamento' => '6', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Mecánica', 'id_departamento' => '7', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Mecatrónica', 'id_departamento' => '8', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería Electrónica', 'id_departamento' => '9', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería en Sistemas Computacionales', 'id_departamento' => '10', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')],
            ['nombre' => 'Ingeniería en Tecnologías de la Información y Comunicación', 'id_departamento' => '11', 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]
        ]);
    }
}
