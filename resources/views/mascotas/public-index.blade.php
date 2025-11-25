@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/mascotas/public-index.css') }}?v=2.0">
@endsection

@section('content')
<div class="container py-4">
    <!-- HERO MODERNO -->
    <div class="hero-mascotas text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1> Encuentra a tu Compañero Ideal cris</h1>
                <p class="lead">Descubre mascotas increíbles esperando por un hogar lleno de amor</p>
            </div>
        </div>
    </div>

    <!-- FILTROS MODERNOS -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="filtros-modernos">
                <form action="{{ route('mascotas.public.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label text-turquesa fw-bold">Especie</label>
                        <select name="especie" class="form-select">
                            <option value="">Todas las especies</option>
                            @foreach($especies as $especie)
                                <option value="{{ $especie }}" {{ request('especie') == $especie ? 'selected' : '' }}>
                                    {{ $especie }}s
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-turquesa fw-bold">Género</label>
                        <select name="genero" class="form-select">
                            <option value="">Todos los géneros</option>
                            <option value="Macho" {{ request('genero') == 'Macho' ? 'selected' : '' }}>Machos</option>
                            <option value="Hembra" {{ request('genero') == 'Hembra' ? 'selected' : '' }}>Hembras</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn-buscar-moderno">
                            <i class="fas fa-search me-2"></i> Buscar Mascotas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CONTADOR MODERNO -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="contador-mascotas">
                <i class="fas fa-paw me-2"></i>
                <strong>{{ $mascotas->total() }}</strong> amigos peludos esperando por ti
            </div>
        </div>
    </div>

    <!-- GRID DE MASCOTAS MODERNO -->
    <div class="row">
        @forelse($mascotas as $mascota)
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card-mascota-moderna">
                <!-- Imagen con overlay -->
                <div class="card-imagen-container">
                    @if($mascota->Foto)
                    <img src="{{ asset('storage/' . $mascota->Foto) }}" 
                         alt="{{ $mascota->Nombre_mascota }}">
                    @else
                    <div class="w-100 h-100 bg-gris-claro d-flex align-items-center justify-content-center">
                        <i class="fas fa-paw fa-4x text-turquesa opacity-50"></i>
                    </div>
                    @endif
                    <div class="overlay-mascota"></div>
                    
                    <!-- Badges flotantes -->
                    <div class="badges-container">
                        <span class="badge-moderno badge-especie-moderno">
                            {{ $mascota->Especie }}
                        </span>
                        <span class="badge-moderno badge-genero-moderno">
                            {{ $mascota->Genero }}
                        </span>
                        <span class="badge-moderno badge-edad-moderno">
                            {{ $mascota->Edad_aprox }} años
                        </span>
                    </div>
                </div>
                
                <!-- Contenido -->
                <div class="card-body-moderno">
                    <h3 class="nombre-mascota">{{ $mascota->Nombre_mascota }}</h3>
                    
                    <p class="descripcion-mascota">
                        {{ Str::limit($mascota->Descripcion, 150) }}
                    </p>
                    
                    <!-- Información de fundación -->
                    @if($mascota->fundacion)
                    <div class="info-fundacion">
                        <i class="fas fa-home"></i>
                        <span>Rescatado por: {{ $mascota->fundacion->Nombre_1 }}</span>
                    </div>
                    @endif
                    
                    <!-- Botón -->
                    <a href="{{ route('mascotas.public.show', $mascota->id) }}" 
                       class="btn-conocer-mas">
                       <i class="fas fa-heart me-2"></i>Conocer a {{ $mascota->Nombre_mascota }}
                    </a>
                </div>
            </div>
        </div>
        @empty
        <!-- ESTADO VACÍO -->
        <div class="col-12">
            <div class="estado-vacio">
                <i class="fas fa-search fa-4x mb-3"></i>
                <h4>No encontramos mascotas</h4>
                <p class="text-muted mb-4">Intenta ajustar los filtros de búsqueda</p>
                <a href="{{ route('mascotas.public.index') }}" class="btn-conocer-mas" style="width: auto; display: inline-block;">
                    <i class="fas fa-redo me-2"></i>Ver Todas las Mascotas
                </a>
            </div>
        </div>
        @endforelse
    </div>


    <!-- PAGINACIÓN MODERNA -->
    @if($mascotas->hasPages())
    <div class="row mt-5">
        <div class="col-12 paginacion-moderna">
            {{ $mascotas->links() }}
        </div>
    </div>
    @endif
</div>
@endsection