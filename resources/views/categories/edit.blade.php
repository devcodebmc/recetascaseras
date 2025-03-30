<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Categoría') }}
        </h2>
    </x-slot>

    {{-- Formulario para la creación de Categorias --}}
    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Nombre de la Categoría -->
                            <div class="col-span-1">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nombre
                                    <span class="text-red-500">*</span>
                                </label>
                                <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required class="mt-1 block w-full border border-gray-300 rounded-md pl-3 text-sm" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"/>
                            </div>
                            {{-- Imagen de la Categoría --}}
                            <div class="col-span-1">
                                <label for="icon_url" class="block text-sm font-medium text-gray-700">
                                    Imagen
                                    <span class="text-red-500">*</span>
                                </label>
                                <input id="icon_url" type="file" name="icon_url" class="mt-1 block w-full bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onchange="previewImage(event)"/>
                                @if ($category->icon_url)
                                    <div class="mt-4 flex items-center justify-center">
                                        <div class="text-center">
                                            <img src="{{ asset($category->icon_url) }}" alt="Imagen de la Categoría" class="w-20 h-20 object-cover rounded-md" id="current-image">
                                            <span class="block text-gray-700 text-xs">Imagen Actual</span>
                                        </div>
                                        <span class="mx-4 text-gray-500">➡️</span>
                                        <div class="text-center">
                                            <img src="" alt="Nueva Imagen" class="w-20 h-20 object-cover rounded-md" id="new-image" style="display: none;">
                                            <span class="block text-gray-700 text-xs">Imagen Nueva</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{-- Descripción de la Categoría --}}
                            <div class="col-span-1">
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Descripción
                                </label>
                                <textarea id="description" name="description" class="mt-1 block w-full border border-gray-300 rounded-md pl-3 text-sm resize-none h-32" rows="4" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">{{ old('description', $category->description) }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white  bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 h-full">
                                Actualizar Categoría
                            </button>
                        </div>
                        <div class="flex items-center mt-4">
                            <a href="{{ route('categories.index') }}" class="text-blue-500 hover:underline">
                                Volver a Categorías
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

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('new-image');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
