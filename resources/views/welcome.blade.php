<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Plataforma de gestión académica ClassHub">

    {{-- FAVICON --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192x192.png') }}">

    <title>{{ config('app.name', 'ClassHub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        :root {
            --yellow: #facc15;
            --yellow-dark: #eab308;
            --bg: #09090b;
            --bg2: #0f0f11;
            --surface: #141416;
            --border: rgba(255,255,255,0.07);
        }

        html { scroll-behavior: smooth; }

        body { background: var(--bg); color: #fff; margin: 0; overflow-x: hidden; }

        /* ANIMACIÓN ENTRADA */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-8px); }
        }
        @keyframes pulse-ring {
            0%   { transform: scale(1);   opacity: 0.4; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        @keyframes counter {
            from { opacity: 0; transform: scale(0.8); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .anim-fadeup  { animation: fadeUp 0.7s ease both; }
        .anim-fadein  { animation: fadeIn 0.6s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.35s; }
        .delay-4 { animation-delay: 0.5s; }
        .delay-5 { animation-delay: 0.65s; }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            border-bottom: 1px solid var(--border);
            background: rgba(9,9,11,0.85);
            backdrop-filter: blur(20px);
        }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem; height: 72px;
        }
        .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--yellow); display: flex; align-items: center; justify-content: center;
            animation: float 3s ease-in-out infinite;
        }
        .brand-icon img { width: 28px; height: 28px; object-fit: contain; }
        .brand-name { font-weight: 800; font-size: 1.1rem; color: #fff; }
        .brand-sub  { font-size: 0.65rem; font-weight: 600; color: var(--yellow); letter-spacing: 0.05em; }

        nav a {
            font-size: 0.875rem; color: #a1a1aa;
            text-decoration: none; transition: color 0.2s;
        }
        nav a:hover { color: #fff; }

        .btn-primary {
            background: var(--yellow); color: #000;
            font-weight: 700; font-size: 0.875rem;
            padding: 0.6rem 1.25rem; border-radius: 8px;
            text-decoration: none; border: none; cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary:hover { background: #fde047; transform: translateY(-1px); }

        .btn-ghost {
            background: transparent; color: #d4d4d8;
            font-weight: 500; font-size: 0.875rem;
            padding: 0.6rem 1.25rem; border-radius: 8px;
            text-decoration: none; border: 1px solid var(--border);
            transition: border-color 0.2s, color 0.2s, background 0.2s;
            display: inline-flex; align-items: center;
        }
        .btn-ghost:hover { border-color: rgba(250,204,21,0.3); color: var(--yellow); background: rgba(250,204,21,0.04); }

        /* HERO */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center;
            padding: 120px 2rem 80px;
            position: relative; overflow: hidden;
        }
        .hero-glow {
            position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
            width: 900px; height: 600px; border-radius: 50%;
            background: radial-gradient(ellipse, rgba(250,204,21,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-grid {
            max-width: 1200px; margin: 0 auto; width: 100%;
            display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(250,204,21,0.08); border: 1px solid rgba(250,204,21,0.2);
            border-radius: 100px; padding: 6px 14px;
            font-size: 0.75rem; font-weight: 600; color: var(--yellow);
            margin-bottom: 1.5rem;
        }
        .badge-dot {
            width: 6px; height: 6px; border-radius: 50%; background: var(--yellow);
            position: relative;
        }
        .badge-dot::after {
            content: ''; position: absolute; inset: -3px;
            border-radius: 50%; border: 2px solid var(--yellow);
            animation: pulse-ring 1.5s ease-out infinite;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 900; line-height: 1.05;
            letter-spacing: -0.03em; margin: 0 0 1.25rem;
            color: #fff;
        }
        .hero h1 em {
            font-style: normal;
            background: linear-gradient(135deg, var(--yellow) 0%, #fb923c 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            font-size: 1.1rem; line-height: 1.75;
            color: #71717a; max-width: 480px; margin: 0 0 2rem;
        }
        .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; }

        /* STATS STRIP */
        .stats-strip {
            margin-top: 3rem; padding-top: 2rem;
            border-top: 1px solid var(--border);
            display: flex; gap: 2.5rem;
        }
        .stat-item {}
        .stat-num {
            font-size: 1.75rem; font-weight: 900;
            color: #fff; line-height: 1;
            animation: counter 0.5s ease both;
        }
        .stat-num span { color: var(--yellow); }
        .stat-label { font-size: 0.75rem; color: #52525b; margin-top: 4px; }

        /* PANEL MOCKUP */
        .mockup {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.04);
            animation: float 4s ease-in-out infinite;
        }
        .mockup-bar {
            background: #0d0d0f; border-bottom: 1px solid var(--border);
            padding: 12px 16px; display: flex; align-items: center; gap: 8px;
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .dot-r { background: #ef4444; }
        .dot-y { background: var(--yellow); }
        .dot-g { background: #22c55e; }
        .mockup-url {
            flex: 1; margin-left: 12px; background: rgba(255,255,255,0.04);
            border-radius: 6px; height: 24px;
        }
        .mockup-body { display: flex; min-height: 340px; }
        .mockup-sidebar {
            width: 160px; background: #0a0a0c;
            border-right: 1px solid var(--border); padding: 16px 12px;
            flex-shrink: 0;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 8px; margin-bottom: 20px; padding: 0 4px;
        }
        .sidebar-logo {
            width: 22px; height: 22px; border-radius: 5px;
            background: var(--yellow); display: flex; align-items: center; justify-content: center;
            font-size: 10px;
        }
        .sidebar-name { font-size: 9px; font-weight: 800; color: #fff; }
        .sidebar-item {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 8px; border-radius: 6px;
            font-size: 8px; color: #52525b; margin-bottom: 2px;
        }
        .sidebar-item.active { background: rgba(250,204,21,0.1); color: var(--yellow); }
        .sidebar-dot { width: 3px; height: 3px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

        .mockup-content { flex: 1; padding: 20px; }
        .mc-header { margin-bottom: 16px; }
        .mc-label { font-size: 8px; color: #3f3f46; }
        .mc-title { font-size: 14px; font-weight: 700; color: #fff; margin-top: 2px; }

        .mc-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 12px; }
        .mc-card {
            background: rgba(255,255,255,0.02); border: 1px solid var(--border);
            border-radius: 8px; padding: 10px;
        }
        .mc-card.accent { border-color: rgba(250,204,21,0.15); background: rgba(250,204,21,0.03); }
        .mc-card-label { font-size: 7px; color: #52525b; }
        .mc-card-val { font-size: 16px; font-weight: 800; color: #fff; margin: 4px 0 2px; }
        .mc-card.accent .mc-card-val { color: var(--yellow); }
        .mc-card-change { font-size: 6px; color: #22c55e; }

        .mc-chart { background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 8px; padding: 12px; }
        .mc-chart-label { font-size: 7px; color: #52525b; margin-bottom: 10px; }
        .mc-bars { display: flex; align-items: flex-end; gap: 3px; height: 60px; }
        .mc-bar {
            flex: 1; border-radius: 2px 2px 0 0;
            background: linear-gradient(to top, rgba(250,204,21,0.2), var(--yellow));
        }

        /* FEATURES */
        .section { padding: 100px 2rem; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-header { text-align: center; margin-bottom: 64px; }
        .section-header h2 {
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 800; letter-spacing: -0.02em;
            color: #fff; margin: 0 0 1rem;
        }
        .section-header p { color: #71717a; font-size: 1rem; max-width: 500px; margin: 0 auto; }

        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px;
            background: var(--border); border-radius: 16px; overflow: hidden;
            border: 1px solid var(--border);
        }
        .feature-card {
            background: var(--bg); padding: 2rem;
            transition: background 0.25s;
            position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--yellow), transparent);
            opacity: 0; transition: opacity 0.3s;
        }
        .feature-card:hover { background: var(--surface); }
        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            width: 48px; height: 48px; border-radius: 12px;
            background: rgba(250,204,21,0.08); border: 1px solid rgba(250,204,21,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; margin-bottom: 1.25rem;
            transition: background 0.25s, transform 0.25s;
        }
        .feature-card:hover .feature-icon {
            background: rgba(250,204,21,0.15); transform: scale(1.05);
        }
        .feature-card h3 { font-size: 1rem; font-weight: 700; color: #fff; margin: 0 0 0.5rem; }
        .feature-card p  { font-size: 0.875rem; color: #52525b; line-height: 1.65; margin: 0; }

        /* MODULES */
        .modules-section {
            padding: 100px 2rem;
            background: var(--bg2);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .modules-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
        .modules-text h2 { font-size: clamp(1.75rem, 3vw, 2.25rem); font-weight: 800; letter-spacing: -0.02em; color: #fff; margin: 0 0 1rem; }
        .modules-text p  { color: #71717a; line-height: 1.75; margin: 0 0 2rem; }

        .modules-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .module-pill {
            display: flex; align-items: center; gap: 10px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 10px; padding: 12px 16px;
            font-size: 0.875rem; color: #a1a1aa;
            transition: border-color 0.2s, color 0.2s, transform 0.2s;
            cursor: default;
        }
        .module-pill:hover {
            border-color: rgba(250,204,21,0.25); color: var(--yellow);
            transform: translateX(3px);
        }
        .module-pill-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--yellow); flex-shrink: 0; }

        /* CTA */
        .cta-section { padding: 100px 2rem; }
        .cta-inner { max-width: 800px; margin: 0 auto; text-align: center; }
        .cta-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px; padding: 64px 48px;
            position: relative; overflow: hidden;
        }
        .cta-glow {
            position: absolute; top: -60px; left: 50%; transform: translateX(-50%);
            width: 400px; height: 200px; border-radius: 50%;
            background: radial-gradient(ellipse, rgba(250,204,21,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .cta-icon {
            width: 64px; height: 64px; border-radius: 16px;
            background: var(--yellow); margin: 0 auto 1.5rem;
            display: flex; align-items: center; justify-content: center; font-size: 1.75rem;
        }
        .cta-box h2 { font-size: clamp(1.75rem, 3vw, 2.25rem); font-weight: 800; letter-spacing: -0.02em; color: #fff; margin: 0 0 1rem; }
        .cta-box p  { color: #71717a; margin: 0 0 2rem; line-height: 1.75; }

        /* FOOTER */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem;
        }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-inner p { font-size: 0.8rem; color: #3f3f46; margin: 0; }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .hero-grid    { grid-template-columns: 1fr; gap: 48px; }
            .mockup       { display: none; }
            .features-grid { grid-template-columns: 1fr 1fr; }
            .modules-inner { grid-template-columns: 1fr; gap: 40px; }
            nav           { display: none; }
        }
        @media (max-width: 600px) {
            .features-grid { grid-template-columns: 1fr; }
            .modules-grid  { grid-template-columns: 1fr; }
            .stats-strip   { gap: 1.5rem; }
            .cta-box       { padding: 40px 24px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<header class="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="brand">
            <div class="brand-icon">
                <img src="{{ asset('favicon-192x192.png') }}" alt="ClassHub">
            </div>
            <div>
                <div class="brand-name">{{ config('app.name', 'ClassHub') }}</div>
                <div class="brand-sub">Gestión Académica</div>
            </div>
        </a>

        <nav style="display:flex;align-items:center;gap:2rem;">
            <a href="#caracteristicas">Características</a>
            <a href="#modulos">Módulos</a>
            <a href="#plataforma">Plataforma</a>
        </nav>

        <div style="display:flex;align-items:center;gap:10px;">
            @auth
                <a href="{{ filament()->getUrl() }}" class="btn-ghost">Panel</a>
                <form method="POST" action="{{ filament()->getLogoutUrl() }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-primary">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ filament()->getLoginUrl() }}" class="btn-primary">Iniciar sesión</a>
            @endauth
        </div>
    </div>
</header>

<main>

{{-- HERO --}}
<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-grid">

        <div>
            <div class="hero-badge anim-fadeup delay-1">
                <span class="badge-dot"></span>
                Plataforma académica moderna
            </div>

            <h1 class="anim-fadeup delay-2">
                Administra tu institución <em>sin complicaciones</em>
            </h1>

            <p class="anim-fadeup delay-3">
                Estudiantes, profesores, horarios, calificaciones y más — todo centralizado en un solo sistema rápido y organizado.
            </p>

            <div class="hero-cta anim-fadeup delay-4">
                @auth
                    <a href="{{ filament()->getUrl() }}" class="btn-primary">
                        Ir al panel
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </a>
                @else
                    <a href="{{ filament()->getLoginUrl() }}" class="btn-primary">
                        Acceder ahora
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </a>
                @endauth
                <a href="#modulos" class="btn-ghost">Ver módulos</a>
            </div>

            <div class="stats-strip anim-fadeup delay-5">
                <div class="stat-item">
                    <div class="stat-num">13<span>+</span></div>
                    <div class="stat-label">Módulos integrados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">100<span>%</span></div>
                    <div class="stat-label">En español</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">1<span>k+</span></div>
                    <div class="stat-label">Registros gestionados</div>
                </div>
            </div>
        </div>

        {{-- MOCKUP --}}
        <div class="anim-fadein delay-3">
            <div class="mockup">
                <div class="mockup-bar">
                    <span class="dot dot-r"></span>
                    <span class="dot dot-y"></span>
                    <span class="dot dot-g"></span>
                    <div class="mockup-url"></div>
                </div>
                <div class="mockup-body">
                    <div class="mockup-sidebar">
                        <div class="sidebar-brand">
                            <div class="sidebar-logo">🎓</div>
                            <span class="sidebar-name">ClassHub</span>
                        </div>
                        @php $items = ['Escritorio','Horarios','Inscripciones','Eventos','Grados','Grupos','Calificaciones','Estudiantes','Materias','Tareas','Profesores']; @endphp
                        @foreach($items as $item)
                            <div class="sidebar-item {{ $item === 'Estudiantes' ? 'active' : '' }}">
                                <span class="sidebar-dot"></span>{{ $item }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mockup-content">
                        <div class="mc-header">
                            <div class="mc-label">Gestión académica</div>
                            <div class="mc-title">Estudiantes</div>
                        </div>
                        <div class="mc-cards">
                            <div class="mc-card">
                                <div class="mc-card-label">Estudiantes</div>
                                <div class="mc-card-val">1,248</div>
                                <div class="mc-card-change">+12.5%</div>
                            </div>
                            <div class="mc-card">
                                <div class="mc-card-label">Profesores</div>
                                <div class="mc-card-val">86</div>
                                <div class="mc-card-change">+4.2%</div>
                            </div>
                            <div class="mc-card accent">
                                <div class="mc-card-label">Promedio</div>
                                <div class="mc-card-val">87.4%</div>
                                <div class="mc-card-change">+3.8%</div>
                            </div>
                        </div>
                        <div class="mc-chart">
                            <div class="mc-chart-label">Rendimiento académico</div>
                            <div class="mc-bars">
                                @foreach([35,48,42,65,55,72,68,85,76,92,82,96] as $h)
                                    <div class="mc-bar" style="height:{{ $h }}%"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- CARACTERÍSTICAS --}}
<section class="section" id="caracteristicas" style="border-top:1px solid var(--border);">
    <div class="section-inner">
        <div class="section-header">
            <h2>Todo lo que tu institución necesita</h2>
            <p>Una plataforma completa para administrar cada proceso académico desde un solo lugar.</p>
        </div>

        <div class="features-grid">
            @php
            $features = [
                ['icon'=>'👥','title'=>'Estudiantes','desc'=>'Perfiles completos, historial académico y seguimiento por período.'],
                ['icon'=>'🎓','title'=>'Profesores','desc'=>'Gestión de docentes, asignaciones por materia y grupo.'],
                ['icon'=>'📊','title'=>'Calificaciones','desc'=>'Notas, evaluaciones y rendimiento en tiempo real.'],
                ['icon'=>'📚','title'=>'Materias','desc'=>'Catálogo de materias por grado con horarios asignados.'],
                ['icon'=>'✅','title'=>'Tareas','desc'=>'Crea entregas, revisa avances y controla fechas límite.'],
                ['icon'=>'📅','title'=>'Eventos','desc'=>'Agenda académica centralizada para toda la institución.'],
            ];
            @endphp
            @foreach($features as $f)
            <div class="feature-card">
                <div class="feature-icon">{{ $f['icon'] }}</div>
                <h3>{{ $f['title'] }}</h3>
                <p>{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MÓDULOS --}}
<section class="modules-section" id="modulos">
    <div class="modules-inner">
        <div class="modules-text">
            <h2>13 módulos, una sola plataforma</h2>
            <p>Desde la inscripción hasta las calificaciones finales. Cada proceso académico tiene su lugar, sin hojas de cálculo ni papeles sueltos.</p>
            @auth
                <a href="{{ filament()->getUrl() }}" class="btn-primary">Abrir panel</a>
            @else
                <a href="{{ filament()->getLoginUrl() }}" class="btn-primary">Comenzar</a>
            @endauth
        </div>
        <div class="modules-grid">
            @foreach(['Estudiantes','Profesores','Grupos','Grados','Materias','Horarios de clases','Calificaciones','Tareas','Entregas de tareas','Inscripciones','Eventos','Usuarios','Roles y permisos'] as $m)
            <div class="module-pill">
                <span class="module-pill-dot"></span>{{ $m }}
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section" id="plataforma">
    <div class="cta-inner">
        <div class="cta-box">
            <div class="cta-glow"></div>
            <div style="position:relative;">
                <div class="cta-icon">🎓</div>
                <h2>Tu institución, organizada desde hoy</h2>
                <p>Una experiencia administrativa moderna, construida para crecer con tu institución.</p>
                @auth
                    <a href="{{ filament()->getUrl() }}" class="btn-primary" style="font-size:1rem;padding:0.875rem 2rem;">Ir al panel</a>
                @else
                    <a href="{{ filament()->getLoginUrl() }}" class="btn-primary" style="font-size:1rem;padding:0.875rem 2rem;">Iniciar sesión</a>
                @endauth
            </div>
        </div>
    </div>
</section>

</main>

<footer>
    <div class="footer-inner">
        <p>© {{ date('Y') }} {{ config('app.name', 'ClassHub') }} — Gestión Académica</p>
        <p>Laravel · Filament</p>
    </div>
</footer>

</body>
</html>
