@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/adopciones/index.css') }}">
@endsection

@section('content')
<div class="container fade-in">
    <div class="row">
        <div class="col-12">
            <!-- HEADER -->
            <div class="adopciones-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="adopciones-title">
                        <i class="fas fa-paw me-2"></i>Gestión de Adopciones
                    </h1>
                    <a href="{{ route('adopciones.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nueva Adopción
                    </a>
                </div>
            </div>

            <!-- FORMULARIO DE FILTROS -->
            <div class="card filtros-card">
                <div class="card-header filtros-header">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i> Filtros de Búsqueda
                    </h5>
                </div>
                <div class="card-body filtros-body">
                    <form action="{{ route('adopciones.index') }}" method="GET">
                        <div class="row g-3">
                            <!-- Búsqueda por lugar -->
                            <div class="col-md-3">
                                <label for="busqueda" class="form-label">Buscar por lugar:</label>
                                <input type="text" class="form-control" id="busqueda" name="busqueda" 
                                       value="{{ request('busqueda') }}" placeholder="Ej: Bogotá, Medellín...">
                            </div>

                            <!-- Filtro por estado -->
                            <div class="col-md-2">
                                <label for="estado" class="form-label">Estado:</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="">Todos los estados</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado }}" 
                                            {{ request('estado') == $estado ? 'selected' : '' }}>
                                            {{ $estado }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro por mascota -->
                            <div class="col-md-3">
                                <label for="mascota_id" class="form-label">Mascota:</label>
                                <select class="form-select" id="mascota_id" name="mascota_id">
                                    <option value="">Todas las mascotas</option>
                                    @foreach($mascotas as $mascota)
                                        <option value="{{ $mascota->id }}" 
                                            {{ request('mascota_id') == $mascota->id ? 'selected' : '' }}>
                                            {{ $mascota->Nombre_mascota }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro por usuario -->
                            <div class="col-md-2">
                                <label for="usuario_id" class="form-label">Adoptante:</label>
                                <select class="form-select" id="usuario_id" name="usuario_id">
                                    <option value="">Todos los adoptantes</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" 
                                            {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->Nombre_1 }} {{ $usuario->Apellido_1 }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filtro por fecha desde -->
                            <div class="col-md-2">
                                <label for="fecha_desde" class="form-label">Desde:</label>
                                <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" 
                                       value="{{ request('fecha_desde') }}">
                            </div>

                            <!-- Filtro por fecha hasta -->
                            <div class="col-md-2">
                                <label for="fecha_hasta" class="form-label">Hasta:</label>
                                <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" 
                                       value="{{ request('fecha_hasta') }}">
                            </div>

                            <!-- Botones -->
                            <div class="col-md-12">
                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i> Aplicar Filtros
                                    </button>
                                    <a href="{{ route('adopciones.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-times me-2"></i> Limpiar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ALERTAS -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- CONTADOR Y FILTROS ACTIVOS -->
            <div class="contador-resultados">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">
                        Mostrando <strong class="text-fucsia">{{ $adopciones->count() }}</strong> de 
                        <strong class="text-turquesa">{{ $adopciones->total() }}</strong> adopciones
                    </p>
                    
                    @if(request()->anyFilled(['estado', 'mascota_id', 'usuario_id', 'busqueda', 'fecha_desde', 'fecha_hasta']))
                    <div class="alert alert-info py-2 mb-0">
                        <small>
                            <i class="fas fa-info-circle me-1"></i> 
                            Filtros aplicados. 
                            <a href="{{ route('adopciones.index') }}" class="alert-link">Ver todas</a>
                        </small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- TABLA DE ADOPCIONES -->
            <div class="card shadow-sm tabla-adopciones">
                <div class="card-body p-0">
                    @if($adopciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th width="80">ID</th>
                                        <th>Mascota</th>
                                        <th>Adoptante</th>
                                        <th width="120">Fecha Adopción</th>
                                        <th>Lugar</th>
                                        <th width="120">Estado</th>
                                        <th width="150" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($adopciones as $adopcion)
                                    <tr>
                                        <td class="fw-bold text-turquesa">#{{ $adopcion->id }}</td>
                                        <td>
                                            @if($adopcion->mascota)
                                                <i class="fas fa-paw me-2 text-fucsia"></i>
                                                {{ $adopcion->mascota->Nombre_mascota }}
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-question-circle me-2"></i>Mascota no encontrada
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($adopcion->usuario)
                                                <i class="fas fa-user me-2 text-turquesa"></i>
                                                {{ $adopcion->usuario->Nombre_1 }} {{ $adopcion->usuario->Apellido_1 }}
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-question-circle me-2"></i>Usuario no encontrado
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                            {{ $adopcion->Fecha_adopcion->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                            {{ $adopcion->Lugar_adopcion }}
                                        </td>
                                        <td>
                                            <span class="badge badge-estado 
                                                @if($adopcion->estado == 'Aprobado') bg-success
                                                @elseif($adopcion->estado == 'En proceso') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $adopcion->estado }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm btn-group-acciones">
                                                <a href="{{ route('adopciones.show', $adopcion->id) }}" 
                                                   class="btn btn-outline-info" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('adopciones.edit', $adopcion->id) }}" 
                                                   class="btn btn-outline-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('adopciones.destroy', $adopcion->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            title="Eliminar"
                                                            onclick="return confirm('¿Estás seguro de eliminar esta adopción?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINACIÓN -->
                        <div class="d-flex justify-content-between align-items-center p-3 border-top">
                            <div>
                                {{ $adopciones->links() }}
                            </div>
                            <small class="text-muted">
                                Página {{ $adopciones->currentPage() }} de {{ $adopciones->lastPage() }}
                            </small>
                        </div>
                    @else
                        <!-- ESTADO VACÍO -->
                        <div class="estado-vacio">
                            <i class="fas fa-paw fa-4x"></i>
                            <h4>No se encontraron adopciones</h4>
                            <p class="text-muted mb-4">
                                @if(request()->anyFilled(['estado', 'mascota_id', 'usuario_id', 'busqueda', 'fecha_desde', 'fecha_hasta']))
                                    Intenta con otros criterios de búsqueda o limpia los filtros.
                                @else
                                    Comienza registrando una nueva adopción en el sistema.
                                @endif
                            </p>
                            <a href="{{ route('adopciones.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i> Crear Primera Adopción
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection