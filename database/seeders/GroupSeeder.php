<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $secciones = ['A', 'B'];

        Grade::all()->each(function (Grade $grado) use ($secciones) {
            foreach ($secciones as $seccion) {
                Group::create([
                    'grade_id' => $grado->id,
                    'name' => "{$grado->name} {$seccion}", // ej. "1er Grado A", <=20 chars
                ]);
            }
        });
    }
}