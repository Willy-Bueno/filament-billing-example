<?php

declare(strict_types=1);

namespace App\Filament\Pages\Team;

use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

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
                ->label('Nome da Empresa')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(function (Set $set, $state) {
                    $set('slug', Str::slug($state));
                }),

            TextInput::make('email')
                ->label('E-mail Principal')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            PhoneNumber::make('phone')
                ->label('Celular da Empresa')
                ->required()
                ->mask('(99) 99999-9999'),

            Document::make('document_number')
                ->label('Documento da Empresa (CPF ou CNPJ)')
                ->validation(false)
                ->required()
                ->dynamic(),

            TextInput::make('slug')
                ->label('Essa será a URL da sua empresa')
                ->readonly(),
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data);

        $team->members()->attach(Auth::user());

        return $team;
    }
}
