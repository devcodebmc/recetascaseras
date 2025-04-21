<form method="GET" action="{{ route('welcome') }}" class="flex items-center bg-white rounded-full shadow-md p-2 w-full md:w-1/3 mb-4 md:mb-0 font-secondary relative" id="search-form">
    <svg class="w-6 h-6 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
    </svg>
    <input type="text" id="searchfull" name="searchfull" value="{{ request('searchfull') }}" 
           placeholder="Busca recetas maravillosas..." 
           class="flex-grow px-4 py-2 text-gray-700 focus:outline-none" 
           autocomplete="off"
           aria-autocomplete="list"
           aria-controls="search-suggestions">
    <button type="submit" class="bg-red-400 text-white px-4 py-2 rounded-full ml-2">Buscar</button>
    
    <!-- Contenedor para sugerencias -->
    <div id="search-suggestions" class="absolute top-full left-0 right-0 bg-white shadow-lg rounded-md mt-1 z-50 hidden max-h-60 overflow-y-auto"></div>
</form>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchfull');
    const suggestionsContainer = document.getElementById('search-suggestions');
    const searchForm = document.getElementById('search-form');
    let controller = null;
    let lastQuery = '';
    let debounceTimer;
    
    // Configuración
    const DEBOUNCE_TIME = 300; // 300ms de espera
    const MIN_CHARS = 2; // Mínimo de caracteres para buscar
    
    // Función para obtener sugerencias con debounce
    async function fetchSuggestions(query) {
        clearTimeout(debounceTimer);
        
        if (query.length < MIN_CHARS || query === lastQuery) {
            hideSuggestions();
            return;
        }
        
        debounceTimer = setTimeout(async () => {
            if (controller) {
                controller.abort();
            }
            
            controller = new AbortController();
            lastQuery = query;
            
            try {
                // Mostrar loading
                suggestionsContainer.innerHTML = '<div class="px-4 py-2 text-gray-500">Buscando...</div>';
                suggestionsContainer.classList.remove('hidden');
                
                const response = await fetch(`./api/search/suggestions?q=${encodeURIComponent(query)}`, {
                    signal: controller.signal
                });
                
                if (!response.ok) throw new Error('Error en la respuesta');
                
                const suggestions = await response.json();
                
                if (suggestions.length > 0) {
                    showSuggestions(suggestions, query); // Pasamos el query original para resaltar
                } else {
                    hideSuggestions();
                }
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Error:', error);
                    hideSuggestions();
                }
            }
        }, DEBOUNCE_TIME);
    }

    // Función showSuggestions actualizada para resaltar prefijos
    function showSuggestions(suggestions, query) {
        suggestionsContainer.innerHTML = '';
        
        const lowerQuery = query.toLowerCase();
        
        suggestions.forEach(suggestion => {
            const suggestionElement = document.createElement('div');
            suggestionElement.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0';
            
            // Resaltar la parte que coincide con el query
            const lowerSuggestion = suggestion.toLowerCase();
            const matchIndex = lowerSuggestion.indexOf(lowerQuery);
            
            if (matchIndex >= 0) {
                const before = suggestion.substring(0, matchIndex);
                const match = suggestion.substring(matchIndex, matchIndex + query.length);
                const after = suggestion.substring(matchIndex + query.length);
                
                suggestionElement.innerHTML = `
                    ${before}<span class="font-semibold text-red-400">${match}</span>${after}
                `;
            } else {
                suggestionElement.textContent = suggestion;
            }
            
            suggestionElement.addEventListener('click', () => {
                searchInput.value = suggestion;
                hideSuggestions();
            });
            
            suggestionsContainer.appendChild(suggestionElement);
        });
        
        suggestionsContainer.classList.remove('hidden');
    }
    
    // Ocultar sugerencias
    function hideSuggestions() {
        suggestionsContainer.classList.add('hidden');
    }
    
    // Event listeners
    searchInput.addEventListener('input', (e) => {
        fetchSuggestions(e.target.value.trim());
    });
    
    searchInput.addEventListener('focus', () => {
        if (searchInput.value.length >= MIN_CHARS) {
            fetchSuggestions(searchInput.value.trim());
        }
    });
    
    // Ocultar sugerencias al hacer click fuera
    document.addEventListener('click', (e) => {
        if (!searchForm.contains(e.target)) {
            hideSuggestions();
        }
    });
    
    // Manejar teclado
    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            hideSuggestions();
        }
    });
    
    // Evitar envío del formulario al seleccionar sugerencia
    suggestionsContainer.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});
</script>
    
@endpush