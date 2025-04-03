<nav class="flex justify-between items-center">
    <div class="text-black font-bold text-xl">
        <a href="{{ route('welcome') }}">Recetas Caseras</a>
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
                <a href="{{ route('login') }}" target="_blank" rel="noopener noreferrer" class="text-black">Iniciar Sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" target="_blank" rel="noopener noreferrer" class="bg-white px-4 py-2 rounded-full text-black">Registrarse</a>
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
                <li>
                    <a href="{{ url('/dashboard') }}" class="text-black">Panel Recetas</a>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}" target="_blank" rel="noopener noreferrer" class="text-black">Iniciar Sesión</a>
                </li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" target="_blank" rel="noopener noreferrer" class="bg-white px-4 py-2 rounded-full text-black">Registrarse</a></li>
                @endif
            @endauth
        @endif
    </ul>
</div>
