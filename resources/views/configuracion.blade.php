@extends('layouts.app')

@section('content')
<div class="h-screen flex flex-col overflow-hidden bg-transparent" x-data="{ tab: 'seguridad' }">
    
    {{-- HEADER DE AJUSTES --}}
    <header class="flex justify-between items-center px-8 py-4 flex-shrink-0">
        <div class="flex items-center gap-4">
            <img src="{{ asset('imagenes/splash.png') }}" alt="Logo" class="w-16 h-16 object-contain">
            <h1 class="text-3xl font-black tracking-tighter text-[#231B6B] leading-none">ATJA’YAA’LA</h1>
            <h1 class="text-4xl text-slate-300">|</h1>
            <h1 class="text-3xl font-black text-slate-700 leading-none">Ajustes</h1>
        </div>
        
        <div class="flex items-center gap-4">
             <a href="{{ route('dashboard') }}" class="bg-slate-100 text-slate-600 px-6 py-3 rounded-2xl font-bold hover:bg-slate-200 transition-all flex items-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i> Volver
            </a>
        </div>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="flex-1 max-w-[1400px] w-full mx-auto px-6 pb-8 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full">
            
            {{-- COLUMNA IZQUIERDA: MENÚ --}}
            <div class="lg:col-span-3 space-y-3">
                <button @click="tab = 'seguridad'" 
                    :class="tab === 'seguridad' ? 'bg-orange-500 text-white shadow-lg shadow-orange-100' : 'bg-white text-slate-400 hover:bg-slate-50'"
                    class="w-full flex items-center gap-4 p-5 rounded-[30px] font-black text-xs uppercase tracking-widest transition-all border border-gray-50">
                    <i class="fas fa-shield-alt text-lg"></i> Seguridad
                </button>
                
                {{-- Espacio para futuras pestañas --}}
            </div>

            {{-- COLUMNA DERECHA: PANELES --}}
            <div class="lg:col-span-9 h-full overflow-y-auto custom-scrollbar pr-2">
                
                <div x-show="tab === 'seguridad'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    
                    {{-- CARD PRINCIPAL --}}
                    <div class="bg-white rounded-[45px] p-10 border border-gray-100 shadow-sm mb-6">
                        <div class="flex items-center gap-5 mb-10">
                            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-[22px] flex items-center justify-center shadow-sm">
                                <i class="fas fa-lock text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Seguridad de la Cuenta</h3>
                                <p class="text-sm text-slate-400 font-medium">Gestiona tus credenciales y protege tu acceso.</p>
                            </div>
                        </div>

{{-- Sección de Mensajes de Éxito --}}
@if(session('success'))
    <div class="max-w-[1400px] mx-auto px-6 mb-6">
        <div class="bg-emerald-50 border border-emerald-100 rounded-[25px] p-5 flex items-center justify-between shadow-sm animate-bounce-short">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <h4 class="font-black text-emerald-900 text-sm tracking-tight uppercase">¡Excelente!</h4>
                    <p class="text-emerald-600 text-xs font-bold">{{ session('success') }}</p>
                </div>
            </div>
            {{-- Botón para cerrar la alerta manualmente --}}
            <button onclick="this.parentElement.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600 transition-colors mr-2">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

{{-- Sección de Mensajes de Error (Contraseña incorrecta, etc.) --}}
@if($errors->has('password_error') || $errors->any())
    <div class="max-w-[1400px] mx-auto px-6 mb-6">
        <div class="bg-red-50 border border-red-100 rounded-[25px] p-5 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 bg-red-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-red-200">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <h4 class="font-black text-red-900 text-sm tracking-tight uppercase">Hubo un problema</h4>
                <p class="text-red-600 text-xs font-bold">
                    {{ $errors->first('password_error') ?: $errors->first() }}
                </p>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('settings.password.update') }}" method="POST" class="space-y-8">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Input Contraseña Actual --}}
        <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase ml-3 tracking-widest flex items-center gap-2">
                <i class="fas fa-key text-[8px]"></i> Contraseña Actual
            </label>
            <input type="password" name="current_password" required
                class="w-full bg-slate-50 border-2 border-transparent focus:border-orange-500 rounded-[25px] p-5 font-bold text-slate-700 outline-none transition-all shadow-inner">
        </div>

        {{-- Input Nueva Contraseña --}}
        <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase ml-3 tracking-widest flex items-center gap-2">
                <i class="fas fa-plus-circle text-[8px]"></i> Nueva Contraseña
            </label>
            <input type="password" name="new_password" required
                class="w-full bg-slate-50 border-2 border-transparent focus:border-orange-500 rounded-[25px] p-5 font-bold text-slate-700 outline-none transition-all shadow-inner">
        </div>

        {{-- Confirmar Nueva --}}
        <div class="md:col-span-2 space-y-2">
            <label class="text-[10px] font-black text-gray-400 uppercase ml-3 tracking-widest flex items-center gap-2">
                <i class="fas fa-check-circle text-[8px]"></i> Confirmar Nueva Contraseña
            </label>
            <input type="password" name="confirm_password" required
                class="w-full bg-slate-50 border-2 border-transparent focus:border-orange-500 rounded-[25px] p-5 font-bold text-slate-700 outline-none transition-all shadow-inner">
        </div>
    </div>

    <div class="pt-6 border-t border-gray-50 flex justify-end">
        <button type="submit" class="bg-[#231B6B] text-white px-12 py-5 rounded-[25px] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-indigo-100 hover:bg-indigo-800 transition-all active:scale-95 flex items-center gap-3">
            <i class="fas fa-sync-alt"></i> Actualizar Credenciales
        </button>
    </div>
</form>
                    </div>

                    {{-- CARD INFORMATIVA --}}
                    <div class="bg-orange-50 rounded-[35px] p-8 border border-orange-100 flex items-center gap-6">
                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-orange-500 flex-shrink-0">
                            <i class="fas fa-user-shield text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Tu privacidad es prioridad</h4>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed">
                                Athayala utiliza encriptación de grado bancario para tus contraseñas. Recuerda usar combinaciones de números, letras y símbolos para mayor seguridad.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #e2e8f0; }
</style>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection