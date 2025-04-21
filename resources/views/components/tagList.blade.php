<style>
    .etiqueta-pill {
        display: inline-flex;
        align-items: center;
        background-color: #6366f1;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .etiqueta-remove {
        margin-left: 0.5rem;
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 1rem;
    }
    
    .etiqueta-pill:hover {
        background-color: #4f46e5;
        transform: translateY(-1px);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    #sugerencias-list li {
        padding: 0.5rem 1rem;
        cursor: pointer;
    }
    
    #sugerencias-list li:hover {
        background-color: #f3f4f6;
    }
    
    .etiqueta-seleccionada {
        text-decoration: line-through;
        color: #9ca3af;
        cursor: not-allowed;
    }
</style>
<!-- Contenedor de etiquetas -->
<div>
    <label for="etiquetas" class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
    <div class="relative">
        <!-- Input para buscar etiquetas -->
        <input type="text" id="etiquetas-input" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" 
               placeholder="Buscar etiquetas">
        
        <!-- Contenedor para mostrar las sugerencias -->
        <div id="sugerencias-container" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto">
            <ul id="sugerencias-list" class="py-1"></ul>
        </div>

        <!-- Contenedor para mostrar etiquetas seleccionadas -->
        <div id="etiquetas-container" class="mt-2 flex flex-wrap gap-2">
            <!-- Mostrar etiquetas existentes en modo edición -->
            @isset($recipe)
                @foreach($recipe->tags as $tag)
                    <div class="etiqueta-pill" data-id="{{ $tag->id }}">
                        {{ $tag->name }}
                        <button type="button" onclick="eliminarEtiqueta({{ $tag->id }})" class="etiqueta-remove">
                            &times;
                        </button>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>

    <!-- Select oculto para sincronización con Laravel -->
    <select name="tags[]" id="tags-select" multiple class="w-full hidden">
        @isset($recipe)
            @foreach($recipe->tags as $tag)
                <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
            @endforeach
        @endisset
        
        @foreach(old('tags', []) as $tagId)
            @if(!isset($recipe) || !$recipe->tags->contains($tagId))
                <option value="{{ $tagId }}" selected>
                    {{ \App\Models\Tag::find($tagId)->name ?? '' }}
                </option>
            @endif
        @endforeach
    </select>

    <!-- Mensaje de error de Laravel -->
    @error('tags')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<script defer>
    // Componente autónomo que se ejecuta inmediatamente
    (function() {
        // Elementos del DOM
        const etiquetasInput = document.getElementById('etiquetas-input');
        const sugerenciasContainer = document.getElementById('sugerencias-container');
        const sugerenciasList = document.getElementById('sugerencias-list');
        const etiquetasContainer = document.getElementById('etiquetas-container');
        const tagsSelect = document.getElementById('tags-select');
    
        // Verificar que todos los elementos existen
        if (!etiquetasInput || !sugerenciasContainer || !sugerenciasList || !etiquetasContainer || !tagsSelect) {
            return;
        }
    
        let etiquetasSeleccionadas = [];
        let todasLasEtiquetas = [];
    
        // Inicializar etiquetas seleccionadas desde el DOM
        function inicializarEtiquetasSeleccionadas() {
            document.querySelectorAll('#etiquetas-container .etiqueta-pill').forEach(pill => {
                const id = pill.getAttribute('data-id');
                const nombre = pill.textContent.trim().replace('×', '').trim();
                if (id && nombre) {
                    etiquetasSeleccionadas.push({ id, nombre });
                }
            });
        }
    
        // Cargar etiquetas desde el backend
        async function cargarEtiquetas() {
            try {
                const response = await fetch('{{ route('fetch-tags.index') }}');
                if (!response.ok) throw new Error('Error al cargar etiquetas');
                todasLasEtiquetas = await response.json();
    
                // Si hay etiquetas en old(), agregarlas
                document.querySelectorAll('#tags-select option').forEach(option => {
                    if (option.value && !etiquetasSeleccionadas.some(e => e.id == option.value)) {
                        agregarEtiqueta(option.textContent, option.value, true);
                    }
                });
            } catch (error) {
                console.error('Error:', error);
            }
        }
    
        // Mostrar sugerencias de etiquetas
        function mostrarSugerencias(query) {
            sugerenciasList.innerHTML = '';
            const terminoBusqueda = query.toLowerCase();
    
            const sugerencias = todasLasEtiquetas.filter(tag =>
                tag.name.toLowerCase().includes(terminoBusqueda)
            );
    
            if (sugerencias.length === 0) {
                const li = document.createElement('li');
                li.className = 'px-4 py-2 text-gray-500';
                li.textContent = 'No se encontraron etiquetas';
                sugerenciasList.appendChild(li);
            } else {
                sugerencias.forEach(tag => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-2';
                    li.textContent = tag.name;
    
                    if (etiquetasSeleccionadas.some(e => e.id == tag.id)) {
                        li.classList.add('etiqueta-seleccionada');
                    } else {
                        li.classList.add('hover:bg-gray-100', 'cursor-pointer');
                        li.onclick = () => agregarEtiqueta(tag.name, tag.id);
                    }
    
                    sugerenciasList.appendChild(li);
                });
            }
    
            sugerenciasContainer.classList.remove('hidden');
        }
    
        // Agregar una etiqueta
        function agregarEtiqueta(nombre, id, inicial = false) {
            if (etiquetasSeleccionadas.some(e => e.id == id)) return;
    
            etiquetasSeleccionadas.push({ id, nombre });
    
            // Crear elemento visual
            const pill = document.createElement('div');
            pill.className = 'etiqueta-pill';
            pill.setAttribute('data-id', id);
            pill.innerHTML = `${nombre}<button type="button" onclick="window.eliminarEtiqueta(${id})" class="etiqueta-remove">&times;</button>`;
            etiquetasContainer.appendChild(pill);
    
            // Agregar al select multiple
            if (!inicial) {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = nombre;
                option.selected = true;
                tagsSelect.appendChild(option);
            }
    
            etiquetasInput.value = '';
            sugerenciasContainer.classList.add('hidden');
        }
    
        // Eliminar etiqueta (función global)
        window.eliminarEtiqueta = function(id) {
            etiquetasSeleccionadas = etiquetasSeleccionadas.filter(e => e.id != id);
            document.querySelector(`.etiqueta-pill[data-id="${id}"]`)?.remove();
            document.querySelector(`#tags-select option[value="${id}"]`)?.remove();
        };
    
        // Eventos
        etiquetasInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length > 0) {
                mostrarSugerencias(query);
            } else {
                sugerenciasContainer.classList.add('hidden');
            }
        });
    
        document.addEventListener('click', function(e) {
            if (!sugerenciasContainer.contains(e.target) && e.target !== etiquetasInput) {
                sugerenciasContainer.classList.add('hidden');
            }
        });
    
        // Inicialización inmediata
        inicializarEtiquetasSeleccionadas();
        cargarEtiquetas();
    })();
</script>