<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'title' => 'Museo',
        ]);

        Categoria::create([
            'title' => 'Parque',
        ]);

        Categoria::create([
            'title' => 'Castillo',
        ]);

        Categoria::create([
            'title' => 'Iglesia',
        ]);

        Categoria::create([
            'title' => 'Biblioteca',
        ]);

    }
}