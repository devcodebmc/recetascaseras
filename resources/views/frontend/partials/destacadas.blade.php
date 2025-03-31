<style>
    @media (prefers-color-scheme: dark) {
        .dark\:text-neutral-200 {
            color: inherit !important;
        }
    }
</style>
<section class="bg-[#F5F3EF] p-10">
    <!-- Contenido Principal -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="text-3xl font-bold mb-4 md:mb-0">Recetas</h2>
        <div class="flex items-center bg-white rounded-full shadow-md p-2 w-full md:w-1/3 mb-4 md:mb-0 font-secondary">
            <svg class="w-6 h-6 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" placeholder="Busca recetas maravillosas..." class="flex-grow px-4 py-2 text-gray-700 focus:outline-none">
            <button class="bg-red-400 text-white px-4 py-2 rounded-full ml-2">Buscar</button>
        </div>
        <div class="bg-white px-4 py-2 rounded-full shadow-md flex items-center border border-gray-300 font-secondary">
            <label for="sort" class="mr-2 font-medium text-gray-700">Ordenar por:</label>
            <div class="relative inline-block">
                <select id="sort" class="bg-white text-gray-800 font-medium px-6 rounded-full appearance-none cursor-pointer">
                    <option value="newest">Nuevo</option>
                    <option value="oldest">Antiguo</option>
                    <option value="popular">Popular</option>
                </select>
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 pointer-events-none">▼</span>
            </div>
        </div>                
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Filters -->
        <div class="col-span-1 bg-white p-4 rounded-lg shadow-md">
            <ul class="space-y-4">
                @foreach ($categories as $category)
                <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                        <img src="{{ asset($category->icon_url) }}" alt="{{ $category->name }}" class="w-6 h-6">
                    </div>
                    <span class="ml-3 font-medium">{{ $category->name }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- Main Content -->
        <div class="col-span-1 md:col-span-2 grid grid-cols-1 gap-6">
            <!-- Large Recipe Card -->
            @foreach ($recipes as $recipe)
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row">
                <img src="{{ asset($recipe->image) }}" alt="Ensalada Cítrica" class="w-full md:w-32 h-32 rounded-lg">
                <div class="ml-0 md:ml-4 mt-4 md:mt-0">
                    <h3 class="text-xl font-bold">{{ $recipe->title }}</h3>
                        {!! $recipe->description !!}
                    <div class="flex mt-2 text-sm font-secondary">
                        <span class="mr-4">👥 {{ $recipe->servings }}</span>
                        <span>⏳ Tiempo de preparación 
                            <strong>
                                @if ($recipe->cook_time > 60)
                                    {{ intdiv($recipe->cook_time, 60) }}h {{ $recipe->cook_time % 60 }}m
                                @else
                                    {{ $recipe->cook_time }}m
                                @endif
                            </strong>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-span-1 grid grid-cols-1 gap-6">
            <!-- Smaller Recipe Cards -->
            <div class="bg-yellow-100 text-black rounded-lg shadow-md p-4 flex my-flex items-center">
                <img src="https://editorialtelevisa.brightspotcdn.com/dims4/default/24f387f/2147483647/strip/true/crop/560x560+220+0/resize/1000x1000!/quality/90/?url=https%3A%2F%2Fk2-prod-editorial-televisa.s3.us-east-1.amazonaws.com%2Fbrightspot%2Fwp-content%2Fuploads%2F2019%2F10%2Fcomo-hacer-arroz-rojo.jpg" alt="Ensalada de Aguacate" class="w-16 h-16 rounded-full">
                <div class="ml-4">
                    <h3 class="text-lg font-bold">Arroz Rojo</h3>
                    <div class="flex mt-1 text-sm font-secondary">
                        <span class="mr-4">👥 Porciones</span>
                        <span>⏳ Tiempo de preparación <strong>1h 30m</strong></span>
                    </div>
                </div>
            </div>
        
            <div class="bg-white rounded-lg shadow-md p-4 flex my-flex items-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwJnEVS1z0vHai2XktgcR2dBzRJuEx2TiCsA&s" alt="Pasta con Pollo Verde" class="w-16 h-16 rounded-full">
                <div class="ml-4">
                    <h3 class="text-lg font-bold">Tinga de Pollo</h3>
                    <div class="flex mt-1 text-sm font-secondary">
                        <span class="mr-4">👥 Porciones</span>
                        <span>⏳ Tiempo de preparación <strong>1h 50m</strong></span>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-100 text-black rounded-lg shadow-md p-4 flex my-flex items-center">
                <img src="https://editorialtelevisa.brightspotcdn.com/dims4/default/24f387f/2147483647/strip/true/crop/560x560+220+0/resize/1000x1000!/quality/90/?url=https%3A%2F%2Fk2-prod-editorial-televisa.s3.us-east-1.amazonaws.com%2Fbrightspot%2Fwp-content%2Fuploads%2F2019%2F10%2Fcomo-hacer-arroz-rojo.jpg" alt="Ensalada de Aguacate" class="w-16 h-16 rounded-full">
                <div class="ml-4">
                    <h3 class="text-lg font-bold">Arroz Rojo</h3>
                    <div class="flex mt-1 text-sm font-secondary">
                        <span class="mr-4">👥 Porciones</span>
                        <span>⏳ Tiempo de preparación <strong>1h 30m</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

