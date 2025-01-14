<?php

declare(strict_types=1);

namespace App\Livewire;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasUser;
use Livewire\Component;

class ColorProfileComponent extends Component implements HasForms
{
    use InteractsWithForms;
    use HasSort;
    use HasUser;

    public ?array $data = [];

    public $userClass;

    protected static int $sort = 30;

    public function mount(): void
    {
        $this->user = $this->getUser();
        $this->userClass = get_class($this->user);
        $this->form->fill($this->user->only('settings'));

    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Cor do Tema')
                    ->aside()
                    ->description('Escolha a cor do tema')
                    ->schema([

                        ColorPicker::make('settings.color')
                            ->label('Cor do tema')
                            ->columnSpanFull()
                            ->inLineLabel()
                            ->default('#f59e0b'),
                    ]),

            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $this->user->update($data);

        redirect((request()->header('referer')));
    }

    protected function afterSave(): void
    {
        redirect((request()->header('referer')));
    }

    public function render(): View
    {
        return view('livewire.color-profile-component');
    }
}
