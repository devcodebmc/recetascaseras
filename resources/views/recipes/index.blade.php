<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recetas') }}
        </h2>
    </x-slot>

    {{-- Mostrar mensaje flash --}}
    @if (session('success'))
    <div id="flash-message" class="fixed top-20 right-8 flex items-center justify-between p-8 text-sm rounded-lg shadow-md bg-white border border-gray-200">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>  
            <p class="font-semibold text-gray-900">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('flash-message').style.display='none';" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 4000); // Ocultar después de 4 segundos
    </script>
    @endif

    {{-- Tabla con el listado de etiquetas --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center py-6 px-4 sm:px-6 space-y-4 sm:space-y-0">
                    <form method="GET" action="{{ route('recipes.index') }}" class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                        <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Buscar recetas" class="block w-full border border-gray-300 rounded-md pl-3 text-sm"/>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-emerald-500 hover:bg-emerald-600 w-full sm:w-auto">
                            Buscar
                        </button>
                        @if (request('search'))
                        <a href="{{ route('recipes.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 w-full sm:w-auto">
                            Limpiar
                        </a>
                        @endif
                    </form>
                    <a href="{{ route('recipes.create') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center w-full sm:w-auto justify-center sm:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Nueva Receta
                    </a>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Portada
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Titulo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de creación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de actualización
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recipes as $recipe)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($recipe->image)
                                            <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}" class="w-10 h-10 rounded-full border-2 border-emerald-500">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div id="tag-view-{{ $recipe->id }}">
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $recipe->title }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($recipe->status == 'draft')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-400 text-yellow-800">
                                                Borrador
                                            </span>
                                            @else
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-400 text-green-800">
                                                Publicado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $recipe->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $recipe->updated_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <!-- Icono de editar -->
                                            <a href="{{ route('recipes.edit', $recipe->id) }}" class="text-gray-500 hover:text-indigo-600 mb-1" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                    
                                            <!-- Icono de mover a la papelera -->
                                            <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-500 hover:text-red-600" title="Mover a la papelera">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                     
                    </table>
                    <div class="mt-4">
                        {{ $recipes->links() }}
                    </div>
                </div>
            </div>
            <!-- Table -->
        </div>
    </div>
<!-- Main Content -->
</x-app-layout>
