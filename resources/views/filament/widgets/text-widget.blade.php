@php
    $user = filament()->auth()->user();
    
@endphp



<x-filament-widgets::widget>
    <x-filament::section>

    <div>
Benutzer: {{ filament()->getUserName($user) }}<br>
Aktueller Ringversuch: {{  $this->data() }}
</div>
    <div class="flex flex-col items-center gap-y-6 ">
    
    <div>
        <x-filament::link
    href="https://mqzh.ch"
    rel="noopener noreferrer"
    target="_blank"
    >
    {{ "MQ Homepage" }}
    </x-filament::link>
    </div>



    
    <div>
        <x-filament::link
            href="https://service.mqzh.ch/scp"
            rel="noopener noreferrer"
            target="_blank">
            {{ "MQ Ticketsystem" }}
        </x-filament::link>
    </div>

    <div>
        <x-filament::link
            href="https://online.mqzh.ch"
            rel="noopener noreferrer"
            target="_blank">
            {{ "MQ Online" }}
        </x-filament::link>
    </div>

    <div wire:poll>
         {{ now() }}
    </div>
   

    </x-filament::section>
</x-filament-widgets::widget>
