@extends('layouts.app')

@section('content')
<div class="max-w-[1200px] mx-auto pb-32" x-data="{ tab: 'general' }">
    <div class="mb-10 px-4">
        <h1 class="text-4xl font-black text-slate-800">Ajustes del Sistema</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <div class="lg:col-span-3 space-y-2">
            <button @click="tab = 'general'" 
                :class="tab === 'general' ? 'bg-orange-500 text-white shadow-lg shadow-orange-100' : 'text-slate-400 hover:bg-white'"
                class="w-full flex items-center gap-4 p-4 rounded-2xl font-bold transition-all">
                <i class="fas fa-cog"></i> General
            </button>
            
            <button @click="tab = 'seguridad'" 
                :class="tab === 'seguridad' ? 'bg-orange-500 text-white shadow-lg shadow-orange-100' : 'text-slate-400 hover:bg-white'"
                class="w-full flex items-center gap-4 p-4 rounded-2xl font-bold transition-all">
                <i class="fas fa-shield-alt"></i> Seguridad
            </button>
            
            <button @click="tab = 'notificaciones'" 
                :class="tab === 'notificaciones' ? 'bg-orange-500 text-white shadow-lg shadow-orange-100' : 'text-slate-400 hover:bg-white'"
                class="w-full flex items-center gap-4 p-4 rounded-2xl font-bold transition-all">
                <i class="fas fa-bell"></i> Notificaciones
            </button>
        </div>

        <div class="lg:col-span-9">
            
            <div x-show="tab === 'general'" x-transition class="bg-white rounded-[40px] p-10 border border-gray-100 shadow-sm space-y-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-8 tracking-tight">Configuración General</h3>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 border-b border-gray-50">
                    <div>
                        <h4 class="font-bold text-slate-700">Actualización en Tiempo Real</h4>
                        <p class="text-sm text-gray-400">Frecuencia de refresco del GPS (segundos).</p>
                    </div>
                    <input type="number" value="30" class="bg-gray-50 border-none rounded-xl p-4 w-full md:w-32 focus:ring-2 focus:ring-orange-500">
                </div>
                <button class="bg-indigo-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-800 transition-all">Guardar General</button>
            </div>

         <div x-show="tab === 'seguridad'" x-transition class="bg-white rounded-[40px] p-10 border border-gray-100 shadow-sm space-y-10">
    <div class="flex items-center gap-4 mb-2">
        <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center">
            <i class="fas fa-lock text-xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Seguridad de la Cuenta</h3>
    </div>

    <div class="bg-slate-50 rounded-[35px] p-8 border border-gray-100">
        <h4 class="font-black text-slate-700 mb-6 uppercase text-xs tracking-widest">Cambiar Contraseña</h4>
        
        <form action="#" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase ml-2">Contraseña Actual</label>
                    <input type="password" name="current_password" placeholder="••••••••" 
                        class="w-full bg-white border-none rounded-2xl p-4 focus:ring-2 focus:ring-orange-500 shadow-sm transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase ml-2">Nueva Contraseña</label>
                    <input type="password" name="new_password" placeholder="Mín. 8 caracteres" 
                        class="w-full bg-white border-none rounded-2xl p-4 focus:ring-2 focus:ring-orange-500 shadow-sm transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase ml-2">Confirmar Nueva</label>
                    <input type="password" name="confirm_password" placeholder="Repite la contraseña" 
                        class="w-full bg-white border-none rounded-2xl p-4 focus:ring-2 focus:ring-orange-500 shadow-sm transition-all">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-900 text-white px-10 py-4 rounded-2xl font-black shadow-lg shadow-indigo-100 hover:bg-indigo-800 transition-all active:scale-95 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Actualizar Contraseña
                </button>
            </div>
        </form>
    </div>

    <div class="flex items-center justify-between p-6 bg-orange-50 rounded-[30px] border border-orange-100">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white text-orange-500 rounded-2xl flex items-center justify-center shadow-sm">
                <i class="fas fa-shield-virus text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Autenticación de dos pasos (2FA)</h4>
                <p class="text-sm text-slate-500 font-medium">Añade un código de seguridad extra al iniciar sesión.</p>
            </div>
        </div>
        <button class="bg-white text-orange-600 px-6 py-3 rounded-xl font-black text-xs shadow-sm hover:bg-orange-500 hover:text-white transition-all">
            CONFIGURAR
        </button>
    </div>
</div>

            <div x-show="tab === 'notificaciones'" x-transition class="bg-white rounded-[40px] p-10 border border-gray-100 shadow-sm space-y-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-8 tracking-tight">Preferencias de Alerta</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between pb-6 border-b border-gray-50">
                        <div>
                            <h4 class="font-bold text-slate-700">Alertas de Batería Baja</h4>
                            <p class="text-sm text-gray-400">Notificar cuando el collar baje del 20%.</p>
                        </div>
                        <input type="checkbox" checked class="w-6 h-6 text-orange-500 rounded-lg border-gray-200">
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-slate-700">Salida de Zona Segura</h4>
                            <p class="text-sm text-gray-400">Enviar notificación push si la mascota escapa.</p>
                        </div>
                        <input type="checkbox" checked class="w-6 h-6 text-orange-500 rounded-lg border-gray-200">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection