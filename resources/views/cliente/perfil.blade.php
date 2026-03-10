@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto pb-32 pt-4">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 px-4">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[45px] p-8 border border-gray-100 shadow-sm text-center">
                <div class="relative inline-block">
                    <div class="w-40 h-40 bg-orange-100 rounded-[40px] mx-auto mb-6 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden">
                        <i class="fas fa-user text-orange-500 text-6xl"></i>
                    </div>
                    <button class="absolute bottom-4 right-0 bg-indigo-900 text-white w-10 h-10 rounded-2xl border-4 border-white flex items-center justify-center shadow-lg">
                        <i class="fas fa-camera text-xs"></i>
                    </button>
                </div>
                <h2 class="text-3xl font-black text-slate-800">¡Hola, Juan!</h2>
                <p class="text-gray-400 font-bold text-xs uppercase tracking-widest mt-1">Dueño Responsable</p>
                
                <div class="mt-8 pt-8 border-t border-gray-50 flex justify-around">
                    <div class="text-center">
                        <p class="text-2xl font-black text-slate-800">4</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Mascotas</p>
                    </div>
                   
                </div>
            </div>

            <div class="bg-indigo-50 rounded-[40px] p-8 text-center border border-indigo-100">
                <i class="fas fa-question-circle text-indigo-400 text-3xl mb-4"></i>
                <h4 class="font-bold text-indigo-950">¿Necesitas ayuda?</h4>
                <p class="text-indigo-700/60 text-xs mt-2">Revisa nuestras guías de cuidado o contacta a soporte.</p>
                <button class="mt-4 text-indigo-900 font-black text-xs uppercase hover:underline">Ir a ayuda</button>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-8">
            
            <div class="bg-white rounded-[45px] p-10 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                        <i class="fas fa-id-card text-orange-500"></i> Mi Información
                    </h3>
                    <span class="text-[10px] bg-green-100 text-green-600 px-3 py-1 rounded-full font-black uppercase tracking-widest">Cuenta Activa</span>
                </div>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase ml-2 tracking-widest">Nombre Completo</label>
                        <input type="text" value="Juan Delgado" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-orange-500 transition-all shadow-inner">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase ml-2 tracking-widest">Correo Electrónico</label>
                        <input type="email" value="juan.delgado@email.com" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-orange-500 transition-all shadow-inner">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase ml-2 tracking-widest">Teléfono de Emergencia</label>
                        <input type="tel" value="+52 33 1234 5678" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-slate-700 focus:ring-2 focus:ring-orange-500 transition-all shadow-inner">
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="w-full bg-indigo-900 text-white py-4 rounded-2xl font-black shadow-lg shadow-indigo-100 hover:bg-indigo-800 transition-all active:scale-95">
                            Actualizar mis datos
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-[45px] p-10 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Estado de Collares GPS</h3>
                        <p class="text-gray-400 text-sm font-medium">Monitoreo técnico de tus dispositivos vinculados.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-slate-50 rounded-[35px] border border-transparent hover:border-indigo-100 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <span class="text-[9px] font-black bg-green-100 text-green-600 px-2 py-1 rounded-full uppercase">Conectado</span>
                        </div>
                        <p class="font-bold text-slate-800">Collar Firulais (V3)</p>
                        <p class="text-[10px] text-gray-400 uppercase font-black mt-1">Señal Satelital: Fuerte</p>
                        
                        <div class="mt-4 flex items-center gap-2">
                            <div class="flex-1 bg-gray-200 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-500 h-full" style="width: 85%"></div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500">85%</span>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 rounded-[35px] border border-transparent hover:border-indigo-100 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <span class="text-[9px] font-black bg-gray-200 text-gray-500 px-2 py-1 rounded-full uppercase">Stand-by</span>
                        </div>
                        <p class="font-bold text-slate-800">Collar Michi (V2)</p>
                        <p class="text-[10px] text-gray-400 uppercase font-black mt-1">Señal Satelital: Buscando...</p>
                        
                        <div class="mt-4 flex items-center gap-2">
                            <div class="flex-1 bg-gray-200 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-orange-400 h-full" style="width: 40%"></div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500">40%</span>
                        </div>
                    </div>
                </div>
            </div>

            

        </div>
    </div>
</div>
@endsection