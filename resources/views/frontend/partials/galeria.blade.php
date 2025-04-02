<section class="bg-[#F5F3EF] py-16 px-4 md:px-12 lg:px-20">
  <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-8 tracking-widest">
    Galería del Sazón
  </h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach ($recipes->sortByDesc('likes') as $key => $recipe)
    @if ($key <= 8)
    <div class="relative">
      <img
      src="{{ asset($recipe->image) }}"
      alt="{{ $recipe->title }}"
      class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
      />
      <div class="absolute bottom-4 left-4 flex items-center space-x-2 bg-white bg-opacity-75 px-3 py-1 rounded-full shadow-md">
      <button class="text-red-400 hover:text-red-500 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
      </button>
      <span class="text-gray-700 font-medium">{{ $recipe->likes ?? 0 }}</span>
      </div>
    </div>
    @endif
    @endforeach
  </div>
</section>