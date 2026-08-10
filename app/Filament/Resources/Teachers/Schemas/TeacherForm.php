<?php

namespace App\Filament\Resources\Teachers\Schemas;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del docente')
                    ->description('Datos básicos y perfil profesional del docente.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Select::make('user_id')
                            ->label('Usuario')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-user')
                            ->helperText('Selecciona la cuenta de usuario asociada al docente.')
                            ->columnSpanFull(),

                        TextInput::make('document')
                            ->label('Documento de identidad')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(30)
                            ->prefixIcon('heroicon-o-identification')
                            ->placeholder('Ej. 1234567890')
                            ->helperText('Número de documento del docente.'),

                        TextInput::make('specialty')
                            ->label('Especialidad')
                            ->maxLength(150)
                            ->prefixIcon('heroicon-o-academic-cap')
                            ->placeholder('Ej. Matemáticas, Inglés, Ciencias...')
                            ->helperText('Área o especialidad principal.'),

                        TextInput::make('professional_title')
                            ->label('Título profesional')
                            ->maxLength(150)
                            ->prefixIcon('heroicon-o-briefcase')
                            ->placeholder('Ej. Ingeniero de Sistemas')
                            ->helperText('Título académico o profesional.'),

                        DatePicker::make('hire_date')
                            ->label('Fecha de vinculación')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->placeholder('Selecciona una fecha')
                            ->helperText('Fecha en la que el docente ingresó a la institución.'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->collapsible(),

                Section::make('Estado del perfil')
                    ->description('Información visual del estado del registro.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('profile_status')
                            ->label('Estado')
                            ->content('✓ Perfil activo'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
