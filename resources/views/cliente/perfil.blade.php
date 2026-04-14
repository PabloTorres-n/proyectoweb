@extends('layouts.app')

@section('content')
{{-- SWEET ALERT PARA BORRAR --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="h-screen flex flex-col overflow-hidden bg-transparent">
    
    <header class="flex justify-between items-center px-8 flex-shrink-0">
        <div class="flex items-center gap-4">
            <img src="{{ asset('imagenes/splash.png') }}" alt="Logo" class="w-16 h-16 object-contain">
            <h1 class="text-3xl font-black tracking-tighter text-[#231B6B] leading-none">ATJA’YAA’LA</h1>
            <h1 class="text-4xl text-slate-300">|</h1>
            <h1 class="text-3xl font-black text-slate-700 leading-none">Mi Perfil</h1>
        </div>
        
        <div class="flex items-center gap-4">
             <a href="{{ route('dashboard') }}" class="bg-slate-100 text-slate-600 px-6 py-3 rounded-2xl font-bold hover:bg-slate-200 transition-all flex items-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i> Volver
            </a>
        </div>
    </header>

    <div class="flex-1 max-w-[1400px] w-full mx-auto px-6 pb-8 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full">
            
            {{-- COLUMNA IZQUIERDA: DATOS DEL DUEÑO --}}
            <div class="lg:col-span-4 flex flex-col gap-6 h-full overflow-hidden">
                
                {{-- CARD DE FOTO PERFIL --}}
                <div class="bg-white rounded-[45px] p-8 border border-gray-100 shadow-sm text-center flex-shrink-0 relative overflow-hidden group/perfil">
                    <div class="absolute inset-0 bg-indigo-50/50 opacity-0 group-hover/perfil:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative z-10">
                        {{-- Contenedor de Imagen con clic --}}
                        <div class="w-32 h-32 rounded-[35px] mx-auto mb-4 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden relative group/img cursor-pointer bg-orange-100">
                            
                            @if(!empty($user['foto_url']))
                                <img src="{{ $user['foto_url'] }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-5xl text-orange-500"></i>
                            @endif

                            {{-- Overlay para subir foto --}}
                            <label for="foto-dueño" class="absolute inset-0 bg-indigo-950/60 flex flex-col items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity duration-300 cursor-pointer">
                                <i class="fas fa-camera text-white text-2xl mb-1"></i>
                                <span class="text-white text-[9px] font-black uppercase tracking-widest">Cambiar</span>
                            </label>

                            {{-- Formulario oculto --}}
                            <form id="form-foto-dueño" action="{{ route('perfil.updateFoto', session('user_id')) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                               
                                <input type="file" name="foto" id="foto-dueño" accept="image/*" onchange="document.getElementById('form-foto-dueño').submit()">
                            </form>
                        </div>

                        <h2 class="text-3xl font-black text-slate-800 tracking-tighter">¡Hola, {{ explode(' ', $user['nombre'] ?? 'Usuario')[0] }}!</h2>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Dueño del Ecosistema</p>
                    </div>
                </div>

                {{-- FORMULARIO DE DATOS --}}
                <div class="bg-white rounded-[45px] p-8 border border-gray-100 shadow-sm flex-1 overflow-hidden flex flex-col">
                    <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-id-card text-orange-500"></i> Mis Datos
                    </h3>
                    <form action="{{ route('perfil.update') }}" method="POST" class="space-y-5 flex-1 flex flex-col">
                        @csrf
                   
                        <div class="space-y-4">
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase ml-2 tracking-widest">Nombre Completo</label>
                                <input type="text" name="nombre" value="{{ $user['nombre'] ?? '' }}" readonly class="w-full bg-gray-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-orange-500 shadow-inner">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-gray-400 uppercase ml-2 tracking-widest">Correo Electrónico</label>
                                <input type="email" value="{{ $user['correo'] ?? '' }}" readonly class="w-full bg-gray-100 border-none rounded-2xl p-4 text-sm font-bold text-gray-400 cursor-not-allowed shadow-inner">
                            </div>
                        </div>
                        <div class="mt-auto pt-6">
                           <button type="button" onclick="openModal()" 
        class="w-full bg-[#231B6B] text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg hover:bg-[#1a1450] transition-all active:scale-95">
    Actualizar Perfil
</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- COLUMNA DERECHA: ESTADO DE DISPOSITIVOS --}}
            <div class="lg:col-span-8 h-full flex flex-col bg-white rounded-[50px] border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-10 pb-6 flex-shrink-0">
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">Estado de Dispositivos</h3>
                    <p class="text-gray-400 text-sm font-medium">Monitoreo técnico de collares GPS vinculados.</p>
                </div>

                <div class="flex-1 overflow-y-auto px-10 pb-10 custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($collares as $collar)
                            <div class="p-6 bg-slate-50 rounded-[35px] border border-transparent hover:border-indigo-100 transition-all group relative overflow-hidden">
                                {{-- Decoración de fondo --}}
                                <div class="absolute -right-4 -top-4 text-slate-100 group-hover:text-indigo-50 transition-colors">
                                    <i class="fas fa-wifi text-6xl"></i>
                                </div>

                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-4">
                                        {{-- FOTO DE LA MASCOTA --}}
                                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm overflow-hidden border-2 border-white">
                                            @if(!empty($collar['foto']))
                                                <img src="{{ $collar['foto'] }}" class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-500">
                                            @else
                                                <div class="text-indigo-600">
                                                    <i class="fas fa-microchip text-xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <span class="text-[9px] font-black {{ ($collar['estado'] ?? '') == 'activo' ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500' }} px-3 py-1 rounded-full uppercase tracking-tighter">
                                            {{ $collar['estado'] ?? 'Stand-by' }}
                                        </span>
                                    </div>

                                    {{-- Título: Nombre de mascota priorizado --}}
                                    <p class="font-bold text-slate-800 text-lg leading-tight">
                                        {{ $collar['mascota_nombre'] ?? ($collar['perro'] ?? 'Dispositivo') }}
                                    </p>
                                    
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">
                                        ID: {{ $collar['collarId'] ?? '---' }}
                                    </p>
                                    
                                    <div class="mt-6">
                                        <div class="flex justify-between mb-2">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Batería</span>
                                            <span class="text-[10px] font-bold {{ ($collar['bateria'] ?? 0) < 20 ? 'text-red-500' : 'text-slate-600' }}">
                                                {{87 }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden shadow-inner">
                                            <div class="h-full transition-all duration-1000 rounded-full {{ ($collar['bateria'] ?? 0) < 20 ? 'bg-red-500' : 'bg-indigo-500' }}" 
                                                 style="width: {{  87 }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-20">
                                <i class="fas fa-satellite text-slate-200 text-5xl mb-4"></i>
                                <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">No hay collares vinculados a tu cuenta</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="modal-perfil" class="fixed inset-0 z-[999] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" style="display: none;">
    <div class="relative transform overflow-y-auto rounded-[45px] bg-white p-10 text-left shadow-2xl transition-all w-full max-w-md max-h-[90vh] border border-gray-100 animate-in fade-in zoom-in duration-200 custom-scrollbar">
        
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-black text-slate-800 tracking-tighter">Editar mi información</h3>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-slate-800 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="{{ route('perfil.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase ml-2 tracking-widest flex items-center gap-2">
                    <i class="fas fa-user text-[8px]"></i> Nombre Completo
                </label>
                <input type="text" name="nombre" value="{{ $user['nombre'] ?? '' }}" 
                       class="w-full bg-slate-50 border-2 border-transparent focus:border-orange-500 rounded-2xl p-4 font-bold text-slate-700 outline-none transition-all shadow-inner"
                       placeholder="Ej. Juan Pérez" required>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase ml-2 tracking-widest flex items-center gap-2">
                    <i class="fas fa-phone text-[8px]"></i> Teléfono de Contacto
                </label>
                <input type="tel" name="telefono" value="{{ $user['telefono'] ?? '' }}" 
                       class="w-full bg-slate-50 border-2 border-transparent focus:border-orange-500 rounded-2xl p-4 font-bold text-slate-700 outline-none transition-all shadow-inner"
                       placeholder="Ej. +52 5512345678">
            </div>

            

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase ml-2 tracking-widest flex items-center gap-2">
                    <i class="fas fa-envelope text-[8px]"></i> Correo Electrónico
                </label>
                <input type="email" value="{{ $user['correo'] ?? '' }}" readonly 
                       class="w-full bg-gray-100 border-none rounded-2xl p-4 font-bold text-gray-400 cursor-not-allowed shadow-inner">
                <p class="text-[8px] text-gray-400 ml-2 italic text-center">* Protegemos tu identidad: el correo es fijo.</p>
            </div>

            <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-2">
                <button type="button" onclick="closeModal()" 
                        class="flex-1 bg-slate-100 text-slate-500 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                    Cancelar
                </button>
                <button type="submit" 
                        class="flex-1 bg-orange-500 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all active:scale-95">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modalPerfil = document.getElementById('modal-perfil');

    function openModal() {
        // Quitamos hidden y ponemos flex para que Tailwind lo centre
        modalPerfil.style.display = 'flex';
        modalPerfil.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalPerfil.style.display = 'none';
        modalPerfil.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Cerrar al hacer clic en el fondo oscuro
    window.onclick = function(event) {
        if (event.target == modalPerfil) {
            closeModal();
        }
    }

    // Cerrar con tecla ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #e2e8f0;
    }
</style>
@endsection