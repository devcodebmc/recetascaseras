<div class="bg-white rounded-2xl shadow-lg  hover:shadow-xl transition-all duration-300 border border-gray-100 p-8">
    <!-- Imagen circular con marco elegante -->
    <div class="flex justify-center mb-6">
        <div class="relative group">
            <!-- Marco decorativo -->
            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-amber-300 to-amber-400 p-1.5 transform rotate-3 scale-105 transition-all duration-300 group-hover:rotate-6 group-hover:from-amber-400 group-hover:to-amber-500"></div>
            <!-- Foto del chef -->
            <img class="relative w-36 h-36 rounded-full object-cover border-4 border-white shadow-lg transition-transform duration-300 group-hover:scale-105" 
                src="{{ asset('images/hero-Photoroom.png') }}" 
                alt="{{ $recipe->user->name }}"
                onerror="this.src='{{ asset('images/default-chef.png') }}'">
        </div>
    </div>
    
    <!-- Contenido de la tarjeta -->
    <div class="text-center">
        <!-- Nombre y especialidad -->
        <div class="mb-6">
            <h3 class="text-3xl font-serif font-bold text-gray-800 mb-2 tracking-wider">
                {{ $recipe->user->name }}
            </h3>
            <p class="text-lg text-amber-500 font-medium">
                Especialista en cocina tradicional
            </p>
        </div>
        
        <!-- Redes sociales - Versión mejorada -->
        <div class="flex justify-center space-x-4 mb-6">
            <!-- Facebook -->
            <a href="#" class="text-gray-400 hover:text-[#1877F2] transition-colors duration-300 transform hover:-translate-y-1" aria-label="Facebook">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                </svg>
            </a>
            
            <!-- Instagram -->
            <a href="#" class="text-gray-400 hover:text-[#E4405F] transition-colors duration-300 transform hover:-translate-y-1" aria-label="Instagram">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                </svg>
            </a>
            
            <!-- YouTube -->
            <a href="#" class="text-gray-400 hover:text-[#FF0000] transition-colors duration-300 transform hover:-translate-y-1" aria-label="YouTube">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </a>
        </div>

        <!-- Estadísticas del chef con iconos -->
        <div class="flex justify-center divide-x divide-gray-200 border-y border-gray-200 py-4 mb-6">
            <div class="text-center px-6">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $recipe->user->recipes()->count() }}
                    </p>
                </div>
                <p class="text-sm text-gray-500 mt-1">Recetas</p>
            </div>
            <div class="text-center px-6">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $recipe->user->totalLikes() }}
                    </p>
                </div>
                <p class="text-sm text-gray-500 mt-1">Likes</p>
            </div>
        </div>
        
        <!-- Botón de acción mejorado -->
        <a href="#" 
        class="inline-flex items-center justify-center w-full px-6 py-3 text-lg font-medium tracking-wide text-white transition duration-300 transform rounded-lg bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-md hover:shadow-lg group focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-opacity-50">
            Ver perfil completo
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </a>
    </div>
</div>