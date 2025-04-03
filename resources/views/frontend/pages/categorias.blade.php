@extends('frontend.layouts.main')

@section('content')
<div class="flex flex-col md:flex-row">
    <!-- Sidebar -->
    <div class="w-full md:w-1/4 lg:w-1/4 h-auto md:h-screen md:sticky md:top-0 p-4 overflow-y-auto">
        @include('frontend.components.categorySidebar')
    </div>

    <!-- Main Content -->
    <div class="w-full md:w-3/4 lg:w-4/5 p-6">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-green-100 to-green-200 border border-green-200 rounded-xl p-8 mb-8 text-green-800">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 tracking-widest">Explora Nuevas Recetas</h1>
            <p class="text-lg md:text-xl">
                Descubre nuevos sabores y técnicas culinarias con nuestra selección de
                <span class="font-bold text-green-700 text-2xl">{{ $recipes[0]->category->name }}</span>.
            </p>
        </div>

        <!-- Divider -->
        <div class="border-b border-gray-200 my-6"></div>

        <section class="mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center tracking-widest">
                <span class="bg-amber-100 text-amber-800 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a4 4 0 00-4 4v1H7a3 3 0 00-3 3v1a1 1 0 001 1h14a1 1 0 001-1V9a3 3 0 00-3-3h-1V6a4 4 0 00-4-4zM6 16v2a2 2 0 002 2h8a2 2 0 002-2v-2H6z" />
                    </svg>
                </span>
                @if(Str::endsWith($recipes[0]->category->name, ['a', 'as']))
                    Nuevas recetas de {{ $recipes[0]->category->name }}
                @else
                    Nuevos recetarios de {{ $recipes[0]->category->name }}
                @endif
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($recipes as $recipe)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}">
                        <span class="absolute top-2 right-2 bg-amber-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                            Nuevo
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 tracking-widest">
                            {{ $recipe->title }}
                        </h3>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $recipe->prep_time + $recipe->cook_time }} min
                            </span>
                            <a href="{{ route('recipes.show', $recipe->slug) }}" class="text-amber-600 hover:text-amber-700 font-medium text-sm flex items-center">
                                Ver receta
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Top Recipes Section -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center tracking-widest">
                <span class="bg-amber-100 text-amber-800 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-pulse">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>                      
                </span>
                Top {{ $recipes[0]->category->name }}
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($recipes->sortByDesc('likes') as $recipe)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative">
                    <img class="w-full h-48 object-cover" src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}">
                    <span class="absolute top-2 right-2 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                        Top
                    </span>
                    </div>
                    <div class="p-5">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 tracking-widest">
                        {{ $recipe->title }}
                    </h3>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $recipe->prep_time + $recipe->cook_time }} min
                        </span>
                        <a href="{{ route('recipes.show', $recipe->slug) }}" class="text-amber-600 hover:text-amber-700 font-medium text-sm flex items-center">
                            Ver receta
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        <!-- Chefs Section -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center tracking-widest">
                <span class="bg-amber-100 text-amber-800 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a4 4 0 00-4 4v1H7a3 3 0 00-3 3v1a1 1 0 001 1h14a1 1 0 001-1V9a3 3 0 00-3-3h-1V6a4 4 0 00-4-4zM6 16v2a2 2 0 002 2h8a2 2 0 002-2v-2H6z" />
                    </svg>
                </span>
                Cocineros destacados
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($recipes as $recipe)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="{{ asset('images/chef-masculino.png') }}" alt="{{ $recipe->user->name }}">
                        <span class="absolute top-2 right-2 bg-indigo-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                            Chef
                        </span>
                    </div>
                    <div class="p-5 text-center">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 tracking-widest">
                            {{ $recipe->user->name }}
                        </h3>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center justify-center">
                            Ver recetas
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        <!-- Histories Section -->
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center tracking-widest">
                <span class="bg-amber-100 text-amber-800 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-pulse">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>                      
                </span>
                Historias recientes
            </h2>
            @include('frontend.partials.historias')
        </section>
    </div>
</div>

<!-- Suscríbete Section -->
<div class="py-6">
    @include('frontend.partials.suscribete')
</div>

@endsection