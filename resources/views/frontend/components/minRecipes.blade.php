<div class="max-w-7xl mx-auto px-4 lg:py-12 py-2">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-2 tracking-widest">
        Otras recetas que te pueden gustar
    </h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($smallRecipes->shuffle()->take($limit) as $recipe)
        <div class="group block rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 bg-white">
            <a href="{{ route('showRecipe', $recipe->slug) }}" class="block">
                <!-- Imagen con overlay hover -->
                <div class="relative overflow-hidden h-36">
                    <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors duration-300"></div>
                </div>
                
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-orange-600 transition-colors tracking-wider">
                        {{ Str::limit($recipe->title, 40) }}
                    </h3>
                    
                    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                        <!-- Tiempo de preparación -->
                        <span class="flex items-center bg-gray-100 rounded-full px-3 py-1">
                            <svg class="w-4 h-4 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @php
                                $totalTime = $recipe->prep_time + $recipe->cook_time;
                            @endphp
                            @if($totalTime > 60)
                                {{ intdiv($totalTime, 60) }}h 
                                @if($totalTime % 60 != 0)
                                    {{ $totalTime % 60 }}m
                                @endif
                            @else
                                {{ $totalTime }}m
                            @endif
                        </span>
                        
                        <!-- Categoría -->
                        <a href="{{ route('category.show', $recipe->category->slug) }}" class="text-gray-600 hover:text-orange-600 transition-colors duration-300">
                            <span class="bg-amber-100 text-amber-800 rounded-full px-3 py-1">
                                {{ $recipe->category->name }}
                            </span>
                        </a>
                        
                    </div>
                </div>
            </a>
             <!-- Likes (si tienes este campo) -->
             @if($recipe->likes)
             <div class="absolute top-4 left-2 flex items-center space-x-2 bg-gray-50 bg-opacity-75 px-3 py-1 rounded-full shadow-md z-10">
                @include('frontend.components.likeButton')
             </div>
             @endif
        </div>
        @endforeach
    </div>
</div>

@push('js')
<script>
function likeRecipe(recipeId) {
    const likeButton = document.getElementById(`like-button-${recipeId}`);
    const likeCount = document.getElementById(`like-count-${recipeId}`);
    const buttonRect = likeButton.getBoundingClientRect();
    
    // Deshabilitar botón temporalmente
    likeButton.disabled = true;
    
    // Crear corazón flotante (inicialmente oculto)
    const floatingHeart = document.createElement('div');
    floatingHeart.classList.add('heart-float');
    floatingHeart.style.left = `${buttonRect.width/2 - 12}px`;
    floatingHeart.style.top = `0px`;
    floatingHeart.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
    `;
    
    // Añadir corazón al botón (aún invisible)
    likeButton.appendChild(floatingHeart);
    
    // Hacer la petición al servidor
    fetch(`/recipes/${recipeId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // 1. Primero actualizar el contador
            likeCount.textContent = data.likes;
            
            // 2. Activar animación del contador
            likeCount.classList.add('text-red-500', 'like-count-pop');
            
            // 3. Cambiar el corazón principal a estado "liked"
            likeButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            `;
            
            // 4. Mostrar y animar el corazón flotante
            floatingHeart.style.opacity = '1';
            
            // Eliminar corazón después de la animación
            setTimeout(() => {
                floatingHeart.remove();
                likeCount.classList.remove('text-red-500', 'like-count-pop');
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        floatingHeart.remove();
    })
    .finally(() => {
        likeButton.disabled = false;
    });
}
</script>
@endpush
