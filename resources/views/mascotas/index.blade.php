@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="max-w-[1400px] mx-auto pb-32 " >
    <div class="flex justify-between items-center mb-10 px-4">
        <div class="flex items-center gap-4"> {{-- Añadimos este contenedor --}}
<img src="{{ asset('imagenes/splash.png') }}" alt="Logo" class="w-20 h-20 object-contain">      <h1 class="text-3xl font-black tracking-tighter text-[#231B6B] leading-none">ATJA’YAA’LA</h1> <h1 class="text-4xl">|</h1> <h1 class="text-4xl font-black text-slate-700">Mis Mascotas</h1>
    </div>
        
        <button onclick="toggleModal('modal-registro')" class="bg-orange-500 text-white px-6 py-3 rounded-2xl font-bold shadow-lg">
    + Nueva Mascota
</button>
    </div>
    <div class="px-4 mb-6">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm mb-4">
                <ul class="list-disc ml-5 font-bold text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 px-4">
        @forelse($mascotas as $mascota)
        @php 
            $id = $mascota['_id'] ?? $mascota['id']; 
            $hasFoto = !empty($mascota['foto_url']);
        @endphp
        
        <div class="bg-white rounded-[40px] p-6 border border-gray-50 shadow-sm hover:shadow-xl transition-all group">
            {{-- Contenedor de Imagen/Icono con clic para subir --}}
            <div class="w-full h-40 bg-slate-50 rounded-[30px] mb-4 flex items-center justify-center relative overflow-hidden group/img">
                
                @if($hasFoto)
                    <img src="{{ $mascota['foto_url'] }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-{{ (isset($mascota['especie']) && $mascota['especie'] == 'Perro') ? 'dog' : 'cat' }} text-5xl text-slate-300"></i>
                @endif

                {{-- Overlay para subir foto al hacer clic --}}
                <label for="file-{{ $id }}" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity cursor-pointer">
                    <i class="fas fa-camera text-white text-2xl"></i>
                    <span class="text-white text-[10px] font-bold ml-2 uppercase">Cambiar foto</span>
                </label>

                {{-- Formulario oculto para subir la foto --}}
                <form id="form-{{ $id }}" action="{{ route('mascotas.updateFoto', $id) }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    
                    <input type="file" name="foto" id="file-{{ $id }}" onchange="document.getElementById('form-{{ $id }}').submit()">
                </form>
                
               {{-- Botón Eliminar --}}
<form action="{{ route('mascotas.destroy', $id) }}" method="POST" class="absolute top-4 right-4 z-10 form-eliminar">
    @csrf
    @method('DELETE')
    <button type="button" class="btn-borrar bg-white/80 backdrop-blur text-red-400 w-8 h-8 rounded-full shadow-sm hover:text-red-600 transition-all">
        <i class="fas fa-trash text-xs"></i>
    </button>
</form>
            </div>

            <div class="px-2 mb-4">
                <h3 class="text-xl font-black text-slate-800">{{ $mascota['nombre'] ?? 'Sin nombre' }}</h3>
                <p class="text-gray-400 text-xs font-bold uppercase">{{ $mascota['especie'] ?? 'S/E' }}</p>
                
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">Batería</span>
                    @php $bat = $mascota['bateria'] ?? 0; @endphp
                    <span class="text-sm font-black {{ $bat < 20 ? 'text-red-500' : 'text-green-500' }}">
                        {{ $bat }}%
                    </span>
                </div>
                
                <div class="w-full bg-gray-100 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="h-full {{ $bat < 20 ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $bat }}%"></div>
                </div>
            </div>

           <div class="grid grid-cols-2 gap-2">
    {{-- Botón Detalles: Asegúrate de tener la ruta 'mascotas.show' --}}
   <button type="button" onclick="toggleModal('modal-show-{{ $id }}')" 
   class="text-center bg-indigo-900 text-white text-[10px] font-black uppercase tracking-widest py-3 rounded-xl hover:bg-indigo-800 transition-all">
    Detalles
</button>
    
    {{-- Botón Editar: Cambiado a <button> para que abra el modal --}}
    <button type="button" onclick="toggleModal('modal-edit-{{ $id }}')"
       class="text-center bg-gray-100 text-slate-600 text-[10px] font-black uppercase tracking-widest py-3 rounded-xl hover:bg-orange-500 hover:text-white transition-all">
        Editar
    </button>
</div>

            {{-- MODAL DE EDICIÓN (Uno por cada mascota) --}}
<div id="modal-edit-{{ $id }}" class="fixed inset-0 z-50 hidden overflow-y-auto text-left">
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="toggleModal('modal-edit-{{ $id }}')"></div>
    
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-md rounded-[40px] p-8 shadow-2xl">
            <h2 class="text-3xl font-black text-slate-800 mb-2">Editar Mascota</h2>
            <p class="text-slate-400 text-sm mb-6 font-bold uppercase tracking-tight">Modificando a: {{ $mascota['nombre'] }}</p>
            
            <form action="{{ route('mascotas.update', $id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 ml-2">Nombre</label>
                        <input type="text" name="nombre" value="{{ $mascota['nombre'] }}" 
                               class="w-full bg-slate-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl px-5 py-4 transition-all outline-none font-bold text-slate-700" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2 ml-2">Especie</label>
                        <select name="especie" class="w-full bg-slate-50 border-2 border-transparent focus:border-orange-500 focus:bg-white rounded-2xl px-5 py-4 transition-all outline-none font-bold text-slate-700 appearance-none">
                            <option value="Perro" {{ $mascota['especie'] == 'Perro' ? 'selected' : '' }}>🐶 Perro</option>
                            <option value="Gato" {{ $mascota['especie'] == 'Gato' ? 'selected' : '' }}>🐱 Gato</option>
                            <option value="Otro" {{ $mascota['especie'] == 'Otro' ? 'selected' : '' }}>🐾 Otro</option>
                        </select>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-2 gap-4">
                    <button type="button" onclick="toggleModal('modal-edit-{{ $id }}')" 
                            class="bg-slate-100 text-slate-500 font-bold py-4 rounded-2xl hover:bg-slate-200 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="bg-indigo-900 text-white font-bold py-4 rounded-2xl shadow-lg hover:bg-indigo-950 transition-all">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DE DETALLES --}}
<div id="modal-show-{{ $id }}" class="fixed inset-0 z-50 hidden overflow-y-auto text-left">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="toggleModal('modal-show-{{ $id }}')"></div>
    
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-lg rounded-[40px] overflow-hidden shadow-2xl">
            {{-- Cabecera con Imagen --}}
            <div class="w-full h-64 bg-slate-100 relative">
                @if($hasFoto)
                    <img src="{{ $mascota['foto_url'] }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-{{ (isset($mascota['especie']) && $mascota['especie'] == 'Perro') ? 'dog' : 'cat' }} text-7xl text-slate-200"></i>
                    </div>
                @endif
                <button onclick="toggleModal('modal-show-{{ $id }}')" class="absolute top-6 right-6 bg-white/20 backdrop-blur text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/40 transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-4xl font-black text-slate-800">{{ $mascota['nombre'] ?? 'Sin nombre' }}</h2>
                        <p class="text-orange-500 font-bold uppercase tracking-widest text-sm">{{ $mascota['especie'] }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold text-slate-400 block mb-1 uppercase">Estado de Batería</span>
                        <span class="text-2xl font-black {{ $bat < 20 ? 'text-red-500' : 'text-green-500' }}">
                            {{ $bat }}%
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">ID del Dispositivo</span>
                        <span class="text-sm font-bold text-slate-700 break-all">{{ $mascota['collarId'] ?? 'sin collar' }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block">Última Conexión</span>
                        <span class="text-sm font-bold text-slate-700">
                            {{-- Después (Corregido) --}}
@if(isset($mascota['ultimaConexion']))
    {{ \Illuminate\Support\Carbon::parse($mascota['ultimaConexion'])->diffForHumans() }}
@else
    Sin registros recientes
@endif
                        </span>
                    </div>
                </div>

                <button type="button" onclick="toggleModal('modal-show-{{ $id }}')" 
                        class="w-full bg-slate-100 text-slate-600 font-black uppercase tracking-widest py-4 rounded-2xl hover:bg-slate-200 transition-all">
                    Cerrar Vista
                </button>
            </div>
        </div>
    </div>
</div>
        </div>
        
        @empty
        <div class="col-span-full text-center py-20 bg-white rounded-[40px] border-2 border-dashed border-gray-100">
            <p class="text-gray-400 font-bold">Aún no tienes mascotas registradas.</p>
        </div>
        @endforelse
    </div>
</div>

<div id="modal-registro" class="fixed inset-0 z-50 hidden overflow-y-auto">
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    
    {{-- Contenedor del Modal --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-md rounded-[40px] p-8 shadow-2xl">
            <h2 class="text-3xl font-black text-slate-800 mb-6">Nueva Mascota</h2>
            
            <form action="{{ route('mascotas.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1 ml-2">Nombre</label>
                        <input type="text" name="nombre" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1 ml-2">Especie</label>
                        <select name="especie" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-orange-500">
                            <option value="Perro">Perro</option>
                            <option value="Gato">Gato</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-4">
                    <button type="button" onclick="toggleModal('modal-registro')" class="bg-slate-100 text-slate-500 font-bold py-3 rounded-2xl">Cancelar</button>
                    <button type="submit" class="bg-orange-500 text-white font-bold py-3 rounded-2xl shadow-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.querySelectorAll('.btn-borrar').forEach(boton => {
    boton.addEventListener('click', function(e) {
        const form = this.closest('form');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f97316', // Naranja como tu botón
            cancelButtonColor: '#64748b', // Slate
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            borderRadius: '20px'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.toggle('hidden');
            // Bloquea el scroll del body al abrir el modal
            if (!modal.classList.contains('hidden')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
    }
</script>
@endsection