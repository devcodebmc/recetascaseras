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

            <div class="order-6">
                @include('frontend.components.minRecipes', ['limit' => 3])
            </div>

        </div>

        <!-- Right Column - Hidden on mobile except for More Recipes -->
        <div class="lg:w-80 xl:w-96  order-7">
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

            <!-- More Recipes Card -->
            <div class="bg-white p-6 sm:p-6 rounded-xl shadow-md mt-12">
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
            <div class="bg-orange-50 rounded-xl p-6 shadow-md mt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2 tracking-widest mt-8">
                    Etiquetas
                </h3>
                @include('frontend.components.tags')
            </div>

            <!-- Chef Card -->
            <div class="lg:mt-12 mt-0">
                @include('frontend.components.chefCard')
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