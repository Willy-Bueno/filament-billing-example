<?php

declare(strict_types=1);

namespace App\Filament\Pages\Team;

use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return __('Registrar Equipe');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Nome'))
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, RegisterTeam $livewire) {
                        if (blank($get('slug'))) {
                            $set('slug', str($state)->slug());
                            $livewire->validateOnly('data.slug');
                        }
                    })
                    ->required(),
                TextInput::make('slug')
                    ->label(__('Slug'))
                    ->live()
                    ->afterStateUpdated(function (RegisterTenant $livewire, ?string $state, TextInput $component) {
                        $component->state(str($state)->slug());
                        $livewire->validateOnly($component->getStatePath());
                    })
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data);

        $team->members()->attach(auth()->user());

        return $team;
    }
}
