<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Cuenta de usuario')
                    ->description('Selecciona el usuario que será registrado como estudiante.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([

                        Select::make('user_id')
                            ->label('Usuario')
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                                modifyQueryUsing: function ($query, $livewire) {
                                    $query->whereDoesntHave('student');

                                    // Al editar, permitir mantener el usuario actual
                                    if ($livewire->record) {
                                        $query->orWhere(
                                            'id',
                                            $livewire->record->user_id
                                        );
                                    }
                                }
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (User $record): string =>
                                    "{$record->name} - {$record->email}"
                            )
                            ->searchable(['name', 'email'])
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-user')
                            ->helperText(
                                'Busca el usuario por nombre o correo electrónico.'
                            )
                            ->afterStateUpdated(function ($state, callable $set, $livewire) {

                                if (!$state) {
                                    return;
                                }

                                $query = Student::where('user_id', $state);

                                // Si estamos editando, ignorar el estudiante actual
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
                                            'Este usuario ya está registrado como estudiante.'
                                        )
                                        ->danger()
                                        ->send();

                                    $set('user_id', null);
                                }
                            })
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Información personal')
                    ->description('Datos personales y de identificación del estudiante.')
                    ->icon('heroicon-o-identification')
                    ->schema([

                        TextInput::make('document')
                            ->label('Documento')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(30)
                            ->prefixIcon('heroicon-o-identification')
                            ->placeholder('Ej. 1234567890'),

                        DatePicker::make('birth_date')
                            ->label('Fecha de nacimiento')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->prefixIcon('heroicon-o-calendar-days'),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->collapsible(),

                Section::make('Información académica')
                    ->description('Datos utilizados para identificar al estudiante.')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([

                        TextInput::make('student_code')
                            ->label('Código estudiantil')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->prefixIcon('heroicon-o-identification')
                            ->placeholder('Ej. EST-001'),

                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Acudiente')
                    ->description('Información de contacto del acudiente o representante.')
                    ->icon('heroicon-o-users')
                    ->schema([

                        TextInput::make('guardian_name')
                            ->label('Nombre del acudiente')
                            ->maxLength(150)
                            ->prefixIcon('heroicon-o-user')
                            ->placeholder('Ej. Carlos Pérez'),

                        TextInput::make('guardian_phone')
                            ->label('Teléfono del acudiente')
                            ->tel()
                            ->maxLength(30)
                            ->prefixIcon('heroicon-o-phone')
                            ->placeholder('Ej. 3001234567'),

                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->collapsible(),

                Section::make('Estado')
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