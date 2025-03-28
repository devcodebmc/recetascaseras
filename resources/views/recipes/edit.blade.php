<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Receta') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg">
            @csrf
            @method('PUT')
            
            <!-- Icono para retornar al listado de recetas -->
            <div class="flex justify-end items-center">
                <a href="{{ route('recipes.index') }}" class="text-gray-500 hover:text-gray-600 transition duration-200 flex items-center" title="Volver al listado de recetas">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
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
                            @php
                                $ingredients = is_array($ingredients) ? $ingredients : [$ingredients];
                            @endphp
                            
                            @foreach($ingredients as $ingredient)
                                <div class="flex items-center gap-2">
                                    <input type="text" name="ingredients[]" class="flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" value="{{ $ingredient }}">
                                    <button type="button" onclick="this.parentElement.remove()" class="px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                           <!-- Fila vacía para nuevo ingrediente -->
                           <div class="flex items-center gap-2">
                               <input type="text" name="ingredients[]" class="flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Ejemplo: 2 tazas de harina">
                               <button type="button" onclick="agregarIngrediente()" class="px-1 py-1 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                                   </svg>
                               </button>
                           </div>
                       </div>
                       @error('ingredients')
                           <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                       @enderror
                   </div>    
                   <!-- Pasos de Preparación -->
                   <div>
                       <label class="block text-sm font-medium text-gray-700 mb-2">Pasos</label>
                       <div id="pasos-container" class="space-y-3">
                            @php
                                $steps = is_array($steps) ? $steps : [$steps];
                            @endphp
                            
                            @foreach($steps as $step)
                                <div class="flex items-center gap-2">
                                    <input type="text" name="steps[]" class="flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" value="{{ $step }}">
                                    <button type="button" onclick="this.parentElement.remove()" class="px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                           <!-- Fila vacía para nuevo paso -->
                           <div class="flex items-center gap-2">
                               <input type="text" name="steps[]" class="flex-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Ejemplo: Mezcla los ingredientes...">
                               <button type="button" onclick="agregarPaso()" class="px-1 py-1 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                                   </svg>
                               </button>
                           </div>
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
                                @foreach($recipe->images as $image)
                                    <div class="relative">
                                        <img src="{{ asset($image->image_path) }}" class="w-24 h-24 object-cover rounded-lg">
                                        <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                                        <button type="button" onclick="removeExistingImage(this)" class="absolute top-0 right-0 px-1 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('recipe_images')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                   <!-- Botón de Envío -->
                    <div class="mt-8">
                       <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
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
        document.addEventListener('DOMContentLoaded', function() {
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

        // Función para eliminar imágenes existentes
        function removeExistingImage(button) {
            const container = button.parentElement;
            const input = container.querySelector('input[type="hidden"]');
            
            // Cambiar el nombre para indicar que debe ser eliminado
            input.name = 'deleted_images[]';
            
            // Ocultar el contenedor en lugar de eliminarlo para mantener el input
            container.style.display = 'none';
        }
        
       // Función para agregar más campos de ingredientes
       function agregarIngrediente() {
           let container = document.getElementById('ingredientes-container');
           
           // Crear el nuevo div para el ingrediente
           let div = document.createElement('div');
           div.classList.add('flex', 'items-center', 'gap-2');

           // Crear el input
           let input = document.createElement('input');
           input.type = 'text';
           input.name = 'ingredients[]';
           input.classList.add('flex-1', 'p-2', 'border', 'border-gray-300', 'rounded-lg', 'shadow-sm', 'focus:border-indigo-500', 'focus:ring-2', 'focus:ring-indigo-200', 'transition', 'duration-200');

           // Crear el botón de eliminar
           let button = document.createElement('button');
           button.type = 'button';
           button.classList.add('px-1', 'py-1', 'bg-red-500', 'text-white', 'rounded-full', 'hover:bg-red-600', 'transition', 'duration-200');
           button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                               </svg>`;
           button.onclick = function () {
               div.remove();
           };

           // Agregar input y botón al div
           div.appendChild(input);
           div.appendChild(button);

           // Insertar el nuevo ingrediente despues del último input
           container.insertBefore(div, container.lastElementChild.nextSibling);
       }


       // Función para agregar más campos de pasos
       function agregarPaso() {
           let container = document.getElementById('pasos-container');
           
           // Crear el nuevo div para el paso
           let div = document.createElement('div');
           div.classList.add('flex', 'items-center', 'gap-2');

           // Crear el input
           let input = document.createElement('input');
           input.type = 'text';
           input.name = 'steps[]';
           input.classList.add('flex-1', 'p-2', 'border', 'border-gray-300', 'rounded-lg', 'shadow-sm', 'focus:border-indigo-500', 'focus:ring-2', 'focus:ring-indigo-200', 'transition', 'duration-200');

           // Crear el botón de eliminar
           let button = document.createElement('button');
           button.type = 'button';
           button.classList.add('px-1', 'py-1', 'bg-red-500', 'text-white', 'rounded-full', 'hover:bg-red-600', 'transition', 'duration-200');
           button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                               </svg>`;
           button.onclick = function () {
               div.remove();
           };

           // Agregar input y botón al div
           div.appendChild(input);
           div.appendChild(button);

           // Insertar el nuevo ingrediente despues del último input
           container.insertBefore(div, container.lastElementChild.nextSibling);
       }
    </script>
</x-app-layout>