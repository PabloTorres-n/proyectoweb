@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto pb-32">
    <div class="flex justify-between items-center mb-10 px-4">
        <h1 class="text-4xl font-black text-slate-800">Mis Mascotas</h1>
        <a href="{{ route('mascotas.create') }}" class="bg-orange-500 text-white px-6 py-3 rounded-2xl font-bold shadow-lg">
            + Nueva Mascota
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 px-4">
        @forelse($mascotas as $mascota)
        <div class="bg-white rounded-[40px] p-6 border border-gray-50 shadow-sm hover:shadow-xl transition-all group">
            <div class="w-full h-40 bg-slate-50 rounded-[30px] mb-4 flex items-center justify-center relative">
                <i class="fas fa-{{ $mascota->especie == 'Perro' ? 'dog' : 'cat' }} text-5xl text-slate-300"></i>
                
                <form action="{{ route('mascotas.destroy', $mascota->id) }}" method="POST" class="absolute top-4 right-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar esta mascota?')" class="bg-white text-red-400 w-8 h-8 rounded-full shadow-sm hover:text-red-600 transition-all">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </form>
            </div>

            <div class="px-2">
                <h3 class="text-xl font-black text-slate-800">{{ $mascota->nombre }}</h3>
                <p class="text-gray-400 text-xs font-bold uppercase">{{ $mascota->especie }}</p>
                
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">Batería</span>
                    <span class="text-sm font-black {{ $mascota->bateria < 20 ? 'text-red-500' : 'text-green-500' }}">
                        {{ $mascota->bateria }}%
                    </span>
                </div>
                
                <div class="w-full bg-gray-100 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="h-full {{ $mascota->bateria < 20 ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $mascota->bateria }}%"></div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('mascotas.show', $mascota->id) }}" 
                       class="text-center bg-indigo-900 text-white text-[10px] font-black uppercase tracking-widest py-3 rounded-xl hover:bg-indigo-800 transition-all">
                        Detalles
                    </a>
                    <a href="{{ route('mascotas.edit', $mascota->id) }}" 
                       class="text-center bg-gray-100 text-slate-600 text-[10px] font-black uppercase tracking-widest py-3 rounded-xl hover:bg-orange-500 hover:text-white transition-all">
                        Editar
                    </a>
                </div>
        </div>
        
        @empty
        <div class="col-span-full text-center py-20 bg-white rounded-[40px] border-2 border-dashed border-gray-100">
            <p class="text-gray-400 font-bold">Aún no tienes mascotas registradas con este ID.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection