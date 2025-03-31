<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Receta') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
            @csrf
            @method('POST')
            <!-- Icono para retornar al listado de recetas -->
            <div class="flex justify-end items-center">
                <a href="{{ route('recipes.index') }}" class="text-indigo-500 hover:text-indigo-600 transition duration-200 flex items-center font-semibold" title="Volver al listado de recetas">
                   <small>Regresar al listado de recetas</small> 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                    </svg>
                </a>
            </div>
            <!-- Título de la Receta (Ocupa todo el ancho) -->
            <div class="mb-8">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Título de la Receta
                </label>
                <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Ej: Tarta de Manzana" value="{{ old('title') }}">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid de dos columnas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Columna Izquierda -->
                <div class="space-y-6">
                    <!-- Descripción con Editor WYSIWYG -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        @include('components.wysiwygEditor')
                    </div>
                    
                    <!-- Categorías de Recetas -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Categorías</label>
                        <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Etiquetas Seleccionables -->
                    @include('components.tagList')

                    <!-- Tiempo de Preparación, Cocción y Porciones -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="prep_time" class="block text-sm font-medium text-gray-700 mb-2">T. Preparación (min)</label>
                            <input type="number" id="prep_time" name="prep_time" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Ej: 30" min="1" value="{{ old('prep_time') }}">
                            @error('prep_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="cook_time" class="block text-sm font-medium text-gray-700 mb-2">
                                T. Cocción (min)
                            </label>
                            <input type="number" id="cook_time" name="cook_time" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Ej: 45" min="1" value="{{ old('cook_time') }}">
                            @error('cook_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="servings" class="block text-sm font-medium text-gray-700 mb-2">
                                N.° Porciones
                            </label>
                            <input type="number" name="servings" id="servings" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Ej: 4" min="1" value="{{ old('servings') }}">
                            @error('servings')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
      
                </div>

                <!-- Columna Derecha -->
                <div class="space-y-6">
                    <!-- Ingredientes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ingredientes</label>
                        <div id="ingredientes-container" class="space-y-3">
                            @if(old('ingredients'))
                                @foreach(old('ingredients') as $ingredient)
                                    @if(!empty(trim($ingredient)))
                                    <div class="ingredient-row flex items-center gap-2">
                                        <input type="text" name="ingredients[]" value="{{ $ingredient }}" 
                                            class="ingredient-input flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200">
                                        <button type="button" onclick="removeRow(this)" class="remove-btn px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                @endforeach
                            @else
                                <!-- Campo inicial visible -->
                                <div class="ingredient-row flex items-center gap-2">
                                    <input type="text" name="ingredients[]" 
                                        class="ingredient-input flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                                        placeholder="Ejemplo: 2 tazas de harina">
                                    <button type="button" onclick="removeRow(this)" class="remove-btn px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-end items-center gap-4 mt-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Agregar Ingrediente
                            </label>
                            <button type="button" onclick="addIngredient()" class="px-1 py-1 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                                </svg>
                            </button>
                        </div>
                        @error('ingredients')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pasos de Preparación -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pasos</label>
                        <div id="pasos-container" class="space-y-3">
                            @if(old('steps'))
                                @foreach(old('steps') as $step)
                                    @if(!empty(trim($step)))
                                    <div class="step-row flex items-center gap-2">
                                        <textarea name="steps[]" rows="2"
                                            class="step-input flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200">{{ $step }}</textarea>
                                        <button type="button" onclick="removeRow(this)" class="remove-btn px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                @endforeach
                            @else
                                <!-- Campo inicial visible -->
                                <div class="step-row flex items-center gap-2">
                                    <textarea name="steps[]" rows="2"
                                        class="step-input flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                                        placeholder="Ejemplo: Mezcla los ingredientes secos..."></textarea>
                                    <button type="button" onclick="removeRow(this)" class="remove-btn px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-end items-center gap-4 mt-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Agregar Paso
                            </label>
                            <button type="button" onclick="addStep()" class="px-1 py-1 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                                </svg>
                            </button>
                        </div>
                        @error('steps')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Imagen de Portada -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Imagen de Portada
                        </label>
                        <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition duration-200">
                            <div class="space-y-1 text-center" id="upload-container">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex flex-col text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500">
                                        <span>Subir una imagen</span>
                                        <input type="file" name="image" id="image" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 10MB</p>
                            </div>
                            <div id="image-preview" class="hidden text-center">
                                <img id="preview" class="max-w-full h-48 rounded-lg" src="#" alt="Previsualización de la imagen" />
                                <button type="button" id="remove-image" class="mt-2 text-sm text-red-600 hover:text-red-500">Reemplazar imagen</button>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL del Video -->
                    <div>
                        <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">URL del Video</label>
                        <input type="url" name="video_url" id="video_url" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Ej: https://youtube.com/..." value="{{ old('video_url') }}">
                        @error('video_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imágenes Secundarias -->
                    <div>
                        <label for="recipe_images" class="block text-sm font-medium text-gray-700 mb-2">Imágenes Secundarias</label>
                        <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition duration-200">
                            <div class="space-y-1 text-center" id="upload-container-secondary">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex flex-col text-sm text-gray-600">
                                    <label for="recipe_images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500">
                                        <span>Subir imágenes</span>
                                        <input type="file" name="recipe_images[]" id="recipe_images" class="sr-only" accept="image/*" multiple>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 10MB cada una</p>
                            </div>
                            <div id="images-preview" class="flex flex-wrap gap-4 mt-4">
                                <!-- Aquí se mostrarán las imágenes seleccionadas -->
                            </div>
                        </div>
                        @error('recipe_images')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botón de Envío -->
                    <div class="mt-8">
                        <button type="submit" class="w-full text-sm font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 py-3 px-4 transition duration-200">
                            Guardar Receta
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Previsualización de la imagen de portada
            const imageInput = document.getElementById('image');
            const uploadContainer = document.getElementById('upload-container');
            const imagePreview = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview');
            const removeImageButton = document.getElementById('remove-image');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        uploadContainer.classList.add('hidden');
                        imagePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            removeImageButton.addEventListener('click', function() {
                imageInput.value = '';
                previewImage.src = '#';
                imagePreview.classList.add('hidden');
                uploadContainer.classList.remove('hidden');
            });

            // Previsualización de las imagenes secundarias
            const imagesInput = document.getElementById('recipe_images');
            const uploadContainerSecondary = document.getElementById('upload-container-secondary');
            const imagesPreview = document.getElementById('images-preview');

            imagesInput.addEventListener('change', function(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    imagesPreview.innerHTML = ''; // Limpiar previsualizaciones anteriores
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imageContainer = document.createElement('div');
                            imageContainer.className = 'relative';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-24 h-24 object-cover rounded-lg';

                            const removeButton = document.createElement('button');
                            removeButton.type = 'button';
                            removeButton.className = 'absolute top-0 right-0 px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200';
                            removeButton.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            `;
                            removeButton.onclick = function() {
                                imageContainer.remove();
                                updateFileInput(files, file);
                                // Verificar si no hay imágenes después de eliminar
                                if (imagesPreview.children.length === 0) {
                                    imagesPreview.classList.add('hidden');
                                    uploadContainerSecondary.classList.remove('hidden');
                                }
                            };

                            imageContainer.appendChild(img);
                            imageContainer.appendChild(removeButton);
                            imagesPreview.appendChild(imageContainer);
                        };
                        reader.readAsDataURL(file);
                    });
                    uploadContainerSecondary.classList.add('hidden');
                    imagesPreview.classList.remove('hidden');
                }
            });

            function updateFileInput(allFiles, fileToRemove) {
                const dataTransfer = new DataTransfer();
                Array.from(allFiles).forEach(file => {
                    if (file !== fileToRemove) {
                        dataTransfer.items.add(file);
                    }
                });
                imagesInput.files = dataTransfer.files;
            }

        });

        // Función para agregar ingredientes
        function addIngredient() {
            const container = document.getElementById('ingredientes-container');
            const newRow = document.createElement('div');
            newRow.className = 'ingredient-row flex items-center gap-2';
            newRow.innerHTML = `
                <input type="text" name="ingredients[]" 
                    class="ingredient-input flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                    placeholder="Ejemplo: 2 tazas de harina">
                <button type="button" onclick="removeRow(this)" class="remove-btn px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
            `;
            container.appendChild(newRow);
            newRow.querySelector('input').focus();
        }

        // Función para agregar pasos
        function addStep() {
            const container = document.getElementById('pasos-container');
            const newRow = document.createElement('div');
            newRow.className = 'step-row flex items-center gap-2';
            newRow.innerHTML = `
                <textarea name="steps[]" rows="2"
                    class="step-input flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                    placeholder="Ejemplo: Mezcla los ingredientes secos..."></textarea>
                <button type="button" onclick="removeRow(this)" class="remove-btn px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
            `;
            container.appendChild(newRow);
            newRow.querySelector('textarea').focus();
        }

        // Función genérica para eliminar filas
        function removeRow(button) {
            const row = button.closest('.ingredient-row, .step-row');
            if (row) {
                // No permitir eliminar el último campo de ingredientes/pasos
                const container = row.parentElement;
                const rows = container.querySelectorAll('.ingredient-row, .step-row');
                
                if (rows.length > 1) {
                    row.remove();
                } else {
                    // Limpiar el campo en lugar de eliminarlo
                    const input = row.querySelector('input, textarea');
                    if (input) input.value = '';
                    input.focus();
                }
            }
        }

        // Limpiar campos vacíos antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            // Limpiar ingredientes vacíos
            document.querySelectorAll('.ingredient-input').forEach(input => {
                if (!input.value.trim()) {
                    input.closest('.ingredient-row')?.remove();
                }
            });
            
            // Limpiar pasos vacíos
            document.querySelectorAll('.step-input').forEach(input => {
                if (!input.value.trim()) {
                    input.closest('.step-row')?.remove();
                }
            });
            
            // Validar que haya al menos un ingrediente y un paso
            const ingredientes = document.querySelectorAll('.ingredient-row').length;
            const pasos = document.querySelectorAll('.step-row').length;
            
            if (ingredientes === 0 || pasos === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un ingrediente y un paso de preparación');
            }
        });
    </script>
</x-app-layout>