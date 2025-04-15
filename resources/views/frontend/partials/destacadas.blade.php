<section class="bg-[#F5F3EF] p-10">
    <!-- Contenido Principal -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="text-3xl font-bold mb-4 md:mb-0 tracking-widest">Recetas</h2>
        {{-- Buscador principal --}}
        @include('frontend.components.buscador')
        <form method="GET" action="{{ route('welcome') }}" class="bg-white px-4 py-2 rounded-full shadow-md flex items-center border border-gray-300 font-secondary">
            <label for="sort" class="mr-2 font-medium text-gray-700">Ordenar por:</label>
            <div class="relative inline-block">
            <select name="sort" id="sort" onchange="this.form.submit()" 
                class="bg-white text-gray-800 font-medium px-4 py-1 rounded-full appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200">
                <option value="nuevos" {{ request('sort', 'nuevos') === 'nuevos' ? 'selected' : '' }}>
                    Nuevos
                </option>
                <option value="antiguos" {{ request('sort') === 'antiguos' ? 'selected' : '' }}>
                    Antiguos
                </option>
                <option value="populares" {{ request('sort') === 'populares' ? 'selected' : '' }}>
                    Populares
                </option>
            </select>
            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 pointer-events-none">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
       @include('frontend.components.categorySidebar')
        <!-- Main Content -->
        <div class="col-span-1 md:col-span-2 grid grid-cols-1 gap-8">
            <!-- Large Recipe Cards -->
            @foreach ($recipes as $key => $recipe)
            @if ($key <= 3)
            <a href="{{ route('showRecipe', $recipe->slug) }}" class="block">
                <div class="bg-white rounded-xl md:rounded-l-full md:rounded-r-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="flex flex-col md:flex-row h-full">
                    <div class="md:w-1/1 p-4 flex items-center justify-center md:justify-start">
                    <div class="relative w-40 h-40 md:w-48 md:h-48 lg:w-56 lg:h-56 rounded-full overflow-hidden border-4 border-amber-100 shadow-inner">
                        <img 
                        src="{{ asset($recipe->image) }}" 
                        alt="{{ $recipe->title }}" 
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                        loading="lazy"
                        >
                    </div>
                    </div>
                    <!-- Content - Ajustado para alineación perfecta -->
                    <div class="p-6 md:w-2/3 flex flex-col justify-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3 tracking-widest">{{ $recipe->title }}</h3>
                        
                        <div class="recipe-description text-gray-600 mb-1 line-clamp-4">
                        {!! $recipe->description !!}
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 text-sm text-gray-500 mt-4">
                        <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-medium text-gray-700">{{ $recipe->servings }} porciones</span>
                        </span>
                        
                        <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium text-gray-700">
                            @if ($recipe->cook_time > 60)
                            {{ intdiv($recipe->cook_time, 60) }}h {{ $recipe->cook_time % 60 }}m
                            @else
                            {{ $recipe->cook_time }}m
                            @endif
                        </span>
                        </span>
                    </div>
                    </div>
                </div>
                </div>
            </a>
            @endif
            @endforeach
        </div>
        <div class="col-span-1 grid grid-cols-1 gap-5">
            <!-- Recipe Cards with Background Image -->
            @foreach ($recipes as $key => $recipe)
                @if ($key >= 4 && $key <= 7)
                <div class="relative rounded-xl shadow-lg overflow-hidden group min-h-[160px] hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <a href="{{ route('showRecipe', $recipe->slug) }}" class="block h-full">
                        <!-- Background Image Container -->
                        <div class="absolute inset-0 bg-yellow-200">
                            <img 
                                src="{{ asset($recipe->image) }}" 
                                alt="{{ $recipe->title }}" 
                                class="w-full h-full object-cover object-center opacity-90 group-hover:opacity-80 group-hover:scale-105 transition-all duration-500 ease-in-out"
                                loading="lazy"
                            >
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-amber-100/10 to-black/60"></div>
                        </div>
                        
                        <!-- Content Container -->
                        <div class="relative h-full flex flex-col justify-end p-5 text-white">
                        <!-- Time Information -->
                            <div class="flex flex-wrap items-center gap-3 text-sm">
                                <!-- Prep Time (Knife Icon) -->
                                <span class="flex items-center bg-black/40 rounded-full px-3 py-1 backdrop-blur-sm border border-white/10">
                                    <svg class="w-4 h-4 mr-1.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg> 
                                    @if ($recipe->prep_time > 60)
                                        {{ intdiv($recipe->prep_time, 60) }}h {{ $recipe->prep_time % 60 }}m 
                                    @else
                                        {{ $recipe->prep_time }}m 
                                    @endif
                                </span>
                                
                                <!-- Cook Time (Pot Icon) -->
                                <span class="flex items-center bg-black/40 rounded-full px-3 py-1 backdrop-blur-sm border border-white/10">
                                    <svg class="w-4 h-4 mr-1.5 text-amber-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                                    </svg>                                   
                                    @if ($recipe->cook_time > 60)
                                        {{ intdiv($recipe->cook_time, 60) }}h {{ $recipe->cook_time % 60 }}m
                                    @else
                                        {{ $recipe->cook_time }}m
                                    @endif
                                </span>
                                
                                <!-- Servings -->
                                <span class="flex items-center bg-black/40 rounded-full px-3 py-1 backdrop-blur-sm border border-white/10">
                                    <svg class="w-4 h-4 mr-1.5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    {{ $recipe->servings }} porciones
                                </span>
                                
                                <!-- Calculated Difficulty -->
                                @php
                                    $totalTime = ($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0);
                                    $difficulty = 'Fácil';
                                    
                                    if ($totalTime > 90 || $recipe->servings > 6) {
                                        $difficulty = 'Difícil';
                                    } elseif ($totalTime > 45 || $recipe->servings > 4) {
                                        $difficulty = 'Media';
                                    }
                                    
                                    $difficultyColor = [
                                        'Fácil' => 'text-emerald-400',
                                        'Media' => 'text-amber-400',
                                        'Difícil' => 'text-red-400'
                                    ][$difficulty];
                                @endphp
                                <span class="flex items-center bg-black/40 rounded-full px-3 py-1 backdrop-blur-sm border border-white/10">
                                    <svg class="w-4 h-4 mr-1.5 {{ $difficultyColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    {{ $difficulty }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Hover Effect Indicator -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <!-- Recipe Title -->
                            <h3 class="text-lg sm:text-xl text-white font-semibold bg-black/40 backdrop-blur-md rounded-full px-4 py-2 shadow-lg tracking-widest">
                                {{ $recipe->title }}
                            </h3>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

