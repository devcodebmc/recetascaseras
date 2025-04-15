@extends('frontend.layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Encabezado con breadcrumbs -->
    <div class="flex items-center text-sm text-gray-600 mb-6">
        <a href="{{ route('welcome') }}" class="hover:text-orange-500 transition-colors">Inicio</a>
        <span class="mx-2">/</span>
        <span class="text-orange-500">{{ $tag->slug }}</span>
    </div>

    <!-- Título principal -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-800 mb-4 tracking-wider">
            Recetas con la etiqueta
        </h1>
        <a href="{{ route('tag.show', $tag->slug) }}" class="inline-block bg-orange-500 text-white text-xl italic px-6 py-2 rounded-full shadow-md tracking-wider">
            {{ $tag->name }}
        </a>
        <p class="text-gray-600 mt-4">
            {{ $recipes->total() }} {{ Str::plural('receta', $recipes->total()) }} encontradas
        </p>
    </div>

    <!-- Grid de recetas -->
    @if($recipes->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($recipes as $recipe)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <a href="{{ route('showRecipe', $recipe->slug) }}" class="block">
                        <!-- Imagen -->
                        <div class="relative h-48 w-full overflow-hidden">
                            <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            <div class="absolute bottom-2 right-2 bg-amber-500 text-white text-sm font-semibold px-2.5 py-1 rounded-full tracking-widest">
                                {{ $recipe->category->name }}
                            </div>
                        </div>
                        
                        <!-- Contenido -->
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 hover:text-orange-500 transition-colors tracking-wider">
                                {{ Str::limit($recipe->title, 50) }}
                            </h3>
                            
                            <!-- Metadata -->
                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                <span class="flex items-center mr-4">
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
                                
                                @if($recipe->likes)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    {{ $recipe->likes }}
                                </span>
                                @endif
                            </div>
                            
                            <!-- Etiquetas -->
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach($recipe->tags->take(3) as $tag)
                                    <a href="{{ route('tag.show', $tag->slug) }}" class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full hover:bg-orange-100 hover:text-orange-600 transition-colors">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <!-- Paginación -->
        <div class="mt-8">
            {{ $recipes->links() }}
        </div>

        <section class="mt-8 lg:mt-16 order-5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @include('frontend.components.topCategories')
            </div>
        </section>

        <div class="mt-12">
            @include('frontend.partials.invitacionRecetas')
        </div>

        <div class="mt-12">
            @include('frontend.partials.suscribete')
        </div>
        
    @else
        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-orange-700">
                        No se encontraron recetas con esta etiqueta. Explora nuestras <a href="{{ route('recipes.index') }}" class="font-medium text-orange-600 hover:text-orange-500">otras recetas</a>.
                    </p>
                </div>
            </div>
            @include('frontend.components.minRecipes', ['limit' => 6])
        </div>

    @endif
</div>
@endsection