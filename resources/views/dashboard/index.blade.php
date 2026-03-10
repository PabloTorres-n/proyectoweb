@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto pb-24">
    
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight">Panel Administrativo</h1>
            <p class="text-gray-500 text-lg font-medium mt-2">Bienvenido de nuevo, aquí está el resumen de hoy.</p>
        </div>
        <div class="bg-orange-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-orange-200 font-bold hidden md:block">
            <i class="fas fa-calendar-alt mr-2"></i> {{ date('d M, Y') }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-indigo-900 rounded-[40px] p-8 text-white shadow-2xl relative overflow-hidden group">
                    <i class="fas fa-paw absolute -right-6 -bottom-6 text-9xl opacity-10 group-hover:scale-110 transition-transform"></i>
                    <p class="text-indigo-200 text-sm font-bold uppercase tracking-widest">Mascotas Activas</p>
                    <h3 class="text-6xl font-black mt-4">{{ $totalMascotas ?? '12' }}</h3>
                </div>

                <div class="bg-white rounded-[40px] p-8 border border-gray-100 shadow-sm group">
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-widest">Alertas de Batería</p>
                    <h3 class="text-6xl font-black mt-4 text-slate-800">{{ $bateriaBaja ?? '2' }}</h3>
                    <p class="text-red-500 font-bold mt-4 text-sm flex items-center">
                        <span class="relative flex h-3 w-3 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                        Requieren atención inmediata
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-[40px] p-8 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">Mascotas en el Sistema</h3>
                    <a href="{{ route('mascotas.index') }}" class="text-orange-500 font-bold hover:underline">Ver todas las tarjetas</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-xs uppercase tracking-widest border-b border-gray-50">
                                <th class="pb-4 font-black">Mascota</th>
                                <th class="pb-4 font-black">Especie</th>
                                <th class="pb-4 font-black">Batería</th>
                                <th class="pb-4 font-black">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recientes ?? [] as $mascota)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500 group-hover:bg-white shadow-sm transition-all">
                                            <i class="fas fa-{{ $mascota->especie == 'Perro' ? 'dog' : 'cat' }} text-xl"></i>
                                        </div>
                                        <span class="font-bold text-slate-700">{{ $mascota->nombre }}</span>
                                    </div>
                                </td>
                                <td class="py-5 text-gray-500 font-medium">{{ $mascota->especie }}</td>
                                <td class="py-5">
                                    <div class="flex items-center gap-2 text-slate-800 font-black">
                                        {{ $mascota->bateria }}%
                                        <div class="w-10 h-2 bg-gray-100 rounded-full overflow-hidden hidden sm:block">
                                            <div class="h-full bg-orange-500" style="width: {{ $mascota->bateria }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5">
                                    <a href="#" class="bg-gray-100 text-gray-500 px-4 py-2 rounded-xl text-xs font-bold hover:bg-orange-500 hover:text-white transition-all">Detalles</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-orange-500 rounded-[40px] p-8 text-white shadow-xl shadow-orange-100">
                <h4 class="text-xl font-bold mb-6">Acciones Rápidas</h4>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('mascotas.create') }}" class="bg-white/20 hover:bg-white/30 p-6 rounded-3xl text-center transition-all">
                        <i class="fas fa-plus text-2xl mb-2"></i>
                        <span class="block text-xs font-black uppercase">Nueva</span>
                    </a>
                    <a href="" class="bg-white/20 hover:bg-white/30 p-6 rounded-3xl text-center transition-all">
                        <i class="fas fa-map-marked-alt text-2xl mb-2"></i>
                        <span class="block text-xs font-black uppercase">Mapa</span>
                    </a>
                </div>
            </div>

            <div class="bg-indigo-50 rounded-[40px] p-8 border border-indigo-100 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mx-auto mb-6">
                    <i class="fas fa-satellite-dish text-indigo-600 text-3xl"></i>
                </div>
                <h3 class="font-bold text-indigo-950 text-xl mb-2">Estado GPS</h3>
                <p class="text-indigo-700/60 text-sm mb-6">Todos los dispositivos están reportando ubicación en tiempo real.</p>
                <button class="w-full bg-white text-indigo-950 font-bold py-4 rounded-2xl border-2 border-indigo-100 hover:bg-indigo-100 transition-all">Revisar Conexiones</button>
            </div>
        </div>

    </div>
</div>
@endsection