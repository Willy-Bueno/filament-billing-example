<div class="flex flex-col items-center text-center">
    @if ($getBrandLogo())
        <img src="{{ $getBrandLogo() }}" alt="Brand Logo" class="size-14 object-contain">
    @endif

    @if ($getModalHeading())
        <h1 class="mt-8 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
            {{ $getModalHeading() }}
        </h1>
    @endif

    @if ($getModalDescription())
        <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 max-w-md">
            {{ $getModalDescription() }}
        </p>
    @endif
</div>
