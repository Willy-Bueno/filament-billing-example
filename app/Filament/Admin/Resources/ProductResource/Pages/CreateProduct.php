<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Env;
use Stripe\StripeClient;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Acessando os dados do formulário
        $name = $data['name'];  // Valor do campo 'name'
        $description = $data['description'];  // Valor do campo 'description'

        // Configuração da Stripe
        $stripe = new StripeClient(Env::get('STRIPE_SECRET'));

        // Criando o produto na Stripe
        $stripeProduct = $stripe->products->create([
            'name' => $name,
            'description' => $description,
        ]);

        // Recuperar o ID e o objeto do produto criado na Stripe
        $stripeProductId = $stripeProduct->id;

        // Adicionar o ID e objeto da Stripe ao array de dados
        $data['stripe_id'] = $stripeProductId;

        // Retorna os dados para o banco de dados
        return $data;
    }

    protected function afterCreate(): void
    {
        // Acessa os dados que já foram manipulados no mutateFormDataBeforeCreate
        $stripeProductId = $this->record->stripe_id;

        // Atualiza o banco de dados com as informações da Stripe
        $this->record->stripe_id = $stripeProductId;

        // Salva as alterações no banco de dados
        $this->record->save();
    }
}
