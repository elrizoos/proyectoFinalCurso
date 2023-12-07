<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Alumno;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ClaseTableSeeder::class,
            GrupoTableSeeder::class,
            EmpleadoTableSeeder::class,
            AlumnoTableSeeder::class,
            GrupoClaseCustomSeeder::class,
        ]);

       
    }
}
