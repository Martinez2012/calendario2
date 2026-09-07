<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Group;
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
                                    $query->where(function ($query) use ($livewire) {
                                        $query->whereDoesntHave('teacher');

                                        // Al editar, permitir mantener el usuario actual
                                        if ($livewire->record) {
                                            $query->orWhere(
                                                'id',
                                                $livewire->record->user_id
                                            );
                                        }
                                    });
                                }
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (User $record): string =>
                                    "{$record->name} - {$record->document}"
                            )
                            ->searchable(['name', 'email', 'document'])
                            ->preload()
                            ->required()
                            ->native(false)
                            ->live()
                            ->prefixIcon('heroicon-o-user')
                            ->helperText(
                                'Busca el usuario por nombre, correo o documento.'
                            )
                            ->afterStateUpdated(function ($state, callable $set, $livewire) {

                                if (! $state) {
                                    $set('document', null);

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
                                    $set('document', null);

                                    return;
                                }

                                // Autocompleta el documento a partir del usuario seleccionado
                                $set('document', User::find($state)?->document);

                                // Enfocar automáticamente el siguiente campo relevante
                                $livewire->dispatch('focus-student-birthdate');
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
                            ->maxLength(30)
                            ->prefixIcon('heroicon-o-identification')
                            ->placeholder('Ej. 1234567890')
                            ->helperText(
                                'Escribe el documento para buscar al usuario, o selecciónalo arriba.'
                            )
                            ->live(onBlur: true)
                            ->dehydrated(false) // el documento vive en users, no en students
                            ->afterStateHydrated(function ($component, $record) {
                                $component->state($record?->user?->document);
                            })
                            ->afterStateUpdated(function ($state, callable $set, callable $get, $livewire) {

                                if (blank($state)) {
                                    return;
                                }

                                $user = User::where('document', $state)->first();

                                if (! $user) {
                                    Notification::make()
                                        ->title('Documento no encontrado')
                                        ->body('No existe ningún usuario con ese documento.')
                                        ->warning()
                                        ->send();

                                    return;
                                }

                                if ($user->id === $get('user_id')) {
                                    // Ya es el usuario seleccionado, nada que hacer
                                    return;
                                }

                                if ($user->teacher) {
                                    Notification::make()
                                        ->title('Usuario no válido')
                                        ->body('Este usuario ya está registrado como profesor.')
                                        ->danger()
                                        ->send();

                                    $set('document', null);

                                    return;
                                }

                                $query = Student::where('user_id', $user->id);

                                if ($livewire->record) {
                                    $query->where('id', '!=', $livewire->record->id);
                                }

                                if ($query->exists()) {
                                    Notification::make()
                                        ->title('Usuario ya registrado')
                                        ->body('Este usuario ya está registrado como estudiante.')
                                        ->danger()
                                        ->send();

                                    $set('document', null);

                                    return;
                                }

                                $set('user_id', $user->id);
                            })
                            ->extraAlpineAttributes([
                                'x-on:focus-student-document.window' =>
                                    '$nextTick(() => $el.focus())',
                            ]),

                        DatePicker::make('birth_date')
                            ->label('Fecha de nacimiento')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->prefixIcon('heroicon-o-calendar-days')
                            ->extraAlpineAttributes([
                                'x-on:focus-student-birthdate.window' =>
                                    '$nextTick(() => $el.focus())',
                            ]),

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
                            ->maxLength(50)
                            ->prefixIcon('heroicon-o-identification')
                            ->disabled()
                            ->placeholder('Se asignará automáticamente al guardar')
                            ->helperText('Este código se genera automáticamente y no se puede modificar.'),

                        Select::make('group_id')
                            ->label('Grupo (' . now()->year . ')')
                            ->options(fn () => Group::with('grade')->get()->mapWithKeys(
                                fn (Group $group) => [$group->id => $group->name]
                            ))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-user-group')
                            ->helperText('Matrícula del estudiante para el año escolar actual.')
                            ->afterStateHydrated(function ($component, $record) {
                                $component->state(
                                    $record?->enrollments()
                                        ->where('school_year', now()->year)
                                        ->first()
                                        ?->group_id
                                );
                            }),

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