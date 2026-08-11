<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Models\Teacher;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // =========================================================
                // CUENTA DE USUARIO
                // =========================================================
                Section::make('Cuenta de usuario')
                    ->description(
                        'Selecciona el usuario que será registrado como docente.'
                    )
                    ->icon('heroicon-o-user-circle')
                    ->schema([

                        Select::make('user_id')
                            ->label('Usuario')
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name'
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (User $record): string =>
                                    "{$record->name} - {$record->email}"
                            )
                            ->searchable(['name', 'email'])
                            ->preload()
                            ->required()
                            ->native(false)
                            ->live()
                            ->prefixIcon('heroicon-o-user')
                            ->helperText(
                                'Busca el usuario por nombre o correo electrónico.'
                            )
                            ->afterStateUpdated(
                                function ($state, callable $set, $livewire) {

                                    // No hay usuario seleccionado
                                    if (!$state) {
                                        $set('document', null);
                                        return;
                                    }

                                    // Buscar usuario
                                    $user = User::find($state);

                                    if (!$user) {
                                        $set('document', null);
                                        return;
                                    }

                                    // =================================================
                                    // VERIFICAR SI YA ES DOCENTE
                                    // =================================================
                                    $query = Teacher::where(
                                        'user_id',
                                        $state
                                    );

                                    // Si estamos editando, ignorar el registro actual
                                    if ($livewire->record) {
                                        $query->where(
                                            'id',
                                            '!=',
                                            $livewire->record->id
                                        );
                                    }

                                    if ($query->exists()) {

                                        Notification::make()
                                            ->title('Usuario ya registrado')
                                            ->body(
                                                'Este usuario ya está registrado como docente.'
                                            )
                                            ->danger()
                                            ->send();

                                        $set('user_id', null);
                                        $set('document', null);

                                        return;
                                    }

                                    // =================================================
                                    // CARGAR DOCUMENTO DEL USUARIO
                                    // =================================================
                                    if (!empty($user->document)) {

                                        $set(
                                            'document',
                                            $user->document
                                        );

                                    } else {

                                        $set('document', null);

                                        Notification::make()
                                            ->title('Usuario sin documento')
                                            ->body(
                                                'Este usuario no tiene un documento registrado en su cuenta.'
                                            )
                                            ->warning()
                                            ->send();
                                    }
                                }
                            )
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->collapsible(),

                // =========================================================
                // INFORMACIÓN PERSONAL
                // =========================================================
                Section::make('Información personal')
                    ->description(
                        'Datos personales y de identificación del docente.'
                    )
                    ->icon('heroicon-o-identification')
                    ->schema([

                        TextInput::make('document')
                            ->label('Documento de identidad')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(30)
                            ->prefixIcon('heroicon-o-identification')
                            ->placeholder('Ej. 1234567890')
                            ->helperText(
                                'Se carga automáticamente desde la cuenta de usuario.'
                            )
                            ->readOnly(),

                    ])
                    ->columns(1)
                    ->collapsible(),

                // =========================================================
                // INFORMACIÓN PROFESIONAL
                // =========================================================
                Section::make('Información profesional')
                    ->description(
                        'Información académica y profesional del docente.'
                    )
                    ->icon('heroicon-o-academic-cap')
                    ->schema([

                        TextInput::make('specialty')
                            ->label('Especialidad')
                            ->maxLength(150)
                            ->prefixIcon('heroicon-o-academic-cap')
                            ->placeholder(
                                'Ej. Matemáticas, Inglés, Ciencias'
                            )
                            ->helperText(
                                'Área o especialidad principal del docente.'
                            ),

                        TextInput::make('professional_title')
                            ->label('Título profesional')
                            ->maxLength(150)
                            ->prefixIcon('heroicon-o-briefcase')
                            ->placeholder(
                                'Ej. Ingeniero de Sistemas'
                            )
                            ->helperText(
                                'Título académico o profesional.'
                            ),

                        DatePicker::make('hire_date')
                            ->label('Fecha de vinculación')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->placeholder('Selecciona una fecha')
                            ->helperText(
                                'Fecha en la que el docente ingresó a la institución.'
                            ),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->collapsible(),

                // =========================================================
                // ESTADO
                // =========================================================
                Section::make('Estado del perfil')
                    ->description(
                        'Información visual del estado del registro.'
                    )
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        Placeholder::make('profile_status')
                            ->label('Estado')
                            ->content('✓ Perfil activo'),

                    ])
                    ->collapsible()
                    ->collapsed(),

            ]);
    }
}