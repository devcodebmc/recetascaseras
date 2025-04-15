<div class="container mx-auto px-4">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-3 tracking-widest">
            ¿Y si probamos algo nuevo?
        </h2>
        <p class="text-xl text-gray-600">Recetas novedosas para sorprender a todos</p>
    </div>

    <div class="flex flex-wrap justify-center gap-4 max-w-4xl mx-auto">
        <!-- Etiqueta Side -->
        @foreach ($tags as $key => $tag)
            @if ($key <= 5 )
            @php
                $colors = [
                    'bg-pink-100 text-pink-800', 
                    'bg-purple-100 text-purple-800', 
                    'bg-green-100 text-green-800', 
                    'bg-yellow-100 text-yellow-800', 
                    'bg-blue-100 text-blue-800', 
                    'bg-indigo-100 text-indigo-800', 
                    'bg-teal-100 text-teal-800',
                    'bg-red-100 text-red-800',
                    'bg-orange-100 text-orange-800',
                    'bg-gray-100 text-gray-800',
                    'bg-lime-100 text-lime-800',
                    'bg-cyan-100 text-cyan-800',
                    'bg-amber-100 text-amber-800',
                    'bg-rose-100 text-rose-800',
                    'bg-emerald-100 text-emerald-800',
                    'bg-teal-200 text-teal-700',
                    'bg-sky-500 text-white',
                    'bg-emerald-500 text-white',
                    'bg-blue-500 text-white',
                    'bg-violet-500 text-white',
                    'bg-fuchsia-500 text-white',
                    'bg-pink-500 text-white',
                    'bg-rose-500 text-white',
                    'bg-orange-500 text-white',
                    'bg-indigo-500 text-white',
                    'bg-teal-500 text-white',
                    'bg-green-500 text-white',
                    'bg-yellow-500 text-white',
                    'bg-lime-500 text-white',
                ];
                $randomColor = $colors[array_rand($colors)];
            @endphp
            <a href="{{ route('tag.show', $tag->slug) }}" class="px-6 py-2 {{ $randomColor }} rounded-full font-medium hover:opacity-80 transition-opacity duration-300 shadow-sm">
                {{ $tag->name }}
            </a>
            @endif
        @endforeach
    </div>
</div>
