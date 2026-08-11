<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            'Matemáticas' => 'Números, operaciones y razonamiento lógico.',
            'Español' => 'Lectura, escritura y gramática.',
            'Ciencias Naturales' => 'Biología, física y química básica.',
            'Historia' => 'Historia nacional y universal.',
            'Educación Física' => 'Actividad física y deporte.',
            'Arte' => 'Expresión artística y creatividad.',
            'Inglés' => 'Idioma extranjero.',
        ];

        foreach ($materias as $nombre => $descripcion) {
            Subject::create([
                'name' => $nombre,
                'description' => $descripcion,
            ]);
        }
    }
}