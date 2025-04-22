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
            @include('frontend.components.navbar')
            <!-- Main Content -->
            <div class="grid md:grid-cols-2 items-center gap-4">
                <div class="space-y-1 px-6 md:px-0 text-center md:text-left">
                    <h1 class="text-4xl md:text-7xl lg:text-9xl font-bold text-black leading-tight" loading="lazy">
                        El <span class="text-yellow-600">Sabor</span> 
                        del <span class="text-yellow-600">Amor</span>
                    </h1>
                    <p class="mt-4 italic text-lg md:text-xl lg:text-lg text-gray-800 leading-relaxed">
                        ¡Descubre recetas únicas y deliciosas que te harán sentir como en casa!
                    </p>
                </div>
                <div class="flex justify-center">
                    <img src="{{ asset('images/hero-Photoroom.png') }}" alt="Chef Illustration" 
                        class="w-full max-w-sm" loading="lazy">
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

        @yield('content')
    
        <!-- Footer -->
        @include('frontend.components.footer')
    
        <script defer type="text/javascript">
            document.getElementById('menu-button').addEventListener('click', function() {
                var menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });
        </script>
        @stack('js')
    </body>    
</html>
