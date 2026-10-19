<x-filament-widgets::widget>
      <x-filament::section>
          {{-- Encabezado del Calendario --}}
          <div class="flex justify-center items-center mb-6">
              <h2 class="text-2xl font-bold tracking-tight
  text-gray-950 dark:text-white capitalize">
                  {{ $this->getCalendarData()['monthName'] }} {{
  $this->getCalendarData()['year'] }}
              </h2>
          </div>

          {{-- Grid del Calendario --}}
          <div class="grid grid-cols-7 gap-2">
              {{-- Cabeceras de los días de la semana --}}
              @foreach(['Dom', 'Lun', 'Mar', 'Mie', 'Jue',
  'Vie', 'Sab'] as $dayLabel)
                  <div class="text-center font-bold text-xs
  uppercase tracking-wider text-gray-500 dark:text-gray-400
  pb-2">
                      {{ $dayLabel }}
                  </div>
              @endforeach

              {{-- Celdas vacías para ajustar el inicio del mes
  --}}
              @for ($i = 0; $i <
  $this->getCalendarData()['startDayOfWeek']; $i++)
                  <div class="h-24 bg-gray-50
  dark:bg-gray-800/50 rounded-lg border
  border-transparent"></div>
              @endfor

              {{-- Días del mes --}}
              @php
                  $data = $this->getCalendarData();
                  $currentMonth =
  \Carbon\Carbon::now()->startOfMonth();
              @endphp

              @for ($day = 1; $day <= $data['days']; $day++)
                  @php
                      $dateObject =
  $currentMonth->copy()->addDays($day - 1);
                      $dateKey = $dateObject->format('Y-m-d');
                      $dayEvents =
  $data['events']->get($dateKey, collect());
                      $isToday = $dateObject->isToday();
                  @endphp

                  <div class="h-24 p-2 border rounded-lg
  transition-colors {{ $isToday ? 'bg-primary-50
  border-primary-500 ring-1 ring-primary-500
  dark:bg-primary-900/20' : 'bg-white dark:bg-gray-900
  border-gray-200 dark:border-gray-700' }}">
                      {{-- Número del día --}}
                      <div class="flex justify-between
  items-start">
                          <span class="text-sm font-semibold {{
  $isToday ? 'text-primary-600 dark:text-primary-400' :
  'text-gray-700 dark:text-gray-300' }}">
                              {{ $day }}
                          </span>
                      </div>

                      {{-- Contenedor de Eventos --}}
                      <div class="mt-1 overflow-y-auto h-16
  space-y-1">
                          @foreach ($dayEvents as $event)
                              <div class="text-[10px] px-1.5
  py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900/50
  dark:text-blue-200 rounded-md truncate font-medium border
  border-blue-200 dark:border-blue-800"
                                   title="{{ $event->title }}">
                                  {{ $event->title }}
                              </div>
                          @endforeach
                      </div>
                  </div>
              @endfor
          </div>
      </x-filament::section>
  </x-filament-widgets::widget>