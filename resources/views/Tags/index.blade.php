<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Etiquetas') }}
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
        }, 4000); // Ocultar después de 6 segundos
    </script>
    @endif

    {{-- Tabla con el listado de etiquetas --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center py-6 px-4 sm:px-6 space-y-4 sm:space-y-0">
                    <form method="POST" action="{{ route('tags.store') }}" class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                        @csrf
                        <!-- Nombre de la Etiqueta -->
                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Nueva etiqueta" required class="block w-full border border-gray-300 rounded-md pl-3 text-sm" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"/>
                        </div>
                        <button type="submit" class="inline-flex justify-center items-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 h-full">
                            Crear Etiqueta
                        </button>
                        @error('name')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </form>
                    <form method="GET" action="{{ route('tags.index') }}" class="flex flex-col sm:flex-row items-stretch w-full sm:w-auto">
                        <div class="flex flex-col sm:flex-row flex-grow space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="flex-grow relative">
                                <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Buscar etiquetas" 
                                       class="w-full h-full border border-gray-300 rounded-md pl-3 pr-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500" required/>
                            </div>
                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                <button type="submit" class="inline-flex justify-center items-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 h-full">
                                    Buscar
                                </button>
                                @if (request('search'))
                                <a href="{{ route('tags.index') }}" class="inline-flex justify-center items-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 h-full">
                                    Limpiar
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('tags.create') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center w-full sm:w-auto justify-center sm:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Nueva Etiqueta
                    </a>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Slug
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
                            @foreach ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div id="tag-view-{{ $tag->id }}">
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $tag->name }}
                                            </span>
                                        </div>
                        
                                        <form id="tag-form-{{ $tag->id }}" method="POST" action="{{ route('tags.update', $tag->id) }}" class="hidden">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" value="{{ $tag->name }}" class="border border-gray-300 rounded-md px-2 py-1 text-sm" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                                            <button type="submit" class="bg-indigo-500 text-white hover:bg-indigo-600 rounded-md px-2 py-1 text-sm">
                                                Actualizar
                                            </button>
                                            <button type="button" onclick="cancelEdit({{ $tag->id }})" class="bg-red-500 text-white hover:bg-red-700 rounded-md px-2 py-1 text-sm">
                                                Cancelar
                                            <button>
                                            @error('name')
                                            <div class="text-red-500 mt-2">{{ $message }}</div>
                                            @enderror
                                        </form>    
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $tag->slug }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $tag->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $tag->updated_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="editTag({{ $tag->id }})" class="text-sm font-medium text-gray-500 hover:text-gray-700" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>                                              
                                            </button>
                                            <!-- Botón que abre el modal -->
                                            <button type="button" class="text-sm font-medium text-gray-500 hover:text-gray-700" title="Eliminar" onclick="openModal({{ $tag->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Modal -->
                                        <div id="confirmationModal{{ $tag->id }}" class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-500 bg-opacity-50">
                                            <div class="bg-white rounded-lg mt-20 p-6 mx-4 sm:mx-auto w-auto max-w-md lg:max-w-lg">
                                                <h2 class="text-xl font-semibold text-gray-800">
                                                    Confirmación
                                                </h2>
                                                <p class="mt-2 text-gray-600 text-center text-xs lg:text-lg md:text-md break-words flex flex-wrap">
                                                    ¿Estás seguro de que deseas eliminar la etiqueta 
                                                    <strong class="ml-1">{{ $tag->slug }}</strong>?
                                                </p>
                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeModal({{ $tag->id }})">Cancelar</button>
                                                    <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            function editTag(tagId) {
                                                document.getElementById('tag-view-' + tagId).style.display = 'none';
                                                document.getElementById('tag-form-' + tagId).style.display = 'block';
                                            }

                                            function cancelEdit(tagId) {
                                                document.getElementById('tag-form-' + tagId).style.display = 'none';
                                                document.getElementById('tag-view-' + tagId).style.display = 'block';
                                            }
                                            function openModal(id) {
                                                document.getElementById('confirmationModal' + id).classList.remove('hidden');
                                            }

                                            function closeModal(id) {
                                                document.getElementById('confirmationModal' + id).classList.add('hidden');
                                            }
                                        </script>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                     
                    </table>
                    <div class="mt-4">
                        {{ $tags->links() }}
                    </div>
                </div>
            </div>
            <!-- Table -->
        </div>
    </div>
<!-- Main Content -->
</x-app-layout>
