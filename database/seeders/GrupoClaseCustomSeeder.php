<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clase;
use App\Models\Grupo;

class GrupoClaseCustomSeeder extends Seeder
{
    public function run(): void
    {
       $clase = Clase::factory()->create([
            
                'id' => 0,
                'nombre' => 'unasigned',
                'nivel' => 'unasigned',
            
        ]);
        Grupo::factory()->create([
            'id' => 0,
            'nombre' => 'unassigned',
            'maxParticipantes' => 100,
            'codigoClase' => $clase->id,
        ]);
    }
}