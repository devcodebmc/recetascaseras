<section class="bg-[#F5F3EF] py-16 px-4 md:px-12 lg:px-20">
    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-8 tracking-widest">
      Galería del Sazón
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach ($recipes as $key => $recipe)
        @if ($key <= 8)
        <img
          src="{{ asset($recipe->image) }}"
          alt="{{ $recipe->title }}"
          class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
        />          
        @endif
      @endforeach
    </div>
</section>