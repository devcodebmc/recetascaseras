<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Papelera de reciclaje') }}
        </h2>
    </x-slot>
    {{-- Modal de confirmación --}}
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-xl transform transition-all duration-300 scale-95 opacity-0 max-w-md w-full" id="modalContent">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Confirmar eliminación</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-6">¿Estás seguro que deseas eliminar esta receta definitivamente? Esta acción no se puede deshacer.</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancelar
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Eliminar definitivamente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recetas en la papelera</h3>
                        <div class="flex space-x-2">
                            <button id="list-view" class="p-2 rounded hover:bg-indigo-100" title="Vista de lista">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </button>
                            <button id="grid-view" class="p-2 rounded hover:bg-indigo-100" title="Vista de cuadrícula">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if ($recipes->isEmpty())
                        <p class="text-gray-500">No hay recetas en la papelera de reciclaje.</p>
                    @else
                        <!-- Vista de lista -->
                        <div id="list-view-container" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Imagen
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Eliminada el
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($recipes as $recipe)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}" class="w-16 h-16 object-cover rounded">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $recipe->title }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($recipe->deleted_at)
                                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-400 text-white">
                                                        Eliminado
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $recipe->deleted_at->format('d/m/Y h:i a') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('recyclebin.restore', $recipe->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-gray-500 hover:text-indigo-600" title="Restaurar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('recyclebin.destroy', $recipe->id) }}" method="POST" class="inline ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="showDeleteModal('{{ route('recyclebin.destroy', $recipe->id) }}')" type="button" class="text-gray-500 hover:text-red-600" title="Eliminar definitivamente">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Vista de cuadrícula -->
                        <div id="grid-view-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($recipes as $recipe)
                                <div class="relative bg-cover bg-center rounded-lg shadow-md h-48 group" style="background-image: url('{{ asset($recipe->image) }}');">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg p-4 flex flex-col justify-end transition-all duration-300 hover:bg-opacity-65 group">
                                        <!-- Título con mejor contraste -->
                                        <div class="text-sm font-semibold text-white group-hover:text-yellow-300 transition-colors duration-300">
                                            {{ $recipe->title }}
                                        </div>
                                        <!-- Texto secundario con mejor contraste -->
                                        <div class="text-sm text-gray-300 mt-2 group-hover:text-gray-100 transition-colors duration-300">
                                            {{ $recipe->deleted_at->format('d/m/Y h:i a') }}
                                        </div>
                                    </div>
                                                                   
                                    <!-- Menú de tres puntos y dropdown de acciones -->
                                    <div class="absolute top-2 right-2">
                                        <!-- Botón de tres puntos -->
                                        <button onclick="toggleDropdown('dropdown-{{ $recipe->id }}', event)" class="dropdown-button text-white bg-gray-700 bg-opacity-50 rounded-full p-1 focus:outline-none hover:bg-gray-600">
                                            &#x22EE; <!-- Icono de tres puntos -->
                                        </button>

                                        <!-- Dropdown de acciones -->
                                        <div id="dropdown-{{ $recipe->id }}" class="dropdown-content hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                            <div class="py-1">
                                                <form action="{{ route('recyclebin.restore', $recipe->id) }}" method="POST" class="block w-full text-left px-2 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="w-full flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                        </svg>
                                                        Restaurar
                                                    </button>
                                                </form>
                                                <form action="{{ route('recyclebin.destroy', $recipe->id) }}" method="POST" class="block w-full text-left px-2 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="showDeleteModal('{{ route('recyclebin.destroy', $recipe->id) }}')" type="button" class="w-full flex items-center gap-2 text-left">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                        Eliminar definitivamente
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar u ocultar el dropdown de acciones
        document.getElementById('confirmModal').classList.add('hidden');
        // Función para mostrar el modal de confirmación
        function showDeleteModal(actionUrl) {
            const modal = document.getElementById('confirmModal');
            const modalContent = document.getElementById('modalContent');
            const deleteForm = document.getElementById('deleteForm');
            
            // Configurar el formulario
            deleteForm.action = actionUrl;
            
            // Mostrar modal con animación
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Función para cerrar el modal
        function closeModal() {
            const modal = document.getElementById('confirmModal');
            const modalContent = document.getElementById('modalContent');
            
            // Animación de salida
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            modal.classList.remove('opacity-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Cerrar modal al hacer clic fuera del contenido
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>