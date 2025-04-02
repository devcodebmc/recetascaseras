<section class="py-2 pb-8 px-10 bg-white">
    <h2 class="text-3xl font-bold mb-6 tracking-widest">Descubre</h2>

    <!-- Categorías -->
    <div class="flex flex-wrap gap-4 text-gray-400 font-secondary mb-8 justify-center md:justify-start">
        <span class="cursor-pointer border-b-2 border-gray-500 pb-4">Todo</span>
        <span class="cursor-pointer">Desayuno</span>
        <span class="cursor-pointer">Almuerzo</span>
        <span class="cursor-pointer">Cena</span>
        <span class="cursor-pointer">Aperitivo</span>
    </div>

    <div class="flex flex-col md:flex-row">
        <!-- Etiquetas -->
        <div class="flex flex-wrap gap-4 mb-12 md:mb-0 md:w-1/4 font-secondary">
            @foreach ($tags as $index => $tag)
                @php
                    // Colores y efectos más sofisticados
                    $colorVariants = [
                        'bg-blue-100 text-blue-800 border border-blue-200 hover:bg-blue-200',
                        'bg-green-100 text-green-800 border border-green-200 hover:bg-green-200',
                        'bg-amber-100 text-amber-800 border border-amber-200 hover:bg-amber-200',
                        'bg-purple-100 text-purple-800 border border-purple-200 hover:bg-purple-200',
                        'bg-pink-100 text-pink-800 border border-pink-200 hover:bg-pink-200',
                        'bg-indigo-100 text-indigo-800 border border-indigo-200 hover:bg-indigo-200',
                        'bg-amber-100 text-amber-800 border border-amber-200 hover:bg-amber-200',
                        'bg-rose-100 text-rose-800 border border-rose-200 hover:bg-rose-200'
                    ];
                    $colorIndex = $index % count($colorVariants);
                    $currentColor = $colorVariants[$colorIndex];
                @endphp
                
                <span class="px-6 py-2 rounded-full text-md font-medium {{ $currentColor }} transition-all duration-200 hover:scale-105 shadow-sm">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>


        <!-- Tarjetas de platillos -->
        <div class="flex flex-wrap gap-12 md:w-3/3 mt-2">
            <!-- Ensalada de Salmón -->
            <div class="relative bg-green-100 p-6 rounded-2xl w-full md:w-64">
                <button class="absolute -top-6 -left-2 bg-red-300 p-3 rounded-full">
                    🤍
                </button>
                <img src="https://cdn.pixabay.com/photo/2021/06/21/15/03/salmon-6353898_1280.jpg" alt="Ensalada de Salmón" class="rounded-full w-32 h-32 mx-auto -mt-16 shadow-lg">
                <h3 class="text-xl font-bold mt-4">Salmón <span class="font-light">ensalada</span></h3>
                <p class="text-gray-600 text-sm">Ensalada de salmón a la parrilla, aguacate y tomates</p>
                <div class="mt-4 text-gray-700 text-sm space-y-1">
                    <p>🔥 228 kcal</p>
                    <p>⏳ 10 min</p>
                    <p>👥 2 personas</p>
                </div>
            </div>

            <!-- Sopa de Miso -->
            <div class="relative bg-yellow-100 p-6 rounded-2xl w-full md:w-64">
                <button class="absolute -top-6 -left-2 bg-red-300 p-3 rounded-full">
                    🤍
                </button>
                <img src="https://cdn.pixabay.com/photo/2019/02/22/23/50/goulash-4014661_1280.jpg" alt="Sopa de Miso" class="rounded-full w-32 h-32 mx-auto -mt-16 shadow-lg">
                <h3 class="text-xl font-bold mt-4">Miso <span class="font-light">sopa</span></h3>
                <p class="text-gray-600 text-sm">Receta tradicional de sopa de miso</p>
                <div class="mt-4 text-gray-700 text-sm space-y-1">
                    <p>🔥 198 kcal</p>
                    <p>⏳ 24 min</p>
                    <p>👥 2 personas</p>
                </div>
            </div>

            <!-- Ensalada de Salmón -->
            <div class="relative bg-red-100 p-6 rounded-2xl w-full md:w-64">
                <button class="absolute -top-6 -left-2 bg-red-300 p-3 rounded-full">
                    🤍
                </button>
                <img src="https://cdn.pixabay.com/photo/2021/06/21/15/03/salmon-6353898_1280.jpg" alt="Ensalada de Salmón" class="rounded-full w-32 h-32 mx-auto -mt-16 shadow-lg">
                <h3 class="text-xl font-bold mt-4">Salmón <span class="font-light">ensalada</span></h3>
                <p class="text-gray-600 text-sm">Ensalada de salmón a la parrilla, aguacate y tomates</p>
                <div class="mt-4 text-gray-700 text-sm space-y-1">
                    <p>🔥 228 kcal</p>
                    <p>⏳ 10 min</p>
                    <p>👥 2 personas</p>
                </div>
            </div>
        </div>
    </div>
</section>