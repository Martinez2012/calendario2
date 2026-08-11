<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $grados = [
            '1er Grado',
            '2do Grado',
            '3er Grado',
            '4to Grado',
            '5to Grado',
            '6to Grado',
        ];

        foreach ($grados as $nombre) {
            Grade::create([
                'name' => $nombre, // varchar(20), cabe bien
            ]);
        }
    }
}