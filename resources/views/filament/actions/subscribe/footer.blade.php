@php
    use App\Data\Cashier\Stripe;
@endphp

<div class="mt-2" x-data="{
    state: $wire.$entangle('mountedActionsData.0.billing_period'),
    formatPrice: price => `R$${(price/100).toFixed(2)}`,}">

    <div class="pb-[76px]">
        <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">
            What you get
        </h2>

        <div class="space-y-4">
            @foreach (Stripe::fromConfig()->plans()[0]->features() as $feature)
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <x-heroicon-m-check-circle class="size-5 text-primary-500" />
                    </div>

                    <span class="text-gray-900 dark:text-white text-sm text-left">
                        {{ $feature }}
                    </span>
                </div>
            @endforeach
            <br>
           

        </div>
     
     
    </div>
    <div class="relative rounded-b-xl bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <!-- Preço e informações -->
        <div class="px-10 py-4">
            <div class="flex flex-wrap items-baseline gap-1">
                @foreach (Stripe::fromConfig()->plans()[0]->prices() as $price)
                    <template x-if="state === '{{ $price->period() }}'">
                        <div class="flex items-baseline gap-1 w-full">
                            <span class="text-3xl font-semibold text-gray-900 dark:text-white"
                                x-text="formatPrice({{ $price->period() === 'yearly' ? $price->price() / 12 : $price->price() }})"></span>
                            <span class="text-sm text-gray-500 dark:text-gray-400"> / Mês </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400"
                                x-text="formatPrice({{ $price->price() }}) + ' por {{ $price->period() }}'"></span>
                        </div>
                    </template>
                @endforeach
            </div>
        </div>
    
        <!-- Botão centralizado, abaixo do preço, ocupando toda a largura da modal -->
        
            <div class="justify-center">
                {{ $action->getModalAction('checkout') }}
            </div>
        
    </div>
</div>


   