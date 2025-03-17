<style>
    .etiqueta-pill {
        display: inline-flex;
        align-items: center;
        background-color: #6366f1; /* Color indigo */
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
    }

    .etiqueta-pill button {
        margin-left: 0.5rem;
        background: none;
        border: none;
        color: white;
        cursor: pointer;
    }

    #sugerencias-container {
        max-height: 200px;
        overflow-y: auto;
    }

    #sugerencias-list li {
        transition: background-color 0.2s;
        padding: 8px;
        cursor: pointer;
    }

    #sugerencias-list li:hover {
        background-color: #f3f4f6; /* Color gris claro */
    }

    /* Estilo para etiquetas tachadas */
    .tachado {
        text-decoration: line-through;
        color: gray;
        cursor: not-allowed;
    }
</style>

<!-- Contenedor de etiquetas -->
<div>
    <label for="etiquetas" class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
    <div class="relative">
        <!-- Input para buscar/agregar etiquetas -->
        <input type="text" id="etiquetas-input" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200" placeholder="Buscar o agregar etiquetas">
        
        <!-- Contenedor para mostrar las sugerencias -->
        <div id="sugerencias-container" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg hidden">
            <ul id="sugerencias-list" class="py-1"></ul>
        </div>

        <!-- Contenedor para mostrar etiquetas seleccionadas -->
        <div id="etiquetas-container" class="mt-2 flex flex-wrap gap-2"></div>
    </div>

    <!-- Select oculto para sincronización con Laravel -->
    <select name="tags[]" id="tags-select" multiple class="w-full hidden">
        @foreach(old('tags', []) as $tagId)
            <option value="{{ $tagId }}" selected>
                {{ \App\Models\Tag::find($tagId)->name ?? '' }}
            </option>
        @endforeach
    </select>

    <!-- Mensaje de error de Laravel -->
    @error('tags')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const etiquetasInput = document.getElementById('etiquetas-input');
    const sugerenciasContainer = document.getElementById('sugerencias-container');
    const sugerenciasList = document.getElementById('sugerencias-list');
    const etiquetasContainer = document.getElementById('etiquetas-container');
    const tagsSelect = document.getElementById('tags-select');

    let etiquetasSeleccionadas = [];
    let todasLasEtiquetas = [];

    // Cargar etiquetas desde el backend
    async function cargarEtiquetas() {
        try {
            const response = await fetch('/fetch-tags');
            if (!response.ok) throw new Error('Error al cargar etiquetas');
            todasLasEtiquetas = await response.json();

            // Si Laravel devuelve old(), rellenar etiquetas iniciales
            document.querySelectorAll('#tags-select option').forEach(option => {
                if (option.value) {
                    agregarEtiqueta(option.textContent || todasLasEtiquetas.find(tag => tag.id == option.value)?.name, option.value, true);
                }
            });
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Mostrar sugerencias con etiquetas tachadas si ya fueron seleccionadas
    function mostrarSugerencias(query) {
        sugerenciasList.innerHTML = '';

        const sugerencias = todasLasEtiquetas.filter(tag =>
            tag.name.toLowerCase().includes(query.toLowerCase())
        );

        sugerencias.forEach(tag => {
            const li = document.createElement('li');
            li.textContent = tag.name;

            if (etiquetasSeleccionadas.some(e => e.id === tag.id)) {
                li.classList.add('tachado');
            } else {
                li.classList.add('hover:bg-gray-100');
                li.onclick = () => agregarEtiqueta(tag.name, tag.id);
            }

            sugerenciasList.appendChild(li);
        });

        sugerenciasContainer.classList.remove('hidden');
    }

    // Agregar etiqueta
    function agregarEtiqueta(nombre, id, inicial = false) {
        if (etiquetasSeleccionadas.some(etiqueta => etiqueta.id == id)) return;

        etiquetasSeleccionadas.push({ id, nombre });

        // Crear la "pill" de la etiqueta
        const pill = document.createElement('div');
        pill.className = 'etiqueta-pill';
        pill.setAttribute('data-id', id);
        pill.innerHTML = `
            ${nombre}
            <button type="button" onclick="eliminarEtiqueta(${id})">&times;</button>
        `;

        etiquetasContainer.appendChild(pill);

        // Agregar opción al select multiple
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

    // Eliminar etiqueta
    window.eliminarEtiqueta = function (id) {
        etiquetasSeleccionadas = etiquetasSeleccionadas.filter(etiqueta => etiqueta.id != id);
        document.querySelector(`.etiqueta-pill[data-id="${id}"]`).remove();
        document.querySelector(`#tags-select option[value="${id}"]`).remove();
    };

    // Evento para mostrar sugerencias
    etiquetasInput.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length > 0) {
            mostrarSugerencias(query);
        } else {
            sugerenciasContainer.classList.add('hidden');
        }
    });

    // Cargar etiquetas iniciales
    cargarEtiquetas();
});
</script>
