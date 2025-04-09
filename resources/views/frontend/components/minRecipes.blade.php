<div class="max-w-7xl mx-auto px-4 lg:py-12 py-6">
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
                    
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
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
                        
                        <!-- Likes (si tienes este campo) -->
                        @if($recipe->likes_count)
                        <span class="flex items-center bg-pink-100 text-pink-800 rounded-full px-3 py-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            {{ $recipe->likes_count }}
                        </span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>