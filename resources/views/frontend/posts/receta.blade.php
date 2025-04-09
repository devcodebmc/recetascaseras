@extends('frontend.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Layout Container -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content (Left Side - Reordered for mobile) -->
        <div class="flex-1 flex flex-col lg:block">
            <!-- Title & Metadata -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight text-gray-900 mb-4">
                    {{ $recipe->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/chef-masculino.png') }}" class="rounded-full w-8 h-8" alt="Author">
                        <span class="font-medium text-gray-800">{{ $recipe->user->name }}</span>
                        <span class="text-gray-400">· {{ $recipe->created_at->format('d M Y') }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500">⏱️</span>
                        <span>
                            Prep: 
                            <strong>  
                                @if ($recipe->prep_time > 60)
                                    {{ intdiv($recipe->prep_time, 60) }}h {{ $recipe->prep_time % 60 }}m 
                                @else
                                    {{ $recipe->prep_time }}m 
                                @endif
                            </strong>
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500">🔥</span>
                        <span>
                            Cocina: 
                            <strong>
                                @if ($recipe->cook_time > 60)
                                    {{ intdiv($recipe->cook_time, 60) }}h {{ $recipe->cook_time % 60 }}m
                                @else
                                    {{ $recipe->cook_time }}m
                                @endif
                            </strong>
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="bg-amber-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ $recipe->category->name }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Video/Image Section -->
            <div class="relative rounded-xl overflow-hidden shadow-lg mb-8 bg-gray-100 aspect-video order-1">
                <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}"
                    class="w-full h-full object-cover">
                <button class="absolute inset-0 flex items-center justify-center bg-black/30 hover:bg-black/40 transition">
                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </button>
            </div>

            <!-- Description Section -->
            <div class="bg-orange-50 rounded-xl p-6 shadow-md mb-8 order-2">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2 tracking-widest">
                    Descripción
                </h2>
                <div class="text-gray-700 leading-relaxed space-y-4 text-lg">
                    {!! $recipe->description !!}
                </div>
            </div>

            <!-- Ingredients Card - Moved here for mobile -->
            <div class="bg-blue-50 rounded-xl p-6 shadow-md mb-8 lg:hidden order-3">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 tracking-widest border-b pb-2">
                    Ingredientes
                </h2>
                <ul class="space-y-3">
                    @foreach (json_decode($recipe->ingredients) as $index => $ingredient)
                    <li class="flex items-start gap-3 text-gray-700 text-lg">
                        <input 
                            type="checkbox" 
                            id="ingredient-mobile-{{ $index }}" 
                            class="mt-2 cursor-pointer appearance-none w-3 h-3 border-2 border-red-500 rounded-full checked:bg-red-500 checked:border-red-500 focus:ring-0" 
                            onclick="toggleIngredientMobile({{ $index }})"
                        >
                        <label 
                            for="ingredient-mobile-{{ $index }}" 
                            id="ingredient-label-mobile-{{ $index }}" 
                            class="cursor-pointer hover:text-gray-900 transition-colors"
                        >
                            {{ $ingredient }}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Steps Section -->
            <div class="rounded-xl mb-0 lg:mb-0 order-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 tracking-widest">
                    Pasos e Instrucciones
                </h2>

                <ol class="space-y-6">
                    @foreach (json_decode($recipe->steps) as $index => $step)
                        <li class="flex items-start gap-4">
                            <!-- Step Number -->
                            <div 
                                id="step-number-{{ $index }}" 
                                class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold flex-shrink-0 cursor-pointer hover:bg-orange-600 transition-colors"
                                onclick="toggleStep({{ $index }})"
                            >
                                {{ $index + 1 }}
                            </div>

                            <!-- Step Text -->
                            <div 
                                id="step-text-{{ $index }}" 
                                class="bg-white border border-gray-200 rounded-xl p-5 w-full shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                                onclick="toggleStep({{ $index }})"
                            >
                                <p class="text-gray-700 leading-relaxed text-lg">
                                    {{ $step }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            <section class="mt-8 lg:mt-16 order-5">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @include('frontend.components.topCategories')
                </div>
            </section>

            <div class="max-w-7xl mx-auto px-4 py-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Otras recetas que te pueden gustar</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(\App\Models\Recipe::all()->shuffle()->take(3) as $recipe)
                    <a href="{{ route('showRecipe', $recipe->slug) }}" class="group block rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 bg-white">
                        <!-- Imagen con overlay hover -->
                        <div class="relative overflow-hidden h-48">
                            <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors duration-300"></div>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-orange-600 transition-colors">
                                {{ Str::limit($recipe->title, 40) }}
                            </h3>
                            
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                                <!-- Tiempo de preparación -->
                                <span class="flex items-center bg-gray-100 rounded-full px-3 py-1">
                                    <svg class="w-4 h-4 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @if($recipe->prep_time > 60)
                                        {{ intdiv($recipe->prep_time, 60) }}h {{ $recipe->prep_time % 60 }}m
                                    @else
                                        {{ $recipe->prep_time }}m
                                    @endif
                                </span>
                                
                                <!-- Categoría -->
                                <span class="bg-amber-100 text-amber-800 rounded-full px-3 py-1">
                                    {{ $recipe->category->name }}
                                </span>
                                
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
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column - Hidden on mobile except for More Recipes -->
        <div class="lg:w-80 xl:w-96 space-y-8 order-6">
            <!-- Ingredients Card - Hidden on mobile, shown on lg+ -->
            <div class="bg-blue-50 rounded-xl p-6 shadow-md lg:mt-12 mt-0 hidden lg:block">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 tracking-widest border-b pb-2">
                    Ingredientes
                </h2>
                <ul class="space-y-3">
                    @foreach (json_decode($recipe->ingredients) as $index => $ingredient)
                    <li class="flex items-start gap-3 text-gray-700 text-lg">
                        <input 
                            type="checkbox" 
                            id="ingredient-{{ $index }}" 
                            class="mt-2 cursor-pointer appearance-none w-3 h-3 border-2 border-red-500 rounded-full checked:bg-red-500 checked:border-red-500 focus:ring-0" 
                            onclick="toggleIngredient({{ $index }})"
                        >
                        <label 
                            for="ingredient-{{ $index }}" 
                            id="ingredient-label-{{ $index }}" 
                            class="cursor-pointer hover:text-gray-900 transition-colors"
                        >
                            {{ $ingredient }}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Chef Card -->
            @include('frontend.components.chefCard')

            <!-- Tags Card -->
            <div class="bg-orange-50 rounded-xl p-6 shadow-md lg:mt-12 mt-0">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2 tracking-widest mt-8">
                    Etiquetas
                </h3>
                @include('frontend.components.tags')
            </div>
            
            <!-- More Recipes Card -->
            <div class="bg-white p-6 sm:p-6 rounded-xl shadow-md lg:mt-8 mt-0">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2 tracking-widest">
                    Más Recetas
                </h3>
                <div class="space-y-4">
                    @foreach($smallRecipes as $smallRecipe)
                    <a href="{{ route('showRecipe', $smallRecipe->slug) }}" class="block group">
                        <div class="flex gap-4 items-center">
                            <div class="flex-shrink-0 w-32 h-20 rounded-lg overflow-hidden shadow">
                                <img src="{{ asset($smallRecipe->image) }}" 
                                    alt="{{ $smallRecipe->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 group-hover:text-orange-500 transition-colors text-lg tracking-widest">
                                    {{ Str::limit($smallRecipe->title, 40) }}
                                </h4>
                                <div class="flex items-center text-sm text-gray-500 mt-1">
                                    <span>{{ $smallRecipe->category->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>
                                        @php
                                            $totalTime = $smallRecipe->prep_time + $smallRecipe->cook_time;
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
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('frontend.partials.invitacionRecetas')
</div>
@endsection

@push('js')
<script>
    // Function to toggle step completion
    function toggleStep(index) {
        const stepNumber = document.getElementById(`step-number-${index}`);
        const stepText = document.getElementById(`step-text-${index}`);

        if (stepNumber.classList.contains('bg-green-500')) {
            stepNumber.classList.remove('bg-green-500');
            stepNumber.classList.add('bg-orange-500');
            stepNumber.innerHTML = index + 1;

            stepText.classList.remove('bg-green-100', 'border-green-300');
            stepText.querySelector('p').style.color = '';
        } else {
            stepNumber.classList.remove('bg-orange-500');
            stepNumber.classList.add('bg-green-500');
            stepNumber.innerHTML = '✓';

            stepText.classList.add('bg-green-100', 'border-green-300');
            stepText.querySelector('p').style.color = 'green';
        }
    }

    // Function to toggle ingredient completion (desktop)
    function toggleIngredient(index) {
        const label = document.getElementById(`ingredient-label-${index}`);
        if (label.style.textDecoration === 'line-through') {
            label.style.textDecoration = 'none';
            label.style.color = '';
            label.style.opacity = '1';
        } else {
            label.style.textDecoration = 'line-through';
            label.style.color = 'gray';
            label.style.opacity = '0.8';
        }
    }

    // Function to toggle ingredient completion (mobile)
    function toggleIngredientMobile(index) {
        const label = document.getElementById(`ingredient-label-mobile-${index}`);
        if (label.style.textDecoration === 'line-through') {
            label.style.textDecoration = 'none';
            label.style.color = '';
            label.style.opacity = '1';
        } else {
            label.style.textDecoration = 'line-through';
            label.style.color = 'gray';
            label.style.opacity = '0.8';
        }
    }

</script>
@endpush