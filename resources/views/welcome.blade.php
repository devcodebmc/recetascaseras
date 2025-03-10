@extends('frontend.layouts.main')

@section('content')
<!-- Destacadas -->
@include('frontend.partials.destacadas')
<!-- Historias -->
@include('frontend.partials.historias')
<!-- Sección Descubre -->
@include('frontend.partials.descubre')
<!--Sección Características -->
@include('frontend.partials.caracteristicas')
<!-- Suscríbete -->
@include('frontend.partials.suscribete')
<!-- Galería -->
@include('frontend.partials.galeria')
<!-- Mejores Cocineras de la Semana -->
@include('frontend.partials.cocineras')
    
@endsection