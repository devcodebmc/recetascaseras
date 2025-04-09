<div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-left text-gray-800 mb-10 tracking-widest">
        Categorías destacadas
        <span class="text-sm text-gray-600">
            (Estas son las categorías más populares entre nuestros usuarios)
        </span>
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        @foreach($categories->shuffle()->take(6) as $category)
            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-6 flex items-center justify-between space-x-4">
                    <h3 class="text-xl font-semibold text-gray-800 tracking-widest">
                        Recetas
                        <span class="{{ ['text-pink-400', 'text-blue-400', 'text-green-400', 'text-purple-400', 'text-yellow-400', 'text-teal-400', 'text-red-400', 'text-indigo-400', 'text-orange-400', 'text-cyan-400'][array_rand(['text-pink-400', 'text-blue-400', 'text-green-400', 'text-purple-400', 'text-yellow-400', 'text-teal-400', 'text-red-400', 'text-indigo-400', 'text-orange-400', 'text-cyan-400'])] }}">
                            {{ $category->name }}
                        </span>
                    </h3>
                    <img src="{{ asset($category->icon_url) }}" alt="{{ $category->name }}" class="w-12 h-12 object-cover rounded-full" />
                    <a href="{{ route('category.show', $category->slug) }}" class="inline-flex items-center text-green-600 hover:underline group">
                        <span class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full transition-transform duration-300 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>