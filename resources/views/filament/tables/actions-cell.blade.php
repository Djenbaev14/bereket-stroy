<x-filament::button
    tag="button"
    color="primary"
    wire:click="openCreditInfo({{ $row->id }})"
>
    Кредит инфо
</x-filament::button>
