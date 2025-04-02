<section class="bg-gradient-to-r from-yellow-100 to-yellow-300 py-16 px-6 md:px-12 lg:px-24 text-center rounded-3xl">
    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 tracking-widest">
      Conozcamos a Nuestros Cocineros de la Semana
    </h2>
    <p class="text-gray-600 mb-8">
      Ellas destacan por su pasión, talento y experiencia en la cocina, creando platos inolvidables para nuestros paladares.
    </p>
    <div class="flex flex-col md:flex-row justify-center gap-8">
      @foreach ($topChefs as $index => $topChef)
      <div class="relative bg-white rounded-3xl p-6 text-center shadow-lg w-full md:w-1/3 transform transition duration-500 hover:scale-105">
          <div class="absolute inset-0 bg-gray-400 opacity-20 rounded-3xl transform rotate-6"></div>
          <img src="{{ asset('images/chef-masculino.png') }}" alt="Cocinera {{ $index + 1 }}" class="relative w-40 h-40 mx-auto rounded-full object-cover border-4 border-yellow-200">
          <h3 class="relative text-xl font-bold text-gray-900 mt-4 tracking-widest">
            {{ $topChef->user->name }}
          </h3>
          <p class="relative text-gray-600">{{ $topChef->recipe_count }} recetas publicadas</p>
          <div class="relative mt-2">
          @if ($index == 0)
          <span class="text-yellow-500 text-xl">★ ★ ★</span>
          @elseif ($index == 1)
          <span class="text-yellow-500 text-xl">★ ★</span>
          @elseif ($index == 2)
          <span class="text-yellow-500 text-xl">★</span>
          @endif
          </div>
      </div>
      @endforeach
    </div>
</section>