<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts;
use Filament\Forms\Components\Field;

class RadioGroup extends Field implements Contracts\CanDisableOptions
{
    use Concerns\CanDisableOptions;
    use Concerns\CanDisableOptionsWhenSelectedInSiblingRepeaterItems;
    use Concerns\CanFixIndistinctState;
    use Concerns\HasDescriptions;
    use Concerns\HasExtraInputAttributes;
    use Concerns\HasGridDirection;
    use Concerns\HasOptions;

    protected string $view = 'forms.components.radio-group';

    protected bool | Closure $isInline = false;

    protected array | Closure $badges = [];

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function badges(array | Closure $badges): static
    {
        $this->badges = $badges;

        return $this;
    }

    public function getBadges(): array
    {
        return $this->evaluate($this->badges);
    }

    public function hasBadge($value): bool
    {
        return array_key_exists($value, $this->getBadges());
    }

    public function getBadge($value): ?string
    {
        return $this->getBadges()[$value] ?? null;
    }

    public function boolean(?string $trueLabel = null, ?string $falseLabel = null): static
    {
        $this->options([
            1 => $trueLabel ?? __('filament-forms::components.radio.boolean.true'),
            0 => $falseLabel ?? __('filament-forms::components.radio.boolean.false'),
        ]);

        return $this;
    }

    public function inline(bool | Closure $condition = true): static
    {
        $this->isInline = $condition;
        $this->inlineLabel(fn (RadioGroup $component): ?bool => $component->evaluate($condition) ? true : null);

        return $this;
    }

    public function isInline(): bool
    {
        return (bool) $this->evaluate($this->isInline);
    }

    public function getDefaultState(): mixed
    {
        $state = parent::getDefaultState();

        if (is_bool($state)) {
            return $state ? 1 : 0;
        }

        return $state;
    }
}
