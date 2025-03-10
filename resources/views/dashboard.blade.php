<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ __('Catálogos') }}
                    </h3>
                    <ul class="mt-4">
                        <li>
                            <a href="{{ route('categories.index') }}" class="text-blue-500">
                                Categorías
                            </a>
                        </li>
                        <li><a href="" class="text-blue-500">{{ __('Catálogo 2') }}</a></li>
                        <li><a href="" class="text-blue-500">{{ __('Catálogo 3') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
