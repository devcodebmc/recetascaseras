@extends('frontend.layouts.main')

@section('content')
<!-- Destacadas -->
@include('frontend.partials.destacadas')
<!-- Historias -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-6 tracking-widest">Historias</h2>
        @include('frontend.partials.historias')
    </div>
</section>
<!-- Top Categories -->
<section class="py-12 bg-white">
    @include('frontend.components.topCategories')
</section>
<!-- Sección Descubre -->
@include('frontend.partials.descubre')
<!--Sección Características -->
@include('frontend.partials.caracteristicas')
<!-- Suscríbete -->
@include('frontend.partials.suscribete')
<!-- Galería -->
@include('frontend.partials.galeria')
<!-- Counters Section -->
<section class="bg-white mb-12">
    @include('frontend.components.counters')
</section>
<!-- Mejores Cocineras de la Semana -->
@include('frontend.partials.cocineras')
<!-- Invitación a recetas -->
@include('frontend.partials.invitacionRecetas')
    
@endsection
