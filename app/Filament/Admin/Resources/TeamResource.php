<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TeamResource\Pages;
use App\Filament\Admin\Resources\TeamResource\RelationManagers\SubscriptionRelationManager;
use App\Filament\Admin\Resources\TeamResource\RelationManagers\UserRelationManager;
use App\Models\Team;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Leandrocfe\FilamentPtbrFormFields\Document;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?string $navigationLabel = 'Tenant';

    protected static ?string $modelLabel = 'Tenant';

    protected static ?string $modelLabelPlural = 'Tenants';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Label')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome da Empresa')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            })
                            ->maxLength(255),

                        Document::make('document_number')
                            ->label('Documento da Empresa (CPF ou CNPJ)')
                            ->validation(false)
                            ->required()
                            ->dynamic(),

                        TextInput::make('slug')
                            ->label('URL da Empresa')
                            ->readonly(),
                    ])->columns(3),

                Fieldset::make('Dados de Validade')
                    ->schema([
                        TextInput::make('stripe_id')
                            ->label('Id Gateway Pagamento')
                            ->readOnly()
                            ->maxLength(255),

                        DateTimePicker::make('trial_ends_at')
                            ->label('Data de Expiração Teste'),

                        DateTimePicker::make('trial_ends_at')
                            ->label('Valido Até'),

                    ])->columns(3),

                Fieldset::make('Dados Sistemicos')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Tenant Ativo')
                            ->default(true)
                            ->required(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Cliente')
                    ->searchable(),

                TextColumn::make('document_number')
                    ->label('Documento')
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Url Tenant')
                    ->searchable(),

                ToggleColumn::make('is_active')
                    ->alignCenter()
                    ->label('Tenant Ativo'),

                TextColumn::make('stripe_id')
                    ->label('Id Gateway Pagamento')
                    ->searchable(),

                TextColumn::make('trial_ends_at')
                    ->label('Data de Expiração')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:m:s')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserRelationManager::class,
            SubscriptionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'view' => Pages\ViewTeam::route('/{record}'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
