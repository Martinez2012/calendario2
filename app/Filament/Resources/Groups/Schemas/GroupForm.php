<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('grade_id')
                    ->label('Grado')
                    ->relationship(name: 'grade', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-academic-cap'),

                TextInput::make('name')
                    ->label('Nombre del grupo')
                    ->required()
                    ->maxLength(20)
                    ->placeholder('Ej. 1er Grado A')
                    ->unique(
                        ignoreRecord: true,
                        modifyRuleUsing: fn (Unique $rule, callable $get) =>
                            $rule->where('grade_id', $get('grade_id')),
                    )
                    ->validationMessages([
                        'unique' => 'Ya existe un grupo con este nombre en el grado seleccionado.',
                    ]),

            ]);
    }
}