<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @media only screen and (max-width: 599px) {
                .my-overflow {
                    overflow-x: scroll !important;
                }
            }
            /* Transición suave para los iconos */
            svg {
                transition: all 0.2s ease;
            }

            /* Efecto de escala al hacer hover */
            button:hover svg {
                transform: scale(1.1);
            }

            /* Color diferente para el estado activo */
            button:active svg {
                transform: scale(0.95);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
            // Función para alternar la visibilidad del dropdown
            function toggleDropdown(dropdownId, event) {
                event.stopPropagation(); // Evita que el clic se propague y cierre el dropdown inmediatamente
                const dropdown = document.getElementById(dropdownId);
                const allDropdowns = document.querySelectorAll('.dropdown-content');
    
                // Cerrar todos los dropdowns excepto el actual
                allDropdowns.forEach(function(d) {
                    if (d.id !== dropdownId) {
                        d.classList.add('hidden');
                    }
                });
    
                // Alternar la visibilidad del dropdown actual
                dropdown.classList.toggle('hidden');
            }
            // Cerrar el dropdown al hacer clic fuera de él
            document.addEventListener('click', function(event) {
                const dropdowns = document.querySelectorAll('.dropdown-content');
                const isClickInsideDropdown = Array.from(dropdowns).some(dropdown => dropdown.contains(event.target));
                const isClickOnButton = event.target.matches('.dropdown-button') || event.target.closest('.dropdown-button');
    
                if (!isClickInsideDropdown && !isClickOnButton) {
                    dropdowns.forEach(function(dropdown) {
                        dropdown.classList.add('hidden');
                    });
                }
            });
            
           // Ocultar vista de cuadrícula al cargar la página
            document.getElementById('grid-view-container').classList.add('hidden');

            // Función para alternar vistas y estilos
            function toggleView(activeButton, inactiveButton, activeContainer, inactiveContainer) {
                document.getElementById(activeContainer).classList.remove('hidden');
                document.getElementById(inactiveContainer).classList.add('hidden');
                document.getElementById(activeButton).classList.add('bg-indigo-200');
                document.getElementById(inactiveButton).classList.remove('bg-indigo-200');
            }

            // Agregar eventos a los botones
            document.getElementById('list-view').addEventListener('click', function() {
                toggleView('list-view', 'grid-view', 'list-view-container', 'grid-view-container');
            });

            document.getElementById('grid-view').addEventListener('click', function() {
                toggleView('grid-view', 'list-view', 'grid-view-container', 'list-view-container');
            });
        </script>
    </body>
</html>
