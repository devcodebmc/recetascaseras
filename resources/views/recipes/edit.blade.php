<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Receta') }}
        </h2>
    </x-slot>

    @include('components.flash-notification')

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('recipes.update', ['recipe' => $recipe->id]) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            
            <!-- Icono para retornar al listado de recetas -->
            <div class="flex justify-end items-center">
                <a href="{{ route('recipes.index') }}" class="text-indigo-500 hover:text-indigo-600 transition duration-200 flex items-center font-semibold" title="Volver al listado de recetas">
                   <small>Regresar al listado de recetas</small> 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                    </svg>
                </a>
            </div>
            
            <!-- Título de la Receta -->
            <div class="mb-8">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Título de la Receta
                </label>
                <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" 
                       placeholder="Ej: Tarta de Manzana" value="{{ old('title', $recipe->title) }}">
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
                                <option value="{{ $category->id }}" {{ (old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' )}}>
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
                            <input type="number" id="prep_time" name="prep_time" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" 
                                placeholder="Ej: 30" min="1" value="{{ old('prep_time', $recipe->prep_time) }}">
                            @error('prep_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="cook_time" class="block text-sm font-medium text-gray-700 mb-2">
                                T. Cocción (min)
                            </label>
                            <input type="number" id="cook_time" name="cook_time" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" 
                                placeholder="Ej: 45" min="1" value="{{ old('cook_time', $recipe->cook_time) }}">
                            @error('cook_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="servings" class="block text-sm font-medium text-gray-700 mb-2">
                                N.° Porciones
                            </label>
                            <input type="number" name="servings" id="servings" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" 
                                placeholder="Ej: 4" min="1" value="{{ old('servings', $recipe->servings) }}">
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
                            @foreach($ingredients as $index => $ingredient)
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
                            @foreach($steps as $index => $step)
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
                            <!-- Contenedor de carga (se muestra cuando no hay imagen) -->
                            <div class="space-y-1 text-center" id="upload-container" @isset($recipe) style="display: none;" @else style="display: block;" @endisset>
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
                            
                            <!-- Contenedor de previsualización (se muestra cuando hay imagen) -->
                            <div id="image-preview" class="text-center" @isset($recipe) style="display: block;" @else style="display: none;" @endisset>
                                <img id="preview" class="max-w-full h-48 rounded-lg" 
                                    @isset($recipe) src="{{ asset($recipe->image) }}" @else src="#" @endisset 
                                    alt="Previsualización de la imagen" />
                                <button type="button" id="remove-image" class="mt-2 text-sm text-red-600 hover:text-red-500">
                                    Reemplazar imagen
                                </button>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                   <!-- URL del Video -->
                    <div>
                        <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">URL del Video</label>
                        <input type="url" name="video_url" id="video_url" class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" 
                            placeholder="Ej: https://youtube.com/..." value="{{ old('video_url', $recipe->video_url) }}">
                        @error('video_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                   <!-- Imágenes Secundarias -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imágenes Secundarias</label>
                        
                        <div class="mt-1 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-gray-100 transition duration-200 p-4">
                            <!-- Contenedor de imágenes existentes -->
                            <div id="existing-images" class="flex flex-wrap gap-4 mb-4">
                                @foreach($recipe->images as $image)
                                <div class="relative group" data-image-id="{{ $image->id }}">
                                    <img src="{{ asset($image->image_path) }}" class="w-32 h-32 object-cover rounded-lg shadow-md">
                                    <button type="button" onclick="deleteImage(this)" class="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Contenedor de imágenes nuevas -->
                            <div id="images-preview" class="flex flex-wrap gap-4 mb-4"></div>
                            <!-- Input para subir imágenes (siempre visible) -->
                            <div class="flex flex-col items-center text-sm text-center text-gray-600">
                                <label class="w-fit px-4 cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500">
                                    <span>Subir imagenes</span>
                                    <input type="file" name="recipe_images[]" id="recipe_images" class="sr-only" accept="image/*" multiple>
                                </label>
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF hasta 10MB cada una</p>
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

    <script defer>
        // Componente autónomo para la imagen de portada
        (function() {
            const imageInput = document.getElementById('image');
            const uploadContainer = document.getElementById('upload-container');
            const imagePreview = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview');
            const removeImageButton = document.getElementById('remove-image');
        
            // Verificar que todos los elementos existen
            if (!imageInput || !uploadContainer || !imagePreview || !previewImage || !removeImageButton) {
                return;
            }
        
            // Manejar cambio de imagen
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validar tamaño máximo (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('El archivo es demasiado grande. El tamaño máximo permitido es 10MB.');
                        this.value = '';
                        return;
                    }
        
                    // Validar tipo de archivo
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Formato de archivo no válido. Solo se permiten JPG, PNG o GIF.');
                        this.value = '';
                        return;
                    }
        
                    // Mostrar previsualización
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        uploadContainer.style.display = 'none';
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        
            // Manejar eliminación de imagen
            removeImageButton.addEventListener('click', function() {
                imageInput.value = '';
                previewImage.src = '#';
                imagePreview.style.display = 'none';
                uploadContainer.style.display = 'block';
            });
        
            // Si estamos en modo edición y hay una imagen, mostrar el contenedor correcto
            @isset($recipe)
                if (previewImage.src && previewImage.src !== '#') {
                    uploadContainer.style.display = 'none';
                    imagePreview.style.display = 'block';
                }
            @endisset
        })();
    </script>
    <script>
        let currentDeleteCallback = null;

        function showConfirm(message, callback) {
        document.getElementById('custom-confirm').classList.remove('hidden');
        document.getElementById('confirm-message').textContent = message;
        currentDeleteCallback = callback;
        }

        function hideConfirm() {
        document.getElementById('custom-confirm').classList.add('hidden');
        currentDeleteCallback = null;
        }

    async function deleteImage(button) {
        // Verificar que el botón y su parentElement existan
        if (!button || !button.parentElement) {
            console.error('Elemento de imagen no encontrado');
            return;
        }

        const imageContainer = button.parentElement;
        const imageId = imageContainer.getAttribute('data-image-id');

        try {
            // Mostrar spinner de carga
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;

            const response = await fetch(`../recipes/images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                imageContainer.remove();
                showFlashMessage('Imagen eliminada correctamente', true);
            } else {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error al eliminar la imagen');
            }
        } catch (error) {
            console.error('Error:', error);
            showFlashMessage(error.message, false);
            
            // Restaurar botón si aún existe
            if (button.parentElement) {
                button.disabled = false;
                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                `;
            }
        }
    }

    // Función para mostrar notificaciones flash
    function showFlashMessage(message, isSuccess) {
        const flashMessage = document.getElementById('flash-message');
        const flashIcon = document.getElementById('flash-icon');
        const flashText = document.getElementById('flash-text');
        
        if (!flashMessage || !flashIcon || !flashText) return;
        
        flashText.textContent = message;
        
        // Cambiar icono y color según el tipo de mensaje
        if (isSuccess) {
            flashIcon.classList.remove('text-red-500');
            flashIcon.classList.add('text-green-500');
            flashIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />';
        } else {
            flashIcon.classList.remove('text-green-500');
            flashIcon.classList.add('text-red-500');
            flashIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />';
        }
        
        // Mostrar y ocultar después de 5 segundos
        flashMessage.classList.remove('hidden');
        setTimeout(() => {
            flashMessage.classList.add('hidden');
        }, 5000);
    }

        // Manejo de nuevas imágenes (igual que antes)
        document.addEventListener('DOMContentLoaded', function() {
            const imagesInput = document.getElementById('recipe_images');
            const imagesPreview = document.getElementById('images-preview');

            imagesInput.addEventListener('change', function(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    Array.from(files).forEach(file => {
                        if (!file.type.match('image.*')) return;
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imageContainer = document.createElement('div');
                            imageContainer.className = 'relative group';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-32 h-32 object-cover rounded-lg shadow-md';
                            
                            const removeButton = document.createElement('button');
                            removeButton.type = 'button';
                            removeButton.className = 'absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200';
                            removeButton.innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            `;
                            removeButton.onclick = function() {
                                imageContainer.remove();
                                updateFileInput(files, file);
                            };
                            
                            imageContainer.appendChild(img);
                            imageContainer.appendChild(removeButton);
                            imagesPreview.appendChild(imageContainer);
                        };
                        reader.readAsDataURL(file);
                    });
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
                row.remove();
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
        });
    </script>
</x-app-layout>