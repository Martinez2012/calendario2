<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="description"
        content="Plataforma de gestión académica"
    >

    <title>
        {{ config('app.name', 'Filament Academy') }}
    </title>

    {{-- ==========================================================
         TAILWIND
         No utiliza Vite ni public/build/manifest.json
    =========================================================== --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        academy: {
                            50: '#fffbea',
                            100: '#fff3b0',
                            200: '#ffe66b',
                            300: '#ffd633',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        }

                    },

                    boxShadow: {

                        academy:
                            '0 20px 70px rgba(250, 204, 21, 0.08)',

                    }

                }

            }

        }

    </script>

</head>


<body class="min-h-screen bg-[#09090b] text-white antialiased">


{{-- ================================================================
     NAVBAR
================================================================ --}}

<header
    class="
        fixed
        inset-x-0
        top-0
        z-50
        border-b
        border-white/5
        bg-[#09090b]/90
        backdrop-blur-xl
    "
>

    <div
        class="
            mx-auto
            flex
            h-20
            max-w-7xl
            items-center
            justify-between
            px-6
            lg:px-8
        "
    >

        {{-- LOGO --}}

        <a
            href="{{ url('/') }}"
            class="flex items-center gap-3"
        >

            <div
                class="
                    flex
                    h-10
                    w-10
                    items-center
                    justify-center
                    rounded-xl
                    bg-yellow-400
                    text-black
                    shadow-lg
                    shadow-yellow-400/10
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M2 10l10-5 10 5-10 5L2 10z"/>
                    <path d="M6 12.5V17c3 2 9 2 12 0v-4.5"/>
                    <path d="M22 10v6"/>
                </svg>

            </div>


            <div>

                <div
                    class="
                        text-sm
                        font-bold
                        tracking-wide
                        text-white
                    "
                >
                    {{ config('app.name', 'ACADEMY') }}
                </div>

                <div
                    class="
                        text-xs
                        font-medium
                        text-yellow-400
                    "
                >
                    GESTIÓN ACADÉMICA
                </div>

            </div>

        </a>


        {{-- NAVEGACIÓN --}}

        <nav class="hidden items-center gap-8 md:flex">

            <a
                href="#caracteristicas"
                class="
                    text-sm
                    text-zinc-400
                    transition
                    hover:text-white
                "
            >
                Características
            </a>

            <a
                href="#modulos"
                class="
                    text-sm
                    text-zinc-400
                    transition
                    hover:text-white
                "
            >
                Módulos
            </a>

            <a
                href="#plataforma"
                class="
                    text-sm
                    text-zinc-400
                    transition
                    hover:text-white
                "
            >
                Plataforma
            </a>

        </nav>


        {{-- =========================================================
             AUTENTICACIÓN
        ========================================================== --}}

        <div class="flex items-center gap-3">

            @auth

                {{-- PANEL --}}

                <a
                    href="{{ filament()->getUrl() }}"
                    class="
                        hidden
                        rounded-lg
                        border
                        border-white/10
                        px-4
                        py-2
                        text-sm
                        font-medium
                        text-zinc-200
                        transition
                        hover:border-yellow-400/30
                        hover:bg-white/5
                        hover:text-yellow-400
                        sm:inline-flex
                    "
                >
                    Panel
                </a>


                {{-- LOGOUT --}}

                <form
                    method="POST"
                    action="{{ filament()->getLogoutUrl() }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="
                            rounded-lg
                            bg-yellow-400
                            px-4
                            py-2
                            text-sm
                            font-bold
                            text-black
                            transition
                            hover:bg-yellow-300
                            focus:outline-none
                            focus:ring-2
                            focus:ring-yellow-400/50
                        "
                    >
                        Cerrar sesión
                    </button>

                </form>

            @else

                {{-- LOGIN --}}

                <a
                    href="{{ filament()->getLoginUrl() }}"
                    class="
                        rounded-lg
                        bg-yellow-400
                        px-5
                        py-2.5
                        text-sm
                        font-bold
                        text-black
                        shadow-lg
                        shadow-yellow-400/10
                        transition
                        hover:bg-yellow-300
                        hover:shadow-yellow-400/20
                    "
                >
                    Iniciar sesión
                </a>

            @endauth

        </div>

    </div>

</header>



{{-- ================================================================
     HERO
================================================================ --}}

<main>

<section
    class="
        relative
        isolate
        overflow-hidden
        pt-32
        lg:pt-40
    "
>

    {{-- Glow --}}

    <div
        class="
            absolute
            left-1/2
            top-20
            -z-10
            h-[500px]
            w-[800px]
            -translate-x-1/2
            rounded-full
            bg-yellow-400/5
            blur-3xl
        "
    ></div>


    <div
        class="
            mx-auto
            max-w-7xl
            px-6
            lg:px-8
        "
    >

        <div
            class="
                grid
                items-center
                gap-16
                lg:grid-cols-2
            "
        >

            {{-- =====================================================
                 TEXTO
            ====================================================== --}}

            <div>

                <div
                    class="
                        mb-6
                        inline-flex
                        items-center
                        gap-2
                        rounded-full
                        border
                        border-yellow-400/20
                        bg-yellow-400/5
                        px-3
                        py-1.5
                        text-xs
                        font-medium
                        text-yellow-400
                    "
                >

                    <span
                        class="
                            h-1.5
                            w-1.5
                            rounded-full
                            bg-yellow-400
                        "
                    ></span>

                    Plataforma de gestión académica

                </div>


                <h1
                    class="
                        max-w-3xl
                        text-5xl
                        font-bold
                        tracking-tight
                        text-white
                        sm:text-6xl
                        lg:text-7xl
                    "
                >

                    Todo tu sistema

                    <span class="text-yellow-400">
                        académico
                    </span>

                    en un solo lugar.

                </h1>


                <p
                    class="
                        mt-6
                        max-w-xl
                        text-lg
                        leading-8
                        text-zinc-400
                    "
                >
                    Administra estudiantes, profesores, materias,
                    calificaciones, tareas, grupos, horarios e
                    inscripciones desde una plataforma moderna,
                    rápida y organizada.
                </p>


                {{-- BOTONES --}}

                <div
                    class="
                        mt-10
                        flex
                        flex-wrap
                        gap-4
                    "
                >

                    @auth

                        <a
                            href="{{ filament()->getUrl() }}"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                rounded-xl
                                bg-yellow-400
                                px-6
                                py-3.5
                                text-sm
                                font-bold
                                text-black
                                transition
                                hover:bg-yellow-300
                            "
                        >

                            Ir al panel

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>

                        </a>

                    @else

                        <a
                            href="{{ filament()->getLoginUrl() }}"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                rounded-xl
                                bg-yellow-400
                                px-6
                                py-3.5
                                text-sm
                                font-bold
                                text-black
                                transition
                                hover:bg-yellow-300
                            "
                        >

                            Acceder a la plataforma

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>

                        </a>

                    @endauth


                    <a
                        href="#modulos"
                        class="
                            inline-flex
                            items-center
                            rounded-xl
                            border
                            border-white/10
                            bg-white/[0.02]
                            px-6
                            py-3.5
                            text-sm
                            font-medium
                            text-zinc-300
                            transition
                            hover:border-white/20
                            hover:bg-white/5
                            hover:text-white
                        "
                    >
                        Explorar módulos
                    </a>

                </div>

            </div>



            {{-- =====================================================
                 PREVIEW DEL PANEL
            ====================================================== --}}

            <div class="relative">

                <div
                    class="
                        absolute
                        -inset-4
                        rounded-3xl
                        bg-yellow-400/5
                        blur-2xl
                    "
                ></div>


                <div
                    class="
                        relative
                        overflow-hidden
                        rounded-2xl
                        border
                        border-white/10
                        bg-[#111113]
                        shadow-2xl
                        shadow-black/50
                    "
                >

                    {{-- Barra superior --}}

                    <div
                        class="
                            flex
                            h-12
                            items-center
                            gap-2
                            border-b
                            border-white/5
                            bg-[#151517]
                            px-4
                        "
                    >

                        <span
                            class="
                                h-3
                                w-3
                                rounded-full
                                bg-red-500/70
                            "
                        ></span>

                        <span
                            class="
                                h-3
                                w-3
                                rounded-full
                                bg-yellow-400/70
                            "
                        ></span>

                        <span
                            class="
                                h-3
                                w-3
                                rounded-full
                                bg-green-500/70
                            "
                        ></span>


                        <div
                            class="
                                ml-4
                                h-6
                                flex-1
                                rounded-md
                                bg-white/5
                            "
                        ></div>

                    </div>



                    <div class="flex min-h-[390px]">

                        {{-- SIDEBAR --}}

                        <aside
                            class="
                                hidden
                                w-44
                                border-r
                                border-white/5
                                bg-[#0d0d0f]
                                p-3
                                sm:block
                            "
                        >

                            <div
                                class="
                                    mb-5
                                    flex
                                    items-center
                                    gap-2
                                    px-2
                                "
                            >

                                <div
                                    class="
                                        flex
                                        h-6
                                        w-6
                                        items-center
                                        justify-center
                                        rounded-md
                                        bg-yellow-400
                                        text-black
                                    "
                                >
                                    🎓
                                </div>

                                <span
                                    class="
                                        text-xs
                                        font-bold
                                    "
                                >
                                    ACADEMY
                                </span>

                            </div>


                            @php

                                $menu = [

                                    '⌂' => 'Escritorio',

                                    '▦' => 'Horarios de clases',

                                    '✓' => 'Inscripciones',

                                    '□' => 'Eventos',

                                    '◇' => 'Grados',

                                    '♧' => 'Grupos',

                                    '▥' => 'Calificaciones',

                                    '♙' => 'Estudiantes',

                                    '▤' => 'Materias',

                                    '↑' => 'Entregas de tareas',

                                    '☷' => 'Tareas',

                                    '⌘' => 'Profesores',

                                ];

                            @endphp


                            <div class="space-y-1">

                                @foreach($menu as $icon => $label)

                                    <div
                                        class="
                                            flex
                                            items-center
                                            gap-2
                                            rounded-md
                                            px-2
                                            py-2
                                            text-[9px]

                                            {{ $label === 'Estudiantes'
                                                ? 'bg-yellow-400/10 text-yellow-400'
                                                : 'text-zinc-500'
                                            }}
                                        "
                                    >

                                        <span
                                            class="
                                                flex
                                                h-4
                                                w-4
                                                items-center
                                                justify-center
                                            "
                                        >
                                            {{ $icon }}
                                        </span>

                                        {{ $label }}

                                    </div>

                                @endforeach

                            </div>

                        </aside>



                        {{-- CONTENIDO --}}

                        <div class="flex-1 p-5">

                            <div
                                class="
                                    mb-5
                                    flex
                                    items-center
                                    justify-between
                                "
                            >

                                <div>

                                    <div
                                        class="
                                            text-[10px]
                                            text-zinc-500
                                        "
                                    >
                                        Gestión académica
                                    </div>

                                    <div
                                        class="
                                            mt-1
                                            text-lg
                                            font-bold
                                        "
                                    >
                                        Estudiantes
                                    </div>

                                </div>


                                <div
                                    class="
                                        h-8
                                        w-8
                                        rounded-full
                                        bg-yellow-400/10
                                    "
                                ></div>

                            </div>



                            {{-- CARDS --}}

                            <div
                                class="
                                    grid
                                    grid-cols-2
                                    gap-3
                                    sm:grid-cols-3
                                "
                            >

                                <div
                                    class="
                                        rounded-xl
                                        border
                                        border-white/5
                                        bg-white/[0.02]
                                        p-3
                                    "
                                >

                                    <div
                                        class="
                                            text-[9px]
                                            text-zinc-500
                                        "
                                    >
                                        Estudiantes
                                    </div>

                                    <div
                                        class="
                                            mt-2
                                            text-xl
                                            font-bold
                                        "
                                    >
                                        1,248
                                    </div>

                                    <div
                                        class="
                                            mt-1
                                            text-[8px]
                                            text-green-400
                                        "
                                    >
                                        +12.5%
                                    </div>

                                </div>


                                <div
                                    class="
                                        rounded-xl
                                        border
                                        border-white/5
                                        bg-white/[0.02]
                                        p-3
                                    "
                                >

                                    <div
                                        class="
                                            text-[9px]
                                            text-zinc-500
                                        "
                                    >
                                        Profesores
                                    </div>

                                    <div
                                        class="
                                            mt-2
                                            text-xl
                                            font-bold
                                        "
                                    >
                                        86
                                    </div>

                                    <div
                                        class="
                                            mt-1
                                            text-[8px]
                                            text-green-400
                                        "
                                    >
                                        +4.2%
                                    </div>

                                </div>


                                <div
                                    class="
                                        rounded-xl
                                        border
                                        border-yellow-400/10
                                        bg-yellow-400/[0.03]
                                        p-3
                                    "
                                >

                                    <div
                                        class="
                                            text-[9px]
                                            text-zinc-500
                                        "
                                    >
                                        Calificación
                                    </div>

                                    <div
                                        class="
                                            mt-2
                                            text-xl
                                            font-bold
                                            text-yellow-400
                                        "
                                    >
                                        87.4%
                                    </div>

                                    <div
                                        class="
                                            mt-1
                                            text-[8px]
                                            text-green-400
                                        "
                                    >
                                        +3.8%
                                    </div>

                                </div>

                            </div>



                            {{-- GRÁFICA --}}

                            <div
                                class="
                                    mt-4
                                    rounded-xl
                                    border
                                    border-white/5
                                    bg-white/[0.02]
                                    p-4
                                "
                            >

                                <div
                                    class="
                                        mb-4
                                        text-[10px]
                                        font-medium
                                        text-zinc-400
                                    "
                                >
                                    Rendimiento académico
                                </div>


                                <div
                                    class="
                                        flex
                                        h-28
                                        items-end
                                        gap-2
                                    "
                                >

                                    @foreach([
                                        35,
                                        48,
                                        42,
                                        65,
                                        55,
                                        72,
                                        68,
                                        85,
                                        76,
                                        92,
                                        82,
                                        96
                                    ] as $height)

                                        <div
                                            class="
                                                flex-1
                                                rounded-t
                                                bg-gradient-to-t
                                                from-yellow-500/20
                                                to-yellow-400
                                            "
                                            style="
                                                height: {{ $height }}%;
                                            "
                                        ></div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ================================================================
     CARACTERÍSTICAS
================================================================ --}}

<section
    id="caracteristicas"
    class="
        border-t
        border-white/5
        py-24
    "
>

    <div
        class="
            mx-auto
            max-w-7xl
            px-6
            lg:px-8
        "
    >

        <div
            class="
                mx-auto
                max-w-2xl
                text-center
            "
        >

            <div
                class="
                    text-sm
                    font-semibold
                    text-yellow-400
                "
            >
                TODO CENTRALIZADO
            </div>


            <h2
                class="
                    mt-3
                    text-3xl
                    font-bold
                    tracking-tight
                    sm:text-4xl
                "
            >
                Diseñado para instituciones modernas
            </h2>


            <p
                class="
                    mt-4
                    text-zinc-400
                "
            >
                Una solución completa para administrar
                todos los procesos académicos.
            </p>

        </div>



        <div
            class="
                mx-auto
                mt-16
                grid
                max-w-5xl
                grid-cols-1
                gap-4
                sm:grid-cols-2
                lg:grid-cols-3
            "
        >

            @php

                $features = [

                    [
                        'icon' => '👥',
                        'title' => 'Estudiantes',
                        'description' =>
                            'Gestiona perfiles, información académica y registros de cada estudiante.',
                    ],

                    [
                        'icon' => '📊',
                        'title' => 'Calificaciones',
                        'description' =>
                            'Controla notas, evaluaciones y rendimiento académico.',
                    ],

                    [
                        'icon' => '🎓',
                        'title' => 'Profesores',
                        'description' =>
                            'Administra profesores, asignaciones y responsabilidades.',
                    ],

                    [
                        'icon' => '📚',
                        'title' => 'Materias',
                        'description' =>
                            'Organiza materias, grados, grupos y horarios.',
                    ],

                    [
                        'icon' => '✓',
                        'title' => 'Tareas',
                        'description' =>
                            'Crea tareas y controla las entregas de los estudiantes.',
                    ],

                    [
                        'icon' => '📅',
                        'title' => 'Eventos',
                        'description' =>
                            'Mantén organizada toda la agenda académica.',
                    ],

                ];

            @endphp


            @foreach($features as $feature)

                <div
                    class="
                        group
                        rounded-2xl
                        border
                        border-white/5
                        bg-[#111113]
                        p-6
                        transition
                        duration-300
                        hover:-translate-y-1
                        hover:border-yellow-400/20
                        hover:bg-[#151517]
                    "
                >

                    <div
                        class="
                            mb-5
                            flex
                            h-11
                            w-11
                            items-center
                            justify-center
                            rounded-xl
                            bg-yellow-400/10
                            text-xl
                            transition
                            group-hover:bg-yellow-400
                        "
                    >
                        {{ $feature['icon'] }}
                    </div>


                    <h3
                        class="
                            font-semibold
                            text-white
                        "
                    >
                        {{ $feature['title'] }}
                    </h3>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-6
                            text-zinc-500
                        "
                    >
                        {{ $feature['description'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>



{{-- ================================================================
     MÓDULOS
================================================================ --}}

<section
    id="modulos"
    class="
        border-t
        border-white/5
        bg-[#0c0c0e]
        py-24
    "
>

    <div
        class="
            mx-auto
            max-w-7xl
            px-6
            lg:px-8
        "
    >

        <div
            class="
                grid
                items-center
                gap-16
                lg:grid-cols-2
            "
        >

            <div>

                <span
                    class="
                        text-sm
                        font-semibold
                        text-yellow-400
                    "
                >
                    UNA PLATAFORMA COMPLETA
                </span>


                <h2
                    class="
                        mt-3
                        text-3xl
                        font-bold
                        sm:text-4xl
                    "
                >
                    Todo lo que necesitas
                    para administrar tu institución.
                </h2>


                <p
                    class="
                        mt-5
                        leading-7
                        text-zinc-400
                    "
                >
                    Desde la inscripción de estudiantes hasta
                    sus calificaciones finales. Centraliza
                    la información y simplifica el trabajo
                    administrativo.
                </p>

            </div>



            <div
                class="
                    grid
                    grid-cols-2
                    gap-3
                "
            >

                @foreach([

                    'Estudiantes',
                    'Profesores',
                    'Grupos',
                    'Grados',
                    'Materias',
                    'Horarios',
                    'Calificaciones',
                    'Tareas',
                    'Entregas',
                    'Inscripciones',
                    'Eventos',
                    'Usuarios',

                ] as $module)

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                            rounded-xl
                            border
                            border-white/5
                            bg-[#111113]
                            px-4
                            py-3
                            text-sm
                            text-zinc-300
                            transition
                            hover:border-yellow-400/20
                            hover:text-yellow-400
                        "
                    >

                        <span
                            class="
                                h-1.5
                                w-1.5
                                rounded-full
                                bg-yellow-400
                            "
                        ></span>

                        {{ $module }}

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>



{{-- ================================================================
     CTA
================================================================ --}}

<section
    id="plataforma"
    class="py-24"
>

    <div
        class="
            mx-auto
            max-w-5xl
            px-6
            lg:px-8
        "
    >

        <div
            class="
                relative
                overflow-hidden
                rounded-3xl
                border
                border-yellow-400/10
                bg-gradient-to-br
                from-yellow-400/10
                via-[#111113]
                to-[#111113]
                p-10
                text-center
                sm:p-16
            "
        >

            <div
                class="
                    absolute
                    left-1/2
                    top-0
                    h-40
                    w-80
                    -translate-x-1/2
                    rounded-full
                    bg-yellow-400/10
                    blur-3xl
                "
            ></div>


            <div class="relative">

                <div
                    class="
                        mx-auto
                        flex
                        h-14
                        w-14
                        items-center
                        justify-center
                        rounded-2xl
                        bg-yellow-400
                        text-2xl
                    "
                >
                    🎓
                </div>


                <h2
                    class="
                        mt-6
                        text-3xl
                        font-bold
                        sm:text-4xl
                    "
                >
                    Lleva tu institución
                    al siguiente nivel.
                </h2>


                <p
                    class="
                        mx-auto
                        mt-4
                        max-w-xl
                        text-zinc-400
                    "
                >
                    Una experiencia administrativa moderna,
                    organizada y construida para crecer contigo.
                </p>


                <div class="mt-8">

                    @auth

                        <a
                            href="{{ filament()->getUrl() }}"
                            class="
                                inline-flex
                                rounded-xl
                                bg-yellow-400
                                px-7
                                py-3.5
                                text-sm
                                font-bold
                                text-black
                                transition
                                hover:bg-yellow-300
                            "
                        >
                            Abrir panel
                        </a>

                    @else

                        <a
                            href="{{ filament()->getLoginUrl() }}"
                            class="
                                inline-flex
                                rounded-xl
                                bg-yellow-400
                                px-7
                                py-3.5
                                text-sm
                                font-bold
                                text-black
                                transition
                                hover:bg-yellow-300
                            "
                        >
                            Iniciar sesión
                        </a>

                    @endauth

                </div>

            </div>

        </div>

    </div>

</section>

</main>



{{-- ================================================================
     FOOTER
================================================================ --}}

<footer
    class="
        border-t
        border-white/5
    "
>

    <div
        class="
            mx-auto
            flex
            max-w-7xl
            flex-col
            items-center
            justify-between
            gap-4
            px-6
            py-8
            sm:flex-row
            lg:px-8
        "
    >

        <div
            class="
                text-sm
                text-zinc-600
            "
        >

            © {{ date('Y') }}

            {{ config('app.name', 'Filament Academy') }}

        </div>


        <div
            class="
                text-xs
                text-zinc-700
            "
        >
            Laravel · Filament
        </div>

    </div>

</footer>


</body>
</html>
