<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductResource\RelationManagers;

use App\Enums\Stripe\ProductCurrencyEnum;
use App\Enums\Stripe\ProductIntervalEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Env;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Stripe\StripeClient;

class PricesRelationManager extends RelationManager
{
    protected static string $relationship = 'prices';

    protected static ?string $modelLabel = 'Preço';

    protected static ?string $modelLabelPlural = 'Preço';

    protected static ?string $title = 'Valores dos Produtos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
              Select::make('currency')
                ->label('Moeda')
                ->required()
                ->searchable()
                ->options(ProductCurrencyEnum::class),

                Select::make('interval')
                    ->label('Intervalo de Cobrança')
                    ->options(ProductIntervalEnum::class)
                    ->searchable()
                    ->required(),

                Money::make('unit_amount')
                    ->label('Preço')
                    ->default('100,00')
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('price')
            ->columns([
               TextColumn::make('stripe_price_id')
                    ->label('Id Gateway Pagamento')
                    ->sortable(),

               TextColumn::make('currency')
                    ->label('Moeda')
                    ->badge()
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('interval')
                    ->label('Intervalo de Cobrança')
                    ->badge()
                    ->sortable()
                    ->alignCenter(),

                ToggleColumn::make('is_active')
                    ->label('Ativo para cliente')
                    ->alignCenter(),

                TextColumn::make('unit_amount')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(function ($record) {
                    // Obtém o produto relacionado
                    $product_id = $record->product->stripe_id;

                    // Chamada para a API após criação do item
                    $unitAmount = (int) (str_replace(',', '', $record->unit_amount) * 100);

                    $stripe = new StripeClient(Env::get('STRIPE_SECRET'));
                    $stripePrice = $stripe->prices->create([
                      'currency' => $record->currency->value,
                      'unit_amount' => $unitAmount,
                      'recurring' => ['interval' => $record->interval->value],
                      'product' => $product_id,
                    ]);

                    $record->update([
                        'stripe_price_id' => $stripePrice->id,
                    ]);
                    $record->save();
                }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([

            ]);
    }
}
