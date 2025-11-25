<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescatando Mascotas Forever</title>
    
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    {{-- Estilos globales --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    {{-- Componentes --}}
    <link rel="stylesheet" href="{{ asset('css/components/navbar.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}"> 
    
    {{-- Estilos específicos de cada página --}}
    @yield('styles')
</head>

<body>
    {{-- Navbar --}}
    @include('includes.navbar')

    {{-- Contenido principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('includes.footer')
    
    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Scripts específicos de cada página --}}
    @yield('scripts')

    {{-- Modal de éxito (SIN DUPLICADOS) --}}
    @if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success')['title'] ?? '¡Éxito!' }}
                    </h5>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-heart text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="text-success mb-3">¡Gracias por tu solicitud!</h4>
                    <p class="mb-4">{{ session('success')['message'] ?? 'Tu solicitud ha sido procesada correctamente.' }}</p>
                    
                    @if(isset(session('success')['mascota_nombre']))
                    <div class="alert alert-info">
                        <strong>Mascota:</strong> {{ session('success')['mascota_nombre'] }}
                    </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('mascotas.public.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-paw me-2"></i>Ver Más Mascotas 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    </script>
    @endif
</body>
</html>