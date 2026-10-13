{{-- resources/views/filament/widgets/calendario-widget.blade.php --}}

@once
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/locales-all.global.min.js"></script>
    <style>
        /* ── FullCalendar overrides para Filament dark/light ──────────────── */
        .fc-filament {
            --fc-border-color:               rgba(255,255,255,.08);
            --fc-button-bg-color:            transparent;
            --fc-button-text-color:          inherit;
            --fc-button-border-color:        rgba(255,255,255,.15);
            --fc-button-hover-bg-color:      rgba(255,255,255,.07);
            --fc-button-hover-border-color:  rgba(255,255,255,.2);
            --fc-button-active-bg-color:     rgba(255,255,255,.14);
            --fc-button-active-border-color: rgba(255,255,255,.28);
            --fc-today-bg-color:             rgba(251,191,36,.07);
            --fc-page-bg-color:              transparent;
            --fc-neutral-bg-color:           rgba(255,255,255,.03);
            --fc-list-event-hover-bg-color:  rgba(255,255,255,.05);
            --fc-non-business-color:         rgba(0,0,0,.04);
            font-size: .875rem;
            color: inherit;
        }

        .fc-filament .fc-button {
            padding: .25rem .65rem;
            border-radius: .375rem;
            font-size: .8125rem;
            font-weight: 500;
            box-shadow: none !important;
            transition: background .15s, border-color .15s;
        }
        .fc-filament .fc-button:focus { outline: none; }
        .fc-filament .fc-toolbar-title { font-size: 1rem; font-weight: 600; }
        .fc-filament .fc-toolbar { flex-wrap: wrap; gap: .5rem; }

        .fc-filament .fc-col-header-cell-cushion,
        .fc-filament .fc-daygrid-day-number,
        .fc-filament .fc-timegrid-slot-label-cushion,
        .fc-filament .fc-list-event-title a,
        .fc-filament .fc-list-day-text,
        .fc-filament .fc-list-day-side-text {
            color: inherit;
            text-decoration: none;
        }

        .fc-filament .fc-event {
            border-radius: .25rem;
            font-size: .775rem;
            padding: 1px 4px;
            cursor: pointer;
            transition: opacity .15s;
        }
        .fc-filament .fc-event:hover { opacity: .85; }
        .fc-filament .fc-daygrid-event-dot { display: none; }

        /* Light mode adjustments */
        .light .fc-filament,
        :root[data-theme="light"] .fc-filament {
            --fc-border-color:              #e5e7eb;
            --fc-button-border-color:       #d1d5db;
            --fc-button-hover-bg-color:     #f3f4f6;
            --fc-button-hover-border-color: #9ca3af;
            --fc-button-active-bg-color:    #e5e7eb;
            --fc-today-bg-color:            rgba(251,191,36,.1);
            --fc-neutral-bg-color:          #f9fafb;
        }
    </style>
@endonce

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <span class="flex items-center gap-2">
                @svg('heroicon-o-calendar-days', 'h-5 w-5 text-primary-500')
                Calendario Escolar
            </span>
        </x-slot>

        {{-- Leyenda --}}
        <div class="flex flex-wrap gap-x-5 gap-y-2 text-xs text-gray-500 dark:text-gray-400 mb-4">
            <span class="flex items-center gap-1.5">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                Horarios de clase
            </span>
            <span class="flex items-center gap-1.5">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                Eventos
            </span>
        </div>

        {{-- Calendario --}}
        <div
            wire:ignore
            x-data="fcCalendario()"
            x-init="init()"
            class="relative"
        >
            <div x-ref="calendar" class="fc-filament"></div>

            {{-- Panel de detalle --}}
            <div
                x-show="detalle !== null"
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
                @click.self="detalle = null"
                x-cloak
            >
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                           rounded-xl shadow-2xl p-5 max-w-xs w-full mx-4"
                    @click.stop
                >
                    {{-- Cabecera --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mb-1.5"
                                :class="detalle?.tipo === 'clase'
                                    ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300'
                                    : 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300'"
                                x-text="detalle?.tipo === 'clase' ? 'Clase' : 'Evento'"
                            ></span>
                            <h3
                                class="font-semibold text-gray-900 dark:text-white leading-snug"
                                x-text="detalle?.titulo"
                            ></h3>
                        </div>
                        <button
                            @click="detalle = null"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 flex-shrink-0 mt-0.5"
                        >
                            @svg('heroicon-o-x-mark', 'h-5 w-5')
                        </button>
                    </div>

                    {{-- Detalles clase --}}
                    <template x-if="detalle?.tipo === 'clase'">
                        <dl class="grid grid-cols-[auto,1fr] gap-x-3 gap-y-2 text-sm">
                            <dt class="text-gray-500 dark:text-gray-400 self-baseline">Profesor</dt>
                            <dd class="text-gray-900 dark:text-white font-medium" x-text="detalle.profesor"></dd>

                            <dt class="text-gray-500 dark:text-gray-400 self-baseline">Materia</dt>
                            <dd class="text-gray-900 dark:text-white font-medium" x-text="detalle.materia"></dd>

                            <dt class="text-gray-500 dark:text-gray-400 self-baseline">Grupo</dt>
                            <dd class="text-gray-900 dark:text-white font-medium" x-text="detalle.grupo"></dd>

                            <dt class="text-gray-500 dark:text-gray-400 self-baseline">Horario</dt>
                            <dd class="text-gray-900 dark:text-white font-medium" x-text="detalle.horario"></dd>
                        </dl>
                    </template>

                    {{-- Detalles evento --}}
                    <template x-if="detalle?.tipo === 'evento'">
                        <dl class="grid grid-cols-[auto,1fr] gap-x-3 gap-y-2 text-sm">
                            <template x-if="detalle.tipo_evento">
                                <div class="contents">
                                    <dt class="text-gray-500 dark:text-gray-400">Tipo</dt>
                                    <dd class="text-gray-900 dark:text-white font-medium" x-text="detalle.tipo_evento"></dd>
                                </div>
                            </template>
                            <template x-if="detalle.descripcion">
                                <div class="contents">
                                    <dt class="text-gray-500 dark:text-gray-400">Descripcion</dt>
                                    <dd class="text-gray-900 dark:text-white" x-text="detalle.descripcion"></dd>
                                </div>
                            </template>
                        </dl>
                    </template>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

<script>
function fcCalendario() {
    return {
        calendar: null,
        detalle:  null,

        init() {
            if (typeof FullCalendar === 'undefined') {
                setTimeout(() => this.init(), 150);
                return;
            }

            this.calendar = new FullCalendar.Calendar(this.$refs.calendar, {
                locale:       'es',
                initialView:  'timeGridWeek',
                height:       640,
                headerToolbar: {
                    left:   'prev,next today',
                    center: 'title',
                    right:  'dayGridMonth,timeGridWeek,timeGridDay',
                },
                slotMinTime:  '07:00:00',
                slotMaxTime:  '20:00:00',
                nowIndicator: true,
                weekends:     false,
                allDayText:   'Todo el dia',
                slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                eventTimeFormat:  { hour: '2-digit', minute: '2-digit', hour12: false },
                noEventsContent: 'Sin eventos en este periodo',

                events: (fetchInfo, successCallback, failureCallback) => {
                    this.$wire
                        .getCalendarEvents(fetchInfo.startStr, fetchInfo.endStr)
                        .then(events => successCallback(events))
                        .catch(err   => failureCallback(err));
                },

                eventClick: (info) => {
                    this.detalle = {
                        titulo: info.event.title,
                        ...info.event.extendedProps,
                    };
                },
            });

            this.calendar.render();
        },
    };
}
</script>