@extends('frontend.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Layout Container -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Main Content (Left Side - Reordered for mobile) -->
        <div class="flex-1 flex flex-col lg:block">
            <!-- Title & Metadata -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-gray-900 mb-4 tracking-wider">
                    {{ $recipe->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/chef-masculino.png') }}" class="rounded-full w-8 h-8" alt="Author">
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-800">{{ $recipe->user->name }}</span>
                            <span class="text-gray-400">{{ $recipe->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col">
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
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('category.show', $recipe->category->slug) }}" class="block w-full tracking-widest">
                            <span class="bg-amber-500 text-white text-sm px-2.5 py-1 rounded-full">
                                {{ $recipe->category->name }}
                            </span>
                        </a>
                    </div>

                    <div class="relative flex items-center gap-2 bg-gray-50 bg-opacity-75 px-3 py-1 rounded-full shadow-md">
                        @include('frontend.components.likeButton')
                    </div>

                    {{-- Print Button con Tooltip Elegante --}}
                    <div class="flex items-center gap-2">
                        <div class="relative group">
                            <!-- Botón de imprimir -->
                            <a href="#" onclick="window.print();" class="text-gray-500 hover:text-amber-500 transition-colors duration-300" aria-label="Imprimir receta">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                </svg>
                            </a>

                            <!-- Tooltip personalizado -->
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block px-3 py-1 text-xs text-white bg-amber-400 whitespace-nowrap z-100 rounded-md shadow-lg transition-all duration-300">
                                Imprimir
                            </div>
                        </div>
                    </div>

                    {{-- Social Share Buttons --}}
                    @include('frontend.components.socialButtons')
                    
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
            <div class="bg-white rounded-xl p-6 shadow-md mb-8 order-2">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2 tracking-widest">
                    Descripción
                </h2>
                <div class="text-gray-700 leading-relaxed space-y-4 text-lg">
                    {!! $recipe->description !!}
                </div>
            </div>

            <!-- Ingredients Card - Moved here for mobile -->
            <div class="bg-white rounded-xl p-6 shadow-md mb-8 lg:hidden order-3">
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
                    <!-- Steps List -->
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

            <div class="order-6">
                @php
                    $steps = json_decode($recipe->steps);
                    $stepsCount = count($steps);
                @endphp
                @include('frontend.components.minRecipes', ['limit' => $stepsCount >= 8 ? 3 : 6])
            </div>

        </div>

        <!-- Right Column - Hidden on mobile except for More Recipes -->
        <div class="lg:w-80 xl:w-96  order-7">
            <!-- Ingredients Card - Hidden on mobile, shown on lg+ -->
            <div class="bg-white rounded-xl p-6 shadow-md lg:mt-12 mt-0 hidden lg:block">
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

            <!-- More Recipes Card -->
            <div class="bg-white p-6 sm:p-6 rounded-xl shadow-md mt-4 lg:mt-12">
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

            <!-- Tags Card -->
            <div class="bg-white rounded-xl p-6 shadow-md mt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2 tracking-widest mt-8">
                    Etiquetas
                </h3>
                @include('frontend.components.tags')
            </div>

            <!-- Chef Card -->
            <div class="mt-12">
                @include('frontend.components.chefCard')
            </div>

            <!-- Social Share Card -->
            <div class="mt-12">
                @include('frontend.components.socialCard')
            </div>
            
        </div>
    </div>
    @include('frontend.partials.invitacionRecetas')
    <div class="mt-12">
        @include('frontend.partials.suscribete')
    </div>
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