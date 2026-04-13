@extends('layouts.app')

@section('content')
{{-- Eliminamos el max-w y usamos w-full h-screen --}}
<div class="relative w-full h-screen overflow-hidden bg-[#f8fafc]">
    
    {{-- HEADER FULL WIDTH --}}
    <header class="absolute top-0 left-0 right-0 h-20 bg-white/90 backdrop-blur-md z-40 flex items-center shadow-sm border-b border-slate-200/60 px-6">
        <div class="flex items-center gap-4 pr-6 border-r border-slate-200 h-10">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shadow-[#231B6B]/20 bg-white">
                <img src="{{ asset('imagenes/splash.png') }}" class="h-8 w-auto object-contain" alt="Logo">
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black tracking-tighter text-[#231B6B] leading-none">ATHA<span class="text-orange-500">YALA</span></span>
            </div>
        </div>

        {{-- BUSCADOR CENTRADO --}}
        <div class="flex-1 flex justify-center">
            <form action="{{ route('mapa.index', $mascotaActiva['_id'] ?? '') }}" method="GET" class="flex items-center bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3 px-4 border-r border-slate-100">
                    <i class="far fa-calendar text-slate-400 text-xs"></i>
                    <input type="date" name="desde" value="{{ request('desde', now()->subDay()->format('Y-m-d')) }}" class="bg-transparent border-none text-xs font-bold p-0 focus:ring-0 text-slate-700 w-28">
                </div>
                <div class="flex items-center gap-3 px-4">
                    <input type="date" name="hasta" value="{{ request('hasta', now()->format('Y-m-d')) }}" class="bg-transparent border-none text-xs font-bold p-0 focus:ring-0 text-slate-700 w-28">
                </div>
                <button type="submit" class="bg-[#231B6B] text-white h-9 px-4 rounded-xl font-bold text-[10px] hover:bg-orange-500 transition-all flex items-center gap-2 shadow-md">
                    <i class="fas fa-sync-alt text-[8px]"></i> FILTRAR
                </button>
            </form>
        </div>

        @if(isset($mascotaActiva))
        <div class="pl-6">
            <div class="flex items-center gap-3 bg-slate-100/50 py-2 px-4 rounded-2xl border border-slate-200">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-black text-slate-700">{{ $mascotaActiva['nombre'] }}</span>
            </div>
        </div>
        @endif
    </header> 

    {{-- ASIDE FLOTANTE A LA IZQUIERDA --}}
    <aside class="absolute top-24 left-6 w-72 bg-white/95 backdrop-blur-md z-30 flex flex-col shadow-2xl shadow-slate-900/10 border border-slate-200 rounded-[32px] overflow-hidden" style="max-height: calc(100vh - 120px);">
        <div class="p-6 flex-1 overflow-y-auto custom-scrollbar">
            <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Dispositivos</h3>
            <div class="space-y-3">
                @foreach($todasLasMascotas as $m)
                <a href="{{ route('mapa.index', $m['_id']) }}?desde={{ request('desde') }}&hasta={{ request('hasta') }}" 
                   class="group flex items-center gap-3 p-3 rounded-2xl transition-all border {{ (isset($mascotaActiva) && $mascotaActiva['_id'] == $m['_id']) ? 'border-orange-500 bg-orange-50/50 shadow-sm shadow-orange-100' : 'border-transparent bg-slate-50 hover:bg-white hover:border-slate-200' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ (isset($mascotaActiva) && $mascotaActiva['_id'] == $m['_id']) ? 'bg-orange-500 text-white' : 'bg-white text-slate-400' }} shadow-sm text-sm">
                        <i class="fas fa-paw"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-black text-slate-800 truncate">{{ $m['nombre'] }}</p>
                        <p class="text-[10px] font-bold text-slate-400">GPS Activo</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        @if(count($puntos) > 0)
        <div class="p-5 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <div class="flex flex-col">
                <span class="text-[8px] font-bold text-slate-400 uppercase">Registros</span>
                <span class="text-sm font-black text-[#231B6B]">{{ count($puntos) }}</span>
            </div>
            <div class="px-3 py-1 bg-green-500 text-white rounded-lg shadow-lg shadow-green-100 text-[8px] font-black uppercase">
                En línea
            </div>
        </div>
        @endif
    </aside>

    {{-- MAPA: OCUPA EL 100% SIN MÁRGENES --}}
    <main class="absolute inset-0 z-10">
        <div id="map-historial" class="w-full h-full"></div>

        {{-- Alerta centradita si no hay datos --}}
        @if(count($puntos) == 0 && isset($mascotaActiva))
        <div class="absolute inset-0 flex items-center justify-center bg-slate-900/20 backdrop-blur-[2px] z-[1000]">
            <div class="bg-white p-8 rounded-[40px] shadow-2xl text-center max-w-xs border border-white">
                <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <i class="fas fa-map-marker-alt text-2xl"></i>
                </div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Sin registros</h2>
                <p class="text-slate-500 text-xs mt-2 px-4 leading-relaxed">No hay movimientos detectados para esta fecha.</p>
            </div>
        </div>
        @endif
    </main>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Eliminamos márgenes globales del layout para que pegue al borde */
    html, body { height: 100vh; overflow: hidden; margin: 0 !important; padding: 0 !important; }
    
    /* Scrollbar minimalista */
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    /* Mapa ocupando todo */
    #map-historial { width: 100% !important; height: 100% !important; background: #e5e7eb; }

    /* Estética de Leaflet */
    .leaflet-control-zoom { border: none !important; box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; margin-bottom: 30px !important; margin-right: 20px !important; }
    .leaflet-control-zoom-in, .leaflet-control-zoom-out { border-radius: 12px !important; border: none !important; color: #231B6B !important; font-weight: bold !important; }
</style>

{{-- Scripts igual que antes pero con tiempo de renderizado más rápido --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.polyline.snakeanim@0.2.0/L.Polyline.SnakeAnim.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map-historial', { zoomControl: false, attributionControl: false });

        L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', { maxZoom: 20 }).addTo(map);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        const registrosRaw = @json($puntos) || [];
        const coordenadas = registrosRaw
            .filter(p => p && parseFloat(p.lat) !== 0 && parseFloat(p.lng) !== 0)
            .map(p => [parseFloat(p.lat), parseFloat(p.lng)])
            .reverse();

        if (coordenadas.length > 0) {
            const startIcon = L.divIcon({
                html: '<div class="w-3 h-3 bg-slate-800 border-2 border-white rounded-full"></div>',
                className: 'custom-div-icon', iconSize: [12, 12]
            });

            const endIcon = L.divIcon({
                html: '<div class="relative"><div class="absolute inset-0 animate-ping bg-orange-400 rounded-full opacity-75"></div><div class="relative w-4 h-4 bg-orange-600 border-2 border-white rounded-full shadow-lg"></div></div>',
                className: 'custom-div-icon', iconSize: [16, 16]
            });

            L.marker(coordenadas[0], { icon: startIcon }).addTo(map);

            if (coordenadas.length > 1) {
                var polyline = L.polyline(coordenadas, { color: '#f97316', weight: 5, snakingSpeed: 200 }).addTo(map);
                map.fitBounds(polyline.getBounds(), {padding: [100, 100]});
                if (polyline.snakeIn) polyline.snakeIn();
                polyline.on('snakeend', () => {
                    L.marker(coordenadas[coordenadas.length - 1], { icon: endIcon }).addTo(map).bindPopup("<b>Ubicación actual</b>").openPopup();
                });
            } else {
                map.setView(coordenadas[0], 17);
                L.marker(coordenadas[0], { icon: endIcon }).addTo(map).openPopup();
            }
        } else {
            map.setView([20.6667, -103.3333], 12);
        }

        // El truco para que no salgan las franjas grises en el mapa
        setTimeout(() => { map.invalidateSize(); }, 400);
    });
</script>
@endsection