<?php

declare(strict_types=1);

namespace App\Data\Cashier;

readonly class Plan
{
    private function __construct(
        private string $type,
        private string $name,
        private string $shortDescription,
        private string $productId,
        private array $rawPrices,
        private array $features
    ) {
    }

    public static function fromArray(array $data, string $key): self
    {
        return new self(
            type: $data['type'] ?? $key,
            name: $data['name'],
            shortDescription: $data['short_description'],
            productId: $data['product_id'],
            rawPrices: $data['prices'],
            features: $data['features']
        );
    }

    public function type(): string
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function shortDescription(): string
    {
        return $this->shortDescription;
    }

    public function productId(): string
    {
        return $this->productId;
    }

    /**
     * @return array<Price>
     */
    public function prices(): array
    {
        return array_map(
            fn (array $price, string $key) => Price::fromArray($price, $key),
            $this->rawPrices,
            array_keys($this->rawPrices)
        );
    }

    public function features(): array
    {
        return $this->features;
    }
}
