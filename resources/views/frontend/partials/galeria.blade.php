<section class="bg-[#F5F3EF] py-16 px-4 md:px-12 lg:px-20">
  <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-8 tracking-widest">
    Galería del Sazón
  </h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach ($images as $key => $recipe)
    @if ($key <= 8)
    <div class="relative">
      <img
        src="{{ asset($recipe->image) }}"
        alt="{{ $recipe->title }}"
        class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
      />
      <div class="absolute top-4 left-4 flex items-center space-x-2 bg-white bg-opacity-75 px-3 py-1 rounded-full shadow-md">
        @include('frontend.components.likeButton')
      </div>
    </div>
    @endif
    @endforeach
  </div>
</section>
  
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