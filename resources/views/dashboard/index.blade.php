@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="max-w-[1400px] mx-auto pb-24 px-4" x-data="{ openModal: false }">
    
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <div class="bg-white p-4 rounded-[28px] shadow-md border border-gray-100 flex-shrink-0">
                <img src="{{ asset('imagenes/splash.png') }}" alt="Logo" class="h-20 w-auto object-contain">
            </div>
            
            <div class="hidden sm:block w-[3px] h-20 bg-slate-200 rounded-full"></div>

            <div>
                <h1 class="text-5xl font-black text-slate-800 tracking-tighter leading-none">
                    Panel Administrativo
                </h1>
                <p class="text-gray-500 text-xl font-medium mt-2">
                    Resumen operativo de <span class="text-indigo-600 font-bold">MascotaSafe</span>
                </p>
            </div>
        </div>

        <div class="bg-orange-500 text-white px-8 py-4 rounded-[24px] shadow-lg shadow-orange-200 font-black hidden md:block text-base self-center uppercase tracking-widest">
            <i class="fas fa-calendar-alt mr-2"></i> {{ date('d M, Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-indigo-900 rounded-[40px] p-8 text-white shadow-2xl relative overflow-hidden group">
                    <i class="fas fa-paw absolute -right-6 -bottom-6 text-9xl opacity-10 group-hover:scale-110 transition-transform"></i>
                    <p class="text-indigo-200 text-sm font-bold uppercase tracking-widest">Mascotas Activas</p>
                    <h3 class="text-6xl font-black mt-4">{{ $totalMascotas ?? '0' }}</h3>
                </div>

                <div class="bg-white rounded-[40px] p-8 border border-gray-100 shadow-sm group">
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-widest">Alertas de Batería</p>
                    <h3 class="text-6xl font-black mt-4 text-slate-800">{{ $bateriaBaja ?? '0' }}</h3>
                    <p class="text-red-500 font-bold mt-4 text-sm flex items-center">
                        <span class="relative flex h-3 w-3 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                        Requieren carga inmediata
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-[40px] p-8 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">Mascotas en el Sistema</h3>
                    <a href="{{ route('mascotas.index') }}" class="text-orange-500 font-bold hover:underline text-xs uppercase tracking-widest">Ver Todo</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-gray-50">
                                <th class="pb-4 font-black">Mascota</th>
                                <th class="pb-4 font-black">Salud / Temp</th>
                                <th class="pb-4 font-black text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recientes as $mascota)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-5 font-bold text-slate-700">{{ $mascota['nombre'] ?? 'Sin nombre' }}</td>
                                <td class="py-5 text-sm font-bold text-slate-600">{{ $mascota['temperatura'] ?? '--' }}°C</td>
                                <td class="py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('mascotas.show', $mascota['_id']) }}" class="p-2.5 bg-blue-50 text-blue-600 rounded-xl"><i class="fas fa-eye text-xs"></i></a>
                                      <form action="{{ route('mascotas.destroy', $mascota['_id']) }}" method="POST" class="inline form-eliminar">
    @csrf
    @method('DELETE')
    
    <button type="button" 
            data-nombre="{{ $mascota['nombre'] }}"
            class="p-2.5 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all border border-red-100 btn-borrar">
        <i class="fas fa-trash-alt text-xs"></i>
    </button>
</form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="py-10 text-center text-gray-400 font-medium">No hay registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-2">
            {{-- Botón Anterior --}}
            @if($recientes->onFirstPage())
                <span class="px-4 py-2 bg-gray-50 text-gray-300 rounded-xl text-[10px] font-black uppercase border border-gray-100">Atrás</span>
            @else
                <a href="{{ $recientes->previousPageUrl() }}" class="px-4 py-2 bg-white text-orange-500 hover:bg-orange-500 hover:text-white rounded-xl text-[10px] font-black uppercase border border-orange-100 transition-all shadow-sm">Atrás</a>
            @endif

            {{-- Botón Siguiente --}}
            @if($recientes->hasMorePages())
                <a href="{{ $recientes->nextPageUrl() }}" class="px-4 py-2 bg-white text-orange-500 hover:bg-orange-500 hover:text-white rounded-xl text-[10px] font-black uppercase border border-orange-100 transition-all shadow-sm">Siguiente</a>
            @else
                <span class="px-4 py-2 bg-gray-50 text-gray-300 rounded-xl text-[10px] font-black uppercase border border-gray-100">Siguiente</span>
            @endif
        </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-orange-500 rounded-[40px] p-8 text-white shadow-xl relative overflow-hidden">
                <h4 class="text-xl font-bold mb-6 relative z-10">Acciones</h4>
                <div class="grid grid-cols-2 gap-4 relative z-10">
                    <button @click="openModal = true" class="bg-white/20 hover:bg-white text-white hover:text-orange-500 p-6 rounded-3xl text-center transition-all border border-white/10">
                        <i class="fas fa-plus text-2xl mb-2"></i>
                        <span class="block text-[10px] font-black uppercase">Nueva</span>
                    </button>
                    <a  href="{{route('mapa.index')}}" class="bg-white/20 hover:bg-white text-white hover:text-orange-500 p-6 rounded-3xl text-center transition-all border border-white/10">
                        <i class="fas fa-map-marked-alt text-2xl mb-2"></i>
                        <span class="block text-[10px] font-black uppercase">Mapa</span>
                    </a>
                </div>
                <i class="fas fa-bolt absolute -right-4 -top-4 text-8xl opacity-10"></i>
            </div>

            <div class="rounded-[40px] p-8 border transition-all duration-500 {{ ($alertasGeocerca ?? 0) > 0 ? 'bg-red-50 border-red-200' : 'bg-indigo-50 border-indigo-100' }}">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mx-auto mb-4 text-indigo-600 text-2xl">
                    <i class="fas fa-draw-polygon"></i>
                </div>
                <h3 class="font-bold text-indigo-950 text-lg mb-6 text-center">Geocercas</h3>
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="bg-white/60 p-3 rounded-2xl border border-white text-center">
                        <span class="block text-[9px] font-black text-gray-400 uppercase">Activas</span>
                        <span class="text-xl font-black text-indigo-950">{{ $geocercasActivas ?? 0 }}</span>
                    </div>
                    <div class="bg-white/60 p-3 rounded-2xl border border-white text-center">
                        <span class="block text-[9px] font-black text-gray-400 uppercase">Alertas</span>
                        <span class="text-xl font-black {{ ($alertasGeocerca ?? 0) > 0 ? 'text-red-600' : 'text-indigo-950' }}">{{ $alertasGeocerca ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
        <script>
    // Seleccionamos todos los botones que tengan la clase btn-borrar
    document.querySelectorAll('.btn-borrar').forEach(boton => {
        boton.addEventListener('click', function(e) {
            const nombreMascota = this.getAttribute('data-nombre');
            const formulario = this.closest('.form-eliminar');

            Swal.fire({
                title: '¿Estás seguro?',
                text: `Vas a eliminar a ${nombreMascota}. Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316', // El naranja de tu dashboard
                cancelButtonColor: '#64748b',  // Un gris slate profesional
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                borderRadius: '20px',
                customClass: {
                    popup: 'rounded-[30px]',
                    confirmButton: 'rounded-xl font-black uppercase text-xs tracking-widest px-6 py-3',
                    cancelButton: 'rounded-xl font-black uppercase text-xs tracking-widest px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviamos el formulario manualmente
                    formulario.submit();
                }
            });
        });
    });
</script>
@if(session('success'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}"
    });
</script>
@endif
    </div>

    <div x-show="openModal" 
         style="display: none;" 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="openModal = false"></div>

            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-[40px] shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-[110]">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-slate-800">Registrar Mascota</h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
                    </div>

                    <form action="{{ route('mascotas.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-2">Nombre de la Mascota</label>
                                <input type="text" name="nombre" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-orange-500" placeholder="Ej. Max" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-black uppercase text-gray-400 mb-2">Especie</label>
                                    <select name="especie" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-orange-500">
                                        <option value="Perro">Perro</option>
                                        <option value="Gato">Gato</option>
                                        <option value="Conejo">Conejo</option>
                                        <option value="Hámster">Hámster</option>
                                        <option value="Ave">Ave</option>
                                        <option value="Hurón">Hurón</option>
                                        <option value="Caballo">Caballo</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                              
                            </div>
                        </div>
                        <button type="submit" class="w-full mt-8 bg-orange-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-orange-200">
                            Guardar Mascota
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection