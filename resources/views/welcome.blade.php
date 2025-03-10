<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recetas Caseras</title>
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#F5F3EF] font-sans">
        <!-- Header -->
        <section class="bg-yellow-300 p-6 md:p-10 relative rounded-b-3xl">
            <!-- Navbar -->
            <nav class="flex justify-between items-center">
                <div class="text-black font-bold text-xl">
                    <a href="/index.html">Recetas Caseras</a>
                </div>
                <ul class="hidden md:flex space-x-6 text-black font-medium">
                    <li><a href="#">Tienda</a></li>
                    <li><a href="#">Novedades</a></li>
                    <li class="font-bold text-black">Recetas</li>
                </ul>
                <div class="space-x-4 hidden md:flex items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-black">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-black">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white px-4 py-2 rounded-full text-black">Sign Up</a>
                            @endif
                        @endauth
                    @endif
                </div>
                <button class="md:hidden text-black" id="menu-button">
                    <svg class="w-6 h-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </nav>
            <div class="hidden md:hidden" id="mobile-menu">
                <ul class="space-y-4 mt-4 text-black font-medium">
                    <li><a href="#">Tienda</a></li>
                    <li><a href="#">Novedades</a></li>
                    <li class="font-bold text-black">Recetas</li>
                    @if (Route::has('login'))
                        @auth
                            <li><a href="{{ url('/dashboard') }}" class="text-black">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-black">Login</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="bg-white px-4 py-2 rounded-full text-black">Sign Up</a></li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        
            <!-- Main Content -->
            <div class="grid md:grid-cols-2 items-center gap-4">
                <div class="space-y-1 px-6 md:px-0 text-center md:text-left">
                    <h1 class="text-5xl md:text-7xl lg:text-9xl font-bold text-black leading-tight">
                        El <span class="text-yellow-600">Sabor</span> 
                        del <span class="text-yellow-600">Amor</span>
                    </h1>
                    <p class="mt-4 italic text-lg md:text-xl lg:text-lg text-gray-800 leading-relaxed">
                        ¡Descubre recetas únicas y deliciosas que te harán sentir como en casa!
                    </p>
                </div>
                <div class="flex justify-center">
                    <img src="/images/hero-Photoroom.png" alt="Chef Illustration" 
                        class="w-full max-w-sm">
                </div>
            </div>
        
            <!-- Play Button -->
            <div class="absolute bottom-10 right-10">
                <button class="bg-red-400 p-4 rounded-full shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6 ">
                        <path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd" />
                    </svg>                                                 
                </button>
            </div>
        </section>
    
        <!-- Destacadas -->
        <section class="bg-[#F5F3EF] p-10">
            <!-- Header -->
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
                        <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <img src="/images/guisos.png" alt="Guisos" class="w-6 h-6">
                            </div>
                            <span class="ml-3 font-medium">Guisos</span>
                        </li>
                        <li class="flex items-center p-3 rounded-full bg-yellow-200 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <img src="/images/tacos.png" alt="Tacos" class="w-6 h-6">
                            </div>
                            <span class="ml-3 font-medium">Tacos</span>
                        </li>
                        <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <img src="/images/sopas.png" alt="Sopas" class="w-6 h-6">
                            </div>
                            <span class="ml-3 font-medium">Sopas</span>
                        </li>
                        <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <img src="/images/moles.png" alt="Moles" class="w-6 h-6">
                            </div>
                            <span class="ml-3 font-medium">Moles</span>
                        </li>
                        <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <img src="/images/caldos.png" alt="Caldos" class="w-6 h-6">
                            </div>
                            <span class="ml-3 font-medium">Caldos</span>
                        </li>
                        <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <img src="/images/garnachas.png" alt="Garnachas" class="w-6 h-6">
                            </div>
                            <span class="ml-3 font-medium">Garnachas</span>
                        </li>
                        <li class="flex items-center p-3 rounded-full bg-gray-200 cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                                <img src="/images/tamales.png" alt="Tamales" class="w-6 h-6">
                            </div>
                            <span class="ml-3 font-medium">Tamales</span>
                        </li>
                    </ul>
                </div>
                <!-- Main Content -->
                <div class="col-span-1 md:col-span-2 grid grid-cols-1 gap-6">
                    <!-- Large Recipe Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row">
                        <img src="https://cdn.pixabay.com/photo/2021/01/20/04/22/fajitas-5933057_1280.jpg" alt="Ensalada Cítrica" class="w-full md:w-32 h-32 rounded-lg">
                        <div class="ml-0 md:ml-4 mt-4 md:mt-0">
                            <h3 class="text-xl font-bold">Bistec a la Mexicana</h3>
                            <p class="text-gray-600 text-sm">
                                Para tu menú de la semana, agrega este BISTEC a la MEXICANA. El chile serrano y la cebolla no pueden faltan en esta receta.
                            </p>
                            <div class="flex mt-2 text-sm font-secondary">
                                <span class="mr-4">👥 Porciones</span>
                                <span>⏳ Tiempo de preparación <strong>1h 15m</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row">
                        <img src="https://cdn.pixabay.com/photo/2021/01/20/04/22/fajitas-5933057_1280.jpg" alt="Ensalada Cítrica" class="w-full md:w-32 h-32 rounded-lg">
                        <div class="ml-0 md:ml-4 mt-4 md:mt-0">
                            <h3 class="text-xl font-bold">Bistec a la Mexicana</h3>
                            <p class="text-gray-600 text-sm">
                                Para tu menú de la semana, agrega este BISTEC a la MEXICANA. El chile serrano y la cebolla no pueden faltan en esta receta.
                            </p>
                            <div class="flex mt-2 text-sm font-secondary">
                                <span class="mr-4">👥 Porciones</span>
                                <span>⏳ Tiempo de preparación <strong>1h 15m</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row">
                        <img src="https://cdn.pixabay.com/photo/2021/01/20/04/22/fajitas-5933057_1280.jpg" alt="Ensalada Cítrica" class="w-full md:w-32 h-32 rounded-lg">
                        <div class="ml-0 md:ml-4 mt-4 md:mt-0">
                            <h3 class="text-xl font-bold">Bistec a la Mexicana</h3>
                            <p class="text-gray-600 text-sm">
                                Para tu menú de la semana, agrega este BISTEC a la MEXICANA. El chile serrano y la cebolla no pueden faltan en esta receta.
                            </p>
                            <div class="flex mt-2 text-sm font-secondary">
                                <span class="mr-4">👥 Porciones</span>
                                <span>⏳ Tiempo de preparación <strong>1h 15m</strong></span>
                            </div>
                        </div>
                    </div>
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
    
        <!-- Historias -->
        <section class="bg-white py-8">
            <div class="max-w-7xl mx-auto px-8">
                <h2 class="text-3xl font-bold mb-6">Historias</h2>
                <div class="flex space-x-4 overflow-x-auto font-secondary">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2022/10/19/01/02/woman-7531315_1280.png" alt="layla" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">layla</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2021/11/11/22/15/rainbow-6787377_1280.png" alt="eva" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">eva</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2021/11/03/16/49/woman-6766322_1280.png" alt="michael" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">michael</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2021/10/22/16/45/woman-6733100_1280.png" alt="nazli" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">nazli</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2021/07/21/21/50/woman-6484037_1280.png" alt="lucy" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">lucy</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2021/10/11/22/08/halloween-6701942_1280.png" alt="tom" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">tom</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2022/10/27/21/57/turkey-7551884_640.png" alt="tiffany" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">tiffany</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2021/11/04/18/16/woman-6768995_1280.png" alt="rifat" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">rifat</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-4 border-yellow-300 p-1">
                            <img src="https://cdn.pixabay.com/photo/2021/10/22/22/00/sun-6733653_640.png" alt="aysegul" class="rounded-full">
                        </div>
                        <span class="mt-2 text-sm">aysegul</span>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Sección Descubre -->
        <section class="py-2 pb-8 px-10 bg-white">
            <h2 class="text-3xl font-bold mb-6">Descubre</h2>
    
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
                    <span class="px-6 py-2 bg-yellow-200 rounded-full">Hamburguesa</span>
                    <span class="px-6 py-2 bg-gray-200  rounded-full">Sopa</span>
                    <span class="px-6 py-2 bg-yellow-200 rounded-full">Pescado</span>
                    <span class="px-6 py-2 bg-gray-200  rounded-full">Vegetales</span>
                    <span class="px-6 py-2 bg-gray-200  rounded-full">Ensalada</span>
                    <span class="px-6 py-2 bg-gray-200  rounded-full">Frutas</span>
                    <span class="px-6 py-2 bg-yellow-200 rounded-full">Saludable</span>
                    <span class="px-6 py-2 bg-gray-200  rounded-full">Verano</span>
                    <span class="px-6 py-2 bg-gray-200  rounded-full">Menos Gluten</span>
                    <span class="px-6 py-2 bg-yellow-200 rounded-full">Vegetariano</span>
                    <span class="px-6 py-2 bg-gray-200  rounded-full">Carne</span>
                    <span class="px-6 py-2 bg-yellow-200 rounded-full">Rápido</span>
                </div>
    
                <!-- Tarjetas de platillos -->
                <div class="flex flex-wrap gap-12 md:w-3/4 mt-2">
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
          
        <!--Sección Características -->
        <section class="py-16 bg-[#F5F3EF]">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-gray-900">Nuestras Características</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Cocinar puede ser una experiencia divertida que estimula la creatividad y mejora las habilidades.
                </p>
                
                <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition duration-500 hover:scale-105">
                        <div class="bg-red-400 p-4 rounded-full inline-block">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Variedad de Menús</h3>
                        <p class="text-gray-600 mt-4">Explora menús de todo el mundo y disfruta diferentes estilos culinarios.</p>
                    </div>
    
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition duration-500 hover:scale-105">
                        <div class="bg-yellow-200 p-4 rounded-full inline-block">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Utensilios de Cocina</h3>
                        <p class="text-gray-600 mt-4">Desde herramientas básicas hasta equipos avanzados para cocinar.</p>
                    </div>
    
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition duration-500 hover:scale-105">
                        <div class="bg-red-400 p-4 rounded-full inline-block">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Chefs Expertos</h3>
                        <p class="text-gray-600 mt-4">Aprende de los mejores chefs y mejora tus habilidades culinarias.</p>
                    </div>
    
                    <div class="bg-white p-8 rounded-2xl shadow-lg transform transition duration-500 hover:scale-105">
                        <div class="bg-yellow-200 p-4 rounded-full inline-block">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Diversión Garantizada</h3>
                        <p class="text-gray-600 mt-4">Disfruta cocinando y compartiendo momentos únicos en la cocina.</p>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Suscríbete -->
        <section class="bg-white py-16 px-6 md:px-12 lg:px-24 flex flex-col items-center text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
            Mantente al día con nuestras últimas recetas
            </h2>
            <p class="text-gray-600 mt-3 text-lg">
            ¡Suscríbete a nuestro boletín y no te pierdas ninguna deliciosa actualización!
            </p>
            <div class="mt-6 flex flex-col sm:flex-row gap-4 w-full max-w-lg">
            <input
                type="email"
                placeholder="Ingresa tu correo electrónico"
                class="w-full px-4 py-3 text-gray-700 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-300"
            />
            <button class="bg-yellow-200 hover:bg-yellow-300 text-white px-6 py-3 rounded-full text-lg font-semibold transition">
                Suscribirse
            </button>
            </div>
            <div class="mt-6 text-sm text-gray-500">
            <p>Respetamos tu privacidad. Puedes darte de baja en cualquier momento.</p>
            </div>
        </section>
    
        <!-- Galería -->
        <section class="bg-[#F5F3EF] py-16 px-4 md:px-12 lg:px-20">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-8">
              Galería del Sazón
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <img
                src="https://images.pexels.com/photos/2087748/pexels-photo-2087748.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                alt="Delicious Wrap"
                class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
              />
              <img
                src="https://images.pexels.com/photos/2092897/pexels-photo-2092897.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                alt="Rice and Broccoli Dish"
                class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
              />
              <img
                src="https://images.pexels.com/photos/2763076/pexels-photo-2763076.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                alt="Healthy Bowl"
                class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
              />
              <img
                src="https://images.pexels.com/photos/1640772/pexels-photo-1640772.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                alt="Friends Enjoying Food"
                class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
              />
              <img
                src="https://images.pexels.com/photos/5737249/pexels-photo-5737249.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                alt="Cooking Together"
                class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
              />
              <img
                src="https://images.pexels.com/photos/5737254/pexels-photo-5737254.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                alt="Gourmet Pasta Dish"
                class="w-full h-64 object-cover rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-xl"
              />
            </div>
        </section>
          
        <!-- Mejores Cocineras de la Semana -->
        <section class="bg-gradient-to-r from-yellow-100 to-yellow-300 py-16 px-6 md:px-12 lg:px-24 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Conozcamos a Nuestras Cocineras de la Semana
            </h2>
            <p class="text-gray-600 mb-8">
              Ellas destacan por su pasión, talento y experiencia en la cocina, creando platos inolvidables para nuestros paladares.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-6">
              <!-- Cocinera 1 -->
              <div class="relative bg-white rounded-3xl p-6 text-center shadow-lg w-full md:w-1/3 transform transition duration-500 hover:scale-105">
                <div class="absolute inset-0 bg-gray-400 opacity-20 rounded-3xl transform rotate-6"></div>
                <img src="https://images.pexels.com/photos/16837809/pexels-photo-16837809/free-photo-of-gente-mujer-sonriente-sonriendo.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Cocinera 1" class="relative w-40 h-40 mx-auto rounded-full object-cover border-4 border-yellow-200">
                <h3 class="relative text-xl font-bold text-gray-900 mt-4">María López</h3>
                <p class="relative text-gray-600">Experta en Cocina Mexicana</p>
              </div>
          
              <!-- Cocinera 2 -->
              <div class="relative bg-white rounded-3xl p-6 text-center shadow-lg w-full md:w-1/3 transform transition duration-500 hover:scale-105">
                <div class="absolute inset-0 bg-gray-400 opacity-20 rounded-3xl transform rotate-6"></div>
                <img src="https://images.pexels.com/photos/24889551/pexels-photo-24889551/free-photo-of-mujer-mayor-cocinando-pan-plano-en-una-estufa-grande-con-las-manos.jpeg?auto=compress&cs=tinysrgb&w=800&lazy=load" alt="Cocinera 2" class="relative w-40 h-40 mx-auto rounded-full object-cover border-4 border-yellow-200">
                <h3 class="relative text-xl font-bold text-gray-900 mt-4">Ana Rodríguez</h3>
                <p class="relative text-gray-600">Repostera</p>
              </div>
          
              <!-- Cocinera 3 -->
              <div class="relative bg-white rounded-3xl p-6 text-center shadow-lg w-full md:w-1/3 transform transition duration-500 hover:scale-105">
                <div class="absolute inset-0 bg-gray-400 opacity-20 rounded-3xl transform rotate-6"></div>
                <img src="https://images.pexels.com/photos/16625019/pexels-photo-16625019/free-photo-of-restaurante-mujer-viaje-viajar.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Cocinera 3" class="relative w-40 h-40 mx-auto rounded-full object-cover border-4 border-yellow-200">
                <h3 class="relative text-xl font-bold text-gray-900 mt-4">Sofía Martínez</h3>
                <p class="relative text-gray-600">Chef de Alta Cocina</p>
              </div>
            </div>
        </section>
          
    
        <!-- Footer -->
        <footer class="bg-white text-gray-800 py-10">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About Us -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Sobre Nosotros</h3>
                    <p class="text-gray-400">
                        Recetas Caseras es tu fuente de inspiración para cocinar platos deliciosos y saludables en casa. Únete a nuestra comunidad y descubre nuevas recetas cada semana.
                    </p>
                </div>
                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-gray-500">Inicio</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gray-500">Recetas</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gray-500">Tienda</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gray-500">Contacto</a></li>
                    </ul>
                </div>
                <!-- Newsletter -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Suscríbete a Nuestro Boletín</h3>
                    <p class="text-gray-400 mb-4">
                        Recibe las últimas recetas y noticias directamente en tu bandeja de entrada.
                    </p>
                    <form class="flex flex-col sm:flex-row gap-4">
                        <input type="email" placeholder="Tu correo electrónico" class="w-full px-4 py-2 text-gray-700 border border-red-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-400">
                        <button class="bg-red-400 hover:bg-red-500 text-white px-6 py-2 rounded-full text-lg font-semibold transition">Suscribirse</button>
                    </form>
                </div>
            </div>
            <div class="mt-10 border-t border-gray-700 pt-6 text-center text-gray-400">
                <p>&copy; 2025 Recetas Caseras. Todos los derechos reservados.</p>
                <div class="mt-4 space-x-4">
                    <a href="#" class="hover:text-gray-500">Facebook</a>
                    <a href="#" class="hover:text-gray-500">Twitter</a>
                    <a href="#" class="hover:text-gray-500">Instagram</a>
                </div>
            </div>
        </footer>
    
        <script src="js/index.js" defer></script>
    </body>    
</html>
