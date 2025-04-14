<div class="bg-white rounded-xl p-6 shadow-md mt-8 border border-gray-100">
    <!-- Encabezado con icono -->
    <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
        <svg class="w-6 h-6 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-gray-800 tracking-wider">
            Comparte esta receta
        </h3>
    </div>
    
    <!-- Contenido -->
    <div class="space-y-4">
        <p class="text-gray-700 mb-4">
            ¿Te gustó esta receta? Compártela con tus amigos y familiares.
        </p>
        
        <!-- Botones sociales -->
        <div class="pt-2">
            @include('frontend.components.socialButtons')
        </div>
        
        <!-- Copiar enlace -->
        <div class="flex items-center mt-4">
            <input 
                type="text" 
                value="{{ url()->current() }}" 
                id="share-url"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-orange-300 focus:border-orange-400 text-gray-700"
                readonly
            >
            <button 
                onclick="copyShareLink()"
                class="px-4 py-2 bg-orange-500 text-white font-medium rounded-r-lg hover:bg-orange-600 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-300"
            >
                Copiar
            </button>
        </div>
        <p id="copy-feedback" class="text-sm text-green-600 hidden">¡Enlace copiado!</p>
    </div>
</div>

@push('js')
<script>
    function copyShareLink() {
        const copyText = document.getElementById("share-url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        
        // Mostrar feedback
        const feedback = document.getElementById("copy-feedback");
        feedback.classList.remove("hidden");
        setTimeout(() => feedback.classList.add("hidden"), 2000);
    }
</script>
@endpush