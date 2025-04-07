@extends('frontend.layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">{{ $recipe->title }}</h1>
        <p class="text-gray-700 mb-4">{{ $recipe->description }}</p>
{{-- 
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Ingredientes</h2>
            <ul class="list-disc pl-5">
                @foreach($receta->ingredients as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Instrucciones</h2>
            <ol class="list-decimal pl-5">
                @foreach($receta->instructions as $instruction)
                    <li>{{ $instruction }}</li>
                @endforeach
            </ol>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Comentarios</h2>
            @foreach($receta->comments as $comment)
                <div class="border-b border-gray-300 py-2">
                    <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                </div>
            @endforeach
        </div>

        @auth
            <form action="{{ route('frontend.recetas.comment', $receta) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="content" rows="3" placeholder="Escribe un comentario..." required class="w-full p-2 border border-gray-300 rounded"></textarea>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Comentar</button>
            </form>
        @endauth --}}

    </div>
@endsection
