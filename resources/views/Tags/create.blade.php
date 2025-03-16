<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Etiqueta') }}
        </h2>
    </x-slot>

    {{-- Formulario para la creación de Etiquetas --}}
    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('tags.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Nombre de la Etiqueta -->
                            <div class="col-span-1">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nombre
                                    <span class="text-red-500">*</span>
                                </label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full border border-gray-300 rounded-md pl-3 text-sm" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"/>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600">
                                Crear Etiqueta
                            </button>
                        </div>
                        <div class="flex items-center mt-4">
                            <a href="{{ route('tags.index') }}" class="text-blue-500 hover:underline">
                                Volver a Etiquetas
                            </a>
                        </div>
                        @error('name')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
