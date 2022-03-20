<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        require('generadorPassword.php');

        $this->call(SGESeeder::class);
        $this->call(ITICSeeder::class);
        
        // $this->call(CreditoSeeder::class);
        // $this->call(AlumnoITICSeeder::class);        
        // $this->call(UsuarioSeeder::class);
    }
}
