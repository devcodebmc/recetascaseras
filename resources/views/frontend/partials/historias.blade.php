<div class="flex space-x-6 overflow-x-auto pb-4 scrollbar-hide">
    @foreach ($stories as $story)
    <button class="flex flex-col items-center flex-shrink-0 group cursor-pointer" onclick="openStoriesModal({{ $story->user_id }})">
        <!-- Contenedor externo para el efecto de escala -->
        <div class="p-1 group-hover:scale-105 transition-transform duration-300">
            <div class="relative w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-yellow-400 via-orange-500 to-red-500 hover:from-orange-500 hover:to-yellow-500 transition-all duration-300 group-hover:scale-105">
                <div class="bg-white p-0.5 rounded-full h-full w-full flex items-center justify-center">
                    <img 
                        src="{{ asset($story->image) }}" 
                        alt="{{ $story->user->name }}" 
                        class="rounded-full h-full w-full object-cover"
                        loading="lazy"
                    >
                </div>
                @if($story->is_new)
                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                @endif
            </div>
        </div>
        <span class="mt-2 text-xs font-medium text-gray-700 truncate w-20 text-center">
            {{ $story->user->name }}
        </span>
    </button>
    @endforeach
</div>
<!-- Modal de Historias Mejorado -->
<div id="storiesModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Fondo oscuro -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-90"></div>
        </div>
        
        <!-- Contenido del modal estilo Instagram -->
        <div class="inline-block align-bottom rounded-lg overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full h-[90vh] max-h-[90vh]">
            <div class="relative h-full w-full bg-black">
                <!-- Barras de progreso -->
                <div id="progressBars" class="absolute top-0 left-0 right-0 z-40 flex space-x-1 p-2">
                    <!-- Las barras se generarán dinámicamente -->
                </div>
                
                <!-- Cabecera con información del usuario -->
                <div id="storyHeader" class="absolute top-12 left-0 right-0 z-40 flex items-center px-4 py-2">
                    <!-- Se llenará dinámicamente -->
                </div>
                
                <!-- Botón cerrar -->
                <button onclick="closeStoriesModal()" class="absolute top-4 right-4 z-50 text-white hover:text-gray-300 focus:outline-none">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Slider de historias con detección de toques -->
                <div id="storiesSlider" class="h-full w-full relative overflow-hidden touch-none">
                    <div id="storiesContainer" class="h-full w-full flex transition-transform duration-300 ease-out">
                        <!-- Las historias se cargarán aquí dinámicamente -->
                    </div>
                </div>
                
                <!-- Áreas táctiles para navegación -->
                <div class="absolute inset-y-0 left-0 w-1/2 z-30" onclick="showPreviousStory()"></div>
                <div class="absolute inset-y-0 right-0 w-1/2 z-30" onclick="showNextStory()"></div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    let currentUserStories = [];
    let currentStoryIndex = 0;
    let currentUserId = null;
    let progressInterval;
    let startX = 0;
    let isDragging = false;
    const storyDuration = 5000; // 5 segundos por historia

    // Función para abrir el modal
    function openStoriesModal(userId) {
        currentUserId = userId;
        currentStoryIndex = 0;
        
        // Obtener las recetas del usuario
        const userRecipes = @json($userRecipes)[userId] || [];
        
        if (!userRecipes || userRecipes.length === 0) {
            console.error('No se encontraron recetas para el usuario:', userId);
            return;
        }
        
        currentUserStories = userRecipes;
        
        // Mostrar el modal
        document.getElementById('storiesModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Limpiar el contenedor
        document.getElementById('storiesContainer').innerHTML = '';
        
        // Configurar barras de progreso
        setupProgressBars();
        
        // Cargar la primera historia
        loadStory(currentStoryIndex);
        
        // Configurar eventos
        document.addEventListener('keydown', handleKeyDown);
        
        // Eventos táctiles
        const slider = document.getElementById('storiesSlider');
        slider.addEventListener('mousedown', handleTouchStart);
        slider.addEventListener('touchstart', handleTouchStart);
        slider.addEventListener('mousemove', handleTouchMove);
        slider.addEventListener('touchmove', handleTouchMove);
        slider.addEventListener('mouseup', handleTouchEnd);
        slider.addEventListener('touchend', handleTouchEnd);
        slider.addEventListener('mouseleave', handleTouchEnd);
    }

    // Función para cerrar el modal
    function closeStoriesModal() {
        document.getElementById('storiesModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        clearInterval(progressInterval);
        document.removeEventListener('keydown', handleKeyDown);
        
        // Limpiar eventos táctiles
        const slider = document.getElementById('storiesSlider');
        slider.removeEventListener('mousedown', handleTouchStart);
        slider.removeEventListener('touchstart', handleTouchStart);
        slider.removeEventListener('mousemove', handleTouchMove);
        slider.removeEventListener('touchmove', handleTouchMove);
        slider.removeEventListener('mouseup', handleTouchEnd);
        slider.removeEventListener('touchend', handleTouchEnd);
        slider.removeEventListener('mouseleave', handleTouchEnd);
    }

    // Configurar barras de progreso
    function setupProgressBars() {
        const progressBars = document.getElementById('progressBars');
        progressBars.innerHTML = '';
        
        currentUserStories.forEach((_, index) => {
            const barContainer = document.createElement('div');
            barContainer.className = 'h-1 flex-1 bg-gray-600 rounded-full overflow-hidden';
            
            const bar = document.createElement('div');
            bar.className = 'h-full bg-white transition-all duration-100';
            bar.style.width = '0%';
            bar.id = `progressBar-${index}`;
            
            barContainer.appendChild(bar);
            progressBars.appendChild(barContainer);
        });
    }

    // Iniciar temporizador de progreso
    function startProgressTimer() {
        clearInterval(progressInterval);
        
        const currentBar = document.getElementById(`progressBar-${currentStoryIndex}`);
        if (!currentBar) return;
        
        currentBar.style.width = '0%';
        let width = 0;
        const increment = 100 / (storyDuration / 50);
        
        progressInterval = setInterval(() => {
            width += increment;
            currentBar.style.width = `${width}%`;
            
            if (width >= 100) {
                clearInterval(progressInterval);
                setTimeout(() => {
                    showNextStory();
                }, 100);
            }
        }, 50);
    }

    // Cargar una historia específica
    function loadStory(index) {
        if (index < 0 || index >= currentUserStories.length) {
            closeStoriesModal();
            return;
        }
        
        currentStoryIndex = index;
        const story = currentUserStories[index];
        
        // Actualizar el slider
        const container = document.getElementById('storiesContainer');
        container.style.transform = `translateX(-${index * 100}%)`;
        
        // Crear elemento de historia si no existe
        let storyElement = document.getElementById(`story-${index}`);
        if (!storyElement) {
            storyElement = document.createElement('div');
            storyElement.id = `story-${index}`;
            storyElement.className = 'h-full w-full flex-shrink-0 flex items-center justify-center';
            
            const imgUrl = story.image.startsWith('http') ? story.image : `/${story.image.replace(/^\/+/g, '')}`;
            storyElement.innerHTML = `
                <img src="${imgUrl}" alt="${story.title}" class="max-h-full max-w-full object-contain" loading="eager">
            `;
            
            container.appendChild(storyElement);
        }
        
        // Actualizar información del usuario
        const header = document.getElementById('storyHeader');
        header.innerHTML = `
            <div class="flex items-center w-full">
                <div class="w-8 h-8 rounded-full overflow-hidden mr-3 border-2 border-white">
                    <img src="${story.user.avatar || '/images/chef-masculino.png'}" alt="${story.user.name}" class="w-full h-full object-cover">
                </div>
                <div class="text-white">
                    <h3 class="font-semibold text-sm">${story.user.name}</h3>
                    <p class="text-xs text-gray-300">${formatTimeAgo(new Date(story.created_at))}</p>
                </div>
            </div>
        `;
        
        // Actualizar barras de progreso
        currentUserStories.forEach((_, i) => {
            const bar = document.getElementById(`progressBar-${i}`);
            if (bar) {
                bar.style.width = i < index ? '100%' : i === index ? '0%' : '0%';
            }
        });
        
        // Iniciar temporizador
        startProgressTimer();
    }

    // Navegar a la siguiente historia
    function showNextStory() {
        loadStory(currentStoryIndex + 1);
    }

    // Navegar a la historia anterior
    function showPreviousStory() {
        if (currentStoryIndex > 0) {
            loadStory(currentStoryIndex - 1);
        }
    }

    // Manejar eventos de teclado
    function handleKeyDown(e) {
        if (e.key === 'ArrowRight') showNextStory();
        else if (e.key === 'ArrowLeft') showPreviousStory();
        else if (e.key === 'Escape') closeStoriesModal();
    }

    // Manejar inicio de toque/arrastre
    function handleTouchStart(e) {
        isDragging = true;
        startX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
        clearInterval(progressInterval);
    }

    // Manejar movimiento durante el arrastre
    function handleTouchMove(e) {
        if (!isDragging) return;
        
        const x = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
        const diff = startX - x;
        const container = document.getElementById('storiesContainer');
        
        if (diff > 50 && currentStoryIndex < currentUserStories.length - 1) {
            container.style.transform = `translateX(calc(-${currentStoryIndex * 100}% - ${diff}px))`;
        } else if (diff < -50 && currentStoryIndex > 0) {
            container.style.transform = `translateX(calc(-${currentStoryIndex * 100}% - ${diff}px))`;
        }
    }

    // Manejar fin de toque/arrastre
    function handleTouchEnd(e) {
        if (!isDragging) return;
        isDragging = false;
        
        const x = e.type === 'touchend' ? (e.changedTouches ? e.changedTouches[0].clientX : 0) : e.clientX;
        const diff = startX - x;
        
        if (diff > 100) showNextStory();
        else if (diff < -100) showPreviousStory();
        else loadStory(currentStoryIndex); // Vuelve a cargar la historia actual con temporizador
    }

    // Formatear fecha relativa
    function formatTimeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        if (seconds < 60) return 'Hace unos segundos';
        if (seconds < 3600) return `Hace ${Math.floor(seconds / 60)} min`;
        if (seconds < 86400) return `Hace ${Math.floor(seconds / 3600)} h`;
        if (seconds < 2592000) return `Hace ${Math.floor(seconds / 86400)} d`;
        return date.toLocaleDateString();
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('storiesModal').addEventListener('click', function(e) {
        if (e.target === this) closeStoriesModal();
    });

    // // Verificación inicial
    // document.addEventListener('DOMContentLoaded', function() {
    //     console.log('Datos de userRecipes cargados:', @json($userRecipes));
    // });
</script>
@endpush