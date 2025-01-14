<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TeamResource\RelationManagers;

use App\Enums\Stripe\SubscriptionStatusEnum;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Env;
use Stripe\StripeClient;

class SubscriptionRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    protected static ?string $modelLabel = 'Assinatura';

    protected static ?string $modelLabelPlural = 'Assinaturas';

    protected static ?string $title = 'Subscrições do Tenant';

    public function table(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('stripe_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => SubscriptionStatusEnum::from($state)->getLabel())
                    ->color(fn ($state) => SubscriptionStatusEnum::from($state)->getColor())
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Plano'),

                TextColumn::make('stripe_id')
                    ->label('Id Gateway Pagamento'),

                TextColumn::make('stripe_price')
                    ->label('Valor do Plano'),

                TextColumn::make('ends_at')
                    ->label('Data de Expiração')
                    ->dateTime('d/m/Y H:m:s'),

            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->actions([
                ActionGroup::make([
                Action::make('Cancelar Assinatura')
                ->requiresConfirmation()
                ->action(function (Action $action, $record) {
                    try {
                        $stripe = new StripeClient(Env::get('STRIPE_SECRET'));
                        $stripe->subscriptions->cancel($record->stripe_id);
                        Notification::make()
                            ->title('Assinatura Cancelada')
                            ->body('Assinatura cancelada com sucesso!')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Erro ao Cancelar')
                            ->body('Ocorreu um erro ao cancelar a assinatura. Tente novamente mais tarde.')
                            ->danger()
                            ->send();
                    }
                })
                ->color('danger')
                ->icon('heroicon-o-key'),
        ]),
            ])

            ->bulkActions([

            ]);

    }
}
