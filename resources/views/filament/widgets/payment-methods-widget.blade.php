<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-6 bg-white rounded-xl shadow">
            {{-- <h2 class="text-lg font-semibold mb-4">To'lov usullari</h2> --}}
            
            <div class="grid grid-cols-4 gap-4">
                @foreach($paymentMethods as $method)
                    <div class="flex items-center justify-between bg-gray-100 p-4 rounded-lg">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset(  $method->photo) }}" class="w-8 h-8" alt="icon">
                            <div>
                                <p class="font-medium">{{ $method->name}}</p>
                                <p class="text-xs text-gray-500">
                                    Oxirgi yangilanish: {{ $method->updated_at ? $method->updated_at->format('H:i; M d, Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        {{-- <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" @checked($method->is_active)
                                   wire:click="toggleStatus({{ $method->id }})">
                                   <div class="w-11 h-6 bg-gray-300 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 
                                   rounded-full peer dark:bg-gray-700 peer-checked:bg-green-500
                                   relative transition-colors">
                                        <div class="absolute left-1 top-1 w-4 h-4 bg-white border border-gray-300 rounded-full transition-all peer-checked:translate-x-5"></div>
                                    </div>
                        </label> --}}
                        <label class="fi-switch">
                            <input type="checkbox" class="cursor-pointer" wire:model="is_active" 
                                   @checked($method->is_active) 
                                   wire:click="toggleStatus({{ $method->id }})">
                            <span class="fi-switch-label"></span>
                        </label>
                        {{-- <x-filament::toggle 
                            wire:model="is_active" 
                            :checked="$method->is_active" 
                            wire:click="toggleStatus({{ $method->id }})"
                        /> --}}
                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
