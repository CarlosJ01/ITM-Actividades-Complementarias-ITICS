<?php

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoITICSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        /* Usuarios Alumnos */
        DB::table('alumno')->insert([
            /* Alumnos Primer Semestre */
            [
                'no_de_control' => '22120090',
                'nombre' => 'Nayeli',
                'apellido_paterno' => 'Arriola',
                'apellido_materno' => 'Salmerón',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120090', 'password' => bcrypt($p='22120090'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120092',
                'nombre' => 'Osmar Farid',
                'apellido_paterno' => 'Balcazar',
                'apellido_materno' => 'Torres',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120092', 'password' => bcrypt($p='22120092'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120091',
                'nombre' => 'Hector',
                'apellido_paterno' => 'Barriga',
                'apellido_materno' => 'Moreno',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120091', 'password' => bcrypt($p='22120091'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ]
            ,[
                'no_de_control' => '22120093',
                'nombre' => 'Ricardo Alberto',
                'apellido_paterno' => 'Bofill',
                'apellido_materno' => 'Corona',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120093', 'password' => bcrypt($p='22120093'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ]
            ,[
                'no_de_control' => '22120094',
                'nombre' => 'Samuel Andres',
                'apellido_paterno' => 'Camarillo',
                'apellido_materno' => 'López',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120094', 'password' => bcrypt($p='22120094'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120096',
                'nombre' => 'José María',
                'apellido_paterno' => 'Chiquito',
                'apellido_materno' => 'García',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120096', 'password' => bcrypt($p='22120096'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120097',
                'nombre' => 'Christian',
                'apellido_paterno' => 'Colorado',
                'apellido_materno' => 'Cerda',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120097', 'password' => bcrypt($p='22120097'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120095',
                'nombre' => 'Eduardo',
                'apellido_paterno' => 'Cortez',
                'apellido_materno' => 'Garcia',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120095', 'password' => bcrypt($p='22120095'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120099',
                'nombre' => 'Jesus Alberto',
                'apellido_paterno' => 'Cuiniche',
                'apellido_materno' => 'Balderaz',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120099', 'password' => bcrypt($p='22120099'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120103',
                'nombre' => 'Luis Martín',
                'apellido_paterno' => 'Garcia',
                'apellido_materno' => 'Garcia',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120103', 'password' => bcrypt($p='22120103'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120104',
                'nombre' => 'Joshua',
                'apellido_paterno' => 'García',
                'apellido_materno' => 'Gamiño',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120104', 'password' => bcrypt($p='22120104'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120101',
                'nombre' => 'Victor Darío',
                'apellido_paterno' => 'Gaspar',
                'apellido_materno' => 'Quijano',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120101', 'password' => bcrypt($p='22120101'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120105',
                'nombre' => 'Sergio',
                'apellido_paterno' => 'Gomez',
                'apellido_materno' => 'López',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120105', 'password' => bcrypt($p='22120105'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120106',
                'nombre' => 'María De Los Ángeles',
                'apellido_paterno' => 'Herrera',
                'apellido_materno' => 'Mejía',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120106', 'password' => bcrypt($p='22120106'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => 'C20120128',
                'nombre' => 'Abiel de Jesús',
                'apellido_paterno' => 'Juárez',
                'apellido_materno' => 'Gallegos',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => 'C20120128', 'password' => bcrypt($p='C20120128'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120109',
                'nombre' => 'Alan Diosimar',
                'apellido_paterno' => 'Lopez',
                'apellido_materno' => 'Lopez',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120109', 'password' => bcrypt($p='22120109'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120110',
                'nombre' => 'Gohan Aldahir',
                'apellido_paterno' => 'López',
                'apellido_materno' => 'Melchor',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120110', 'password' => bcrypt($p='22120110'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            [
                'no_de_control' => '22120111',
                'nombre' => 'Luis Ernesto',
                'apellido_paterno' => 'Martinez',
                'apellido_materno' => 'Ruiz',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120111', 'password' => bcrypt($p='22120111'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120113',
                'nombre' => 'Luis Angel',
                'apellido_paterno' => 'Mendoza',
                'apellido_materno' => 'Lopez',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120113', 'password' => bcrypt($p='22120113'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120114',
                'nombre' => 'Vanessa',
                'apellido_paterno' => 'Monter',
                'apellido_materno' => 'Garcia',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120114', 'password' => bcrypt($p='22120114'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120442',
                'nombre' => 'Joseph Austreberto',
                'apellido_paterno' => 'Nava',
                'apellido_materno' => 'Mendoza',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120442', 'password' => bcrypt($p='22120442'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120115',
                'nombre' => 'Sergio Eduardo',
                'apellido_paterno' => 'Olvera',
                'apellido_materno' => 'Hernández',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120115', 'password' => bcrypt($p='22120115'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120116',
                'nombre' => 'Victor Manuel',
                'apellido_paterno' => 'Quiroz',
                'apellido_materno' => 'Hernández',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120116', 'password' => bcrypt($p='22120116'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120117',
                'nombre' => 'Luis Ángel',
                'apellido_paterno' => 'Razo',
                'apellido_materno' => 'Camarena',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120117', 'password' => bcrypt($p='22120117'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120118',
                'nombre' => 'Leonardo',
                'apellido_paterno' => 'Sanchez',
                'apellido_materno' => 'Piñon',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120118', 'password' => bcrypt($p='22120118'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120119',
                'nombre' => 'Dante Ivan',
                'apellido_paterno' => 'Saucedo',
                'apellido_materno' => 'Luna',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120119', 'password' => bcrypt($p='22120119'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120734',
                'nombre' => 'Oscar Emanuel',
                'apellido_paterno' => 'Sosa',
                'apellido_materno' => 'Escobedo',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120734', 'password' => bcrypt($p='22120734'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120120',
                'nombre' => 'Ricardo Iair',
                'apellido_paterno' => 'Toledo',
                'apellido_materno' => 'Mora',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120120', 'password' => bcrypt($p='22120120'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120122',
                'nombre' => 'José Manuel',
                'apellido_paterno' => 'Vargas',
                'apellido_materno' => 'García',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120122', 'password' => bcrypt($p='22120122'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120123',
                'nombre' => 'Jose Alberto',
                'apellido_paterno' => 'Velazquez',
                'apellido_materno' => 'Flores',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120123', 'password' => bcrypt($p='22120123'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120121',
                'nombre' => 'Martin Guadalupe',
                'apellido_paterno' => 'Villanueva',
                'apellido_materno' => 'Reyes',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120121', 'password' => bcrypt($p='22120121'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '22120124',
                'nombre' => 'Luis Brayan',
                'apellido_paterno' => 'Zalapa',
                'apellido_materno' => 'Morales',
                'semestre' => '1',
                'id_usuario' => Usuario::create(['usuario' => '22120124', 'password' => bcrypt($p='22120124'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
            
            /* Alumnos Segundo Semestre */
            [
                'no_de_control' => '21121598',
                'nombre' => 'Gabriel',
                'apellido_paterno' => 'Aguilar',
                'apellido_materno' => 'Almazán',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121598', 'password' => bcrypt($p='21121598'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121599',
                'nombre' => 'Rafael',
                'apellido_paterno' => 'Barba',
                'apellido_materno' => 'Hernandez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121599', 'password' => bcrypt($p='21121599'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121600',
                'nombre' => 'David Alejandro',
                'apellido_paterno' => 'Cabrera',
                'apellido_materno' => 'Aguilar',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121600', 'password' => bcrypt($p='21121600'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121601',
                'nombre' => 'Alvaro Diego',
                'apellido_paterno' => 'Farías',
                'apellido_materno' => 'Hernández',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121601', 'password' => bcrypt($p='21121601'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121602',
                'nombre' => 'David',
                'apellido_paterno' => 'Fernández',
                'apellido_materno' => 'Pascual',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121602', 'password' => bcrypt($p='21121602'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121603',
                'nombre' => 'Leonardo Daniel',
                'apellido_paterno' => 'García',
                'apellido_materno' => 'Hernández',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121603', 'password' => bcrypt($p='21121603'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121604',
                'nombre' => 'David',
                'apellido_paterno' => 'Hernández',
                'apellido_materno' => 'Nieto',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121604', 'password' => bcrypt($p='21121604'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121605',
                'nombre' => 'Nalani',
                'apellido_paterno' => 'Hernández',
                'apellido_materno' => 'Villalobos',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121605', 'password' => bcrypt($p='21121605'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121606',
                'nombre' => 'Ignacio',
                'apellido_paterno' => 'Medina',
                'apellido_materno' => 'Gutiérrez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121606', 'password' => bcrypt($p='21121606'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121608',
                'nombre' => 'Irma Cecilia',
                'apellido_paterno' => 'Páramo',
                'apellido_materno' => 'Guillén',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121608', 'password' => bcrypt($p='21121608'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121610',
                'nombre' => 'Diego Alexis',
                'apellido_paterno' => 'Reyes',
                'apellido_materno' => 'Hernández',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121610', 'password' => bcrypt($p='21121610'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121609',
                'nombre' => 'Abraham',
                'apellido_paterno' => 'Rodriguez',
                'apellido_materno' => 'Ochoa',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121609', 'password' => bcrypt($p='21121609'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121611',
                'nombre' => 'Mauricio Erick',
                'apellido_paterno' => 'Soria',
                'apellido_materno' => 'Cisneros',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121611', 'password' => bcrypt($p='21121611'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121612',
                'nombre' => 'José Ramses',
                'apellido_paterno' => 'Sánchez',
                'apellido_materno' => 'Solís',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121612', 'password' => bcrypt($p='21121612'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121613',
                'nombre' => 'Emilio',
                'apellido_paterno' => 'Sánchez',
                'apellido_materno' => 'Vital',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121613', 'password' => bcrypt($p='21121613'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121614',
                'nombre' => 'Kevin Naim',
                'apellido_paterno' => 'Valencia',
                'apellido_materno' => 'Chávez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121614', 'password' => bcrypt($p='21121614'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],[
                'no_de_control' => '21121616',
                'nombre' => 'Fabian Sebastian',
                'apellido_paterno' => 'Zurita',
                'apellido_materno' => 'Ramirez',
                'semestre' => '2',
                'id_usuario' => Usuario::create(['usuario' => '21121616', 'password' => bcrypt($p='21121616'.generatePassword(3)), 'default' =>$p])->id,
                'id_carrera' => '11'
            ],
        ]);
    }
}
