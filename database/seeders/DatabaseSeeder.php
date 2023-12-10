<?php

namespace Database\Seeders;


use App\Models\Alumno;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            ClaseTableSeeder::class,
            GrupoTableSeeder::class,
            EmpleadoTableSeeder::class,
            AlumnoTableSeeder::class,
            GrupoClaseCustomSeeder::class,
        ]);


    }
}
