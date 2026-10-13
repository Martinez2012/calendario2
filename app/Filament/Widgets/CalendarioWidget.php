<?php

namespace App\Filament\Widgets;

use App\Models\ClassSchedule;
use App\Models\Event;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class CalendarioWidget extends Widget
{
    protected string $view = 'filament.widgets.calendario-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    private const DIAS = [
        'lunes'     => Carbon::MONDAY,
        'martes'    => Carbon::TUESDAY,
        'miercoles' => Carbon::WEDNESDAY,
        'jueves'    => Carbon::THURSDAY,
        'viernes'   => Carbon::FRIDAY,
        'sabado'    => Carbon::SATURDAY,
        'domingo'   => Carbon::SUNDAY,
    ];

    public function getCalendarEvents(string $start, string $end): array
    {
        $events    = [];
        $startDate = Carbon::parse($start)->startOfDay();
        $endDate   = Carbon::parse($end)->endOfDay();

        ClassSchedule::with([
            'teacherSubjectGroup.teacher.user',
            'teacherSubjectGroup.subject',
            'teacherSubjectGroup.group',
        ])->get()->each(function (ClassSchedule $schedule) use (&$events, $startDate, $endDate) {

            $dayNumber = self::DIAS[mb_strtolower($schedule->day)] ?? null;
            if ($dayNumber === null) return;

            $cursor = $startDate->copy();

            while ($cursor->lte($endDate)) {
                if ($cursor->dayOfWeek === $dayNumber) {
                    $tsg      = $schedule->teacherSubjectGroup;
                    $profesor = $tsg?->teacher?->user?->name ?? 'Sin asignar';
                    $materia  = $tsg?->subject?->name        ?? 'Sin materia';
                    $grupo    = $tsg?->group?->name          ?? 'Sin grupo';
                    $inicio   = substr((string) $schedule->start_time, 0, 5);
                    $fin      = substr((string) $schedule->end_time,   0, 5);

                    $events[] = [
                        'id'              => "clase-{$schedule->id}-{$cursor->format('Ymd')}",
                        'title'           => "{$materia} · {$grupo}",
                        'start'           => $cursor->format('Y-m-d') . "T{$schedule->start_time}",
                        'end'             => $cursor->format('Y-m-d') . "T{$schedule->end_time}",
                        'backgroundColor' => '#3b82f6',
                        'borderColor'     => '#1d4ed8',
                        'textColor'       => '#ffffff',
                        'extendedProps'   => [
                            'tipo'     => 'clase',
                            'profesor' => $profesor,
                            'materia'  => $materia,
                            'grupo'    => $grupo,
                            'horario'  => "{$inicio} – {$fin}",
                        ],
                    ];
                }
                $cursor->addDay();
            }
        });

        Event::query()
            ->where(function ($q) use ($startDate, $endDate) {
                $s = $startDate->toDateString();
                $e = $endDate->toDateString();
                $q->whereBetween('date', [$s, $e])
                  ->orWhere(function ($q2) use ($s, $e) {
                      $q2->whereNotNull('end_date')
                         ->where('date', '<=', $e)
                         ->where('end_date', '>=', $s);
                  });
            })
            ->get()
            ->each(function (Event $event) use (&$events) {
                $events[] = [
                    'id'              => "evento-{$event->id}",
                    'title'           => $event->name,
                    'start'           => $event->date,
                    'end'             => $event->end_date ?? $event->date,
                    'allDay'          => true,
                    'backgroundColor' => '#f59e0b',
                    'borderColor'     => '#b45309',
                    'textColor'       => '#ffffff',
                    'extendedProps'   => [
                        'tipo'        => 'evento',
                        'tipo_evento' => $event->type        ?? '',
                        'descripcion' => $event->description ?? '',
                    ],
                ];
            });

        return $events;
    }
}