<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CalendarioWidget extends Widget
{

    protected string $view = 'filament.widgets.calendario-widget';

    // Definimos el ancho del widget (full = ocupa todo el ancho)
    protected int | string | array $columnSpan = 'full';

    public function getCalendarData(): array
    {
        $now = \Carbon\Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // CAMBIO AQUÍ: Usamos 'start' en lugar de 'date'
        $events = \App\Models\Event::whereBetween(
            'start',
            [$startOfMonth, $endOfMonth]
        )
            ->get()
            ->groupBy(fn($event) =>
            \Carbon\Carbon::parse($event->start)->format('Y-m-d'));

        return [
            'days' => $startOfMonth->daysInMonth,
            'startDayOfWeek' => $startOfMonth->dayOfWeek,
            'events' => $events,
            'monthName' => $now->translatedFormat('F'),
            'year' => $now->year,
        ];
    }
}
