<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Group;
use App\Models\TeacherSubjectGroup;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $groups = Group::all();
        $asignaciones = TeacherSubjectGroup::all();

        $eventosGenerales = [
            ['title' => 'Reunión de padres de familia', 'type' => 'meeting'],
            ['title' => 'Día festivo nacional', 'type' => 'holiday'],
            ['title' => 'Feria de ciencias', 'type' => 'activity'],
        ];

        foreach ($eventosGenerales as $evento) {
            $inicio = $faker->dateTimeBetween('now', '+2 months');

            Event::create([
                'title' => $evento['title'],
                'description' => $faker->sentence(10),
                'type' => $evento['type'],
                'start' => $inicio,
                'end' => (clone $inicio)->modify('+2 hours'),
                'group_id' => null,
                'teacher_subject_group_id' => null,
            ]);
        }

        // Exámenes ligados a una asignación específica (profesor+materia+grupo)
        $asignaciones->random(5)->each(function (TeacherSubjectGroup $asignacion) use ($faker) {
            $inicio = $faker->dateTimeBetween('now', '+1 month');

            Event::create([
                'title' => 'Examen',
                'description' => $faker->sentence(8),
                'type' => 'exam',
                'start' => $inicio,
                'end' => (clone $inicio)->modify('+1 hour'),
                'group_id' => $asignacion->group_id,
                'teacher_subject_group_id' => $asignacion->id,
            ]);
        });
    }
}