<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/api/calendar-events', [\App\Filament\Widgets\CalendarioWidget::class, 'handleRequest'])
    ->middleware(['web', 'auth']);

