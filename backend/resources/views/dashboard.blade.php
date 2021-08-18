<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (auth()->user()->role == 'admin')
            管理者
            @elseif (auth()->user()->role == 'user')
            利用者
            @endif
        </h2>
    </x-slot>

</x-app-layout>
