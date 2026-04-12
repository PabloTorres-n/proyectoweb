
@extends('layouts.app')

@section('content')
<div class="h-screen w-full bg-[#f8fafc] overflow-hidden relative text-sm font-sans tracking-tight">
    
<header class="absolute top-0 left-0 right-0 h-32 bg-white z-40 flex items-center shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] border-b border-slate-100 px-10">
    
    <div class="flex items-center gap-6 pr-10 border-r border-slate-100 h-20">
        <div class="w-20 h-20  rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-[#231B6B]/40 rotate-3 hover:rotate-0 transition-all duration-300">
            <img src="{{ asset('imagenes/splash.png') }}" class="h-16 w-auto object-contain" alt="Logo">
        </div>
        
        <div class="flex flex-col">
            <span class="text-3xl font-black tracking-tighter text-[#231B6B] leading-none">ATHA<span class="text-orange-500">YALA</span></span>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.4em] mt-2">TRACK</span>
        </div>
    </div>

    <div class="flex-1 flex justify-center">
        <form action="{{ route('mapa.index', $mascotaActiva['_id'] ?? '') }}" method="GET" class="flex items-center bg-slate-50 p-2 rounded-[28px] border border-slate-200/60 shadow-inner">
            <div class="flex items-center gap-4 px-6 py-1 border-r border-slate-200">
                <i class="far fa-calendar text-slate-400 text-sm"></i>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Fecha Inicio</span>
                    <input type="date" name="desde" value="{{ request('desde', now()->subDay()->format('Y-m-d')) }}" class="bg-transparent border-none text-[14px] font-bold p-0 focus:ring-0 text-slate-700 w-36">
                </div>
            </div>
            <div class="flex items-center gap-4 px-6 py-1">
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Fecha Término</span>
                    <input type="date" name="hasta" value="{{ request('hasta', now()->format('Y-m-d')) }}" class="bg-transparent border-none text-[14px] font-bold p-0 focus:ring-0 text-slate-700 w-36">
                </div>
            </div>
            <button type="submit" class="bg-[#231B6B] text-white h-12 px-8 rounded-[22px] font-black text-xs hover:bg-orange-500 transition-all flex items-center gap-3 shadow-lg shadow-[#231B6B]/20 active:scale-95">
                <i class="fas fa-sync-alt"></i>
                ACTUALIZAR
            </button>
        </form>
    </div>

    @if(isset($mascotaActiva))
    <div class="pl-10">
        <div class="bg-orange-50 border border-orange-100 p-2.5 pr-8 rounded-[30px] flex items-center gap-4 shadow-sm">
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-md text-orange-500 border border-orange-50">
                <i class="fas fa-paw text-2xl"></i>
            </div>
            <div>
                <p class="text-[11px] font-black text-orange-500 uppercase tracking-widest">En Pantalla</p>
                <p class="text-xl font-black text-slate-800 leading-none">{{ $mascotaActiva['nombre'] }}</p>
            </div>
        </div>
    </div>
    @endif
</header> 
    <aside class="absolute top-24 left-0 w-80 bg-white z-20 flex flex-col shadow-sm border-r border-slate-100" style="height: calc(100% - 150px);">
        <div class="p-8 flex-1 overflow-y-auto custom-scrollbar">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Mascotas Vinculadas</h3>
            <div class="space-y-4">
                @foreach($todasLasMascotas as $m)
                <a href="{{ route('mapa.index', $m['_id']) }}?desde={{ request('desde') }}&hasta={{ request('hasta') }}" 
                   class="group flex items-center gap-4 p-4 rounded-[28px] transition-all border-2 {{ (isset($mascotaActiva) && $mascotaActiva['_id'] == $m['_id']) ? 'border-orange-500 bg-orange-50/50' : 'border-transparent bg-slate-50/50 hover:bg-white hover:border-slate-200' }}">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 {{ (isset($mascotaActiva) && $mascotaActiva['_id'] == $m['_id']) ? 'bg-orange-500 text-white' : 'bg-white text-slate-400' }} shadow-sm">
                        <i class="fas fa-dog text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-base font-black text-slate-800 leading-tight">{{ $m['nombre'] }}</p>
                        <p class="text-[11px] font-bold text-slate-400 uppercase">{{ $m['especie'] ?? 'Perro' }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        @if(count($puntos) > 0)
        <div class="mx-6 mb-10 p-6 bg-[#231B6B] rounded-[35px] shadow-2xl relative">
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="bg-[#231B6B]/50 py-4 rounded-2xl border border-slate-800">
                    <p class="text-[9px] text-slate-500 uppercase font-black mb-1">Rutas</p>
                    <p class="text-2xl font-black text-white leading-none">{{ count($puntos) }}</p>
                </div>
                <div class="bg-[#231B6B]/50 py-4 rounded-2xl border border-slate-800">
                    <p class="text-[9px] text-slate-500 uppercase font-black mb-1">Status</p>
                    <p class="text-xs font-black text-green-400 uppercase">Conectado</p>
                </div>
            </div>
        </div>
        @endif
    </aside>

    <main class="absolute top-24 left-80 right-0 bg-[#f1f5f9] z-10" style="height: calc(100% - 150px);">
        <div id="map-historial" class="w-full h-full"></div>

        @if(count($puntos) == 0 && isset($mascotaActiva))
        <div class="absolute inset-0 flex items-center justify-center bg-[#231B6B]/10 backdrop-blur-md z-[1000]">
            <div class="bg-white p-10 rounded-[45px] shadow-2xl text-center border border-white max-w-sm">
                <div class="w-20 h-20 bg-orange-100 text-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner rotate-3">
                    <i class="fas fa-search-location text-3xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tighter">Sin datos históricos</h2>
                <p class="text-slate-500 text-sm mt-3 px-4">No encontramos registros para <strong>{{ $mascotaActiva['nombre'] }}</strong> en estas fechas.</p>
                <div class="mt-8">
                    <span class="text-[10px] font-black text-white bg-[#231B6B] px-5 py-2.5 rounded-2xl uppercase tracking-widest shadow-lg shadow-[#231B6B]/20">
                        Ajusta el buscador arriba
                    </span>
                </div>
            </div>
        </div>
        @endif
    </main>
</div>

<style>
    /* Estilos Premium */
    html, body { height: 100vh; overflow: hidden; margin: 0; padding: 0; }
    #map-historial { width: 100% !important; height: 100% !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    /* Efecto de mapa un poco más oscuro para que el header resalte */
    #map-historial { filter: grayscale(0.2) contrast(1.1); }
</style>



<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.polyline.snakeanim@0.2.0/L.Polyline.SnakeAnim.min.js"></script>

<script>
    try {
        window.onload = function() {
            // 1. Inicialización del mapa
            var map = L.map('map-historial', { zoomControl: false });

            // Capa de mapa estándar
           // Este es el mapa "Positron" (Gris claro muy elegante)
L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
    maxZoom: 20,
    attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

            L.control.zoom({ position: 'topright' }).addTo(map);

            // 2. Datos y Filtros
            const registrosRaw = @json($puntos) || [];
            const coordenadas = registrosRaw
                .filter(p => p && parseFloat(p.lat) !== 0 && parseFloat(p.lng) !== 0)
                .map(p => [parseFloat(p.lat), parseFloat(p.lng)])
                .reverse();

            // 3. Iconos Personalizados
            const startIcon = L.divIcon({
                html: '<div style="width:14px; height:14px; background:#1e293b; border:2px solid white; border-radius:50%; box-shadow: 0 0 5px rgba(0,0,0,0.3);"></div>',
                className: 'custom-icon', iconSize: [14, 14]
            });

            const endIcon = L.divIcon({
                html: '<div style="position:relative;"><div class="animate-ping" style="position:absolute; width:22px; height:22px; background:#fb923c; border-radius:50%; opacity:0.7; left:-4px; top:-4px;"></div><div style="position:relative; width:14px; height:14px; background:#ea580c; border:2px solid white; border-radius:50%; box-shadow: 0 0 5px rgba(0,0,0,0.3);"></div></div>',
                className: 'custom-icon', iconSize: [14, 14]
            });

            if (coordenadas.length > 0) {
                // Marcador de SALIDA (Primer punto)
                L.marker(coordenadas[0], { icon: startIcon }).addTo(map)
                 .bindPopup("<b>Inicio del recorrido</b>");

                if (coordenadas.length > 1) {
                    // Configurar línea
                    var polyline = L.polyline(coordenadas, {
                        color: '#f97316', 
                        weight: 6, 
                        snakingSpeed: 100 // Velocidad lenta
                    }).addTo(map);
                    
                    // Ajustar vista y animar
                    map.fitBounds(polyline.getBounds(), {padding: [60, 60]});
                    
                    if (typeof polyline.snakeIn === 'function') {
                        polyline.snakeIn();
                    }

                    // Marcador FINAL (Aparece al terminar la animación)
                    polyline.on('snakeend', function() {
                        L.marker(coordenadas[coordenadas.length - 1], { icon: endIcon })
                         .addTo(map)
                         .bindPopup("<b>Última ubicación registrada</b>")
                         .openPopup();
                    });
                } else {
                    // Si solo hay un punto
                    map.setView(coordenadas[0], 17);
                    L.marker(coordenadas[0], { icon: endIcon }).addTo(map).openPopup();
                }
            } else {
                // Sin puntos: Vista por defecto
                map.setView([20.6667, -103.3333], 12);
            }

            // Fix para el renderizado (Evita que se quede gris el mapa)
            setTimeout(() => { map.invalidateSize(); }, 600);
        };
    } catch (e) {
        console.error("Error en mapa:", e);
    }
</script>

<style>
    /* El contenedor con fondo gris suave para que no "parpadee" en blanco */
    #map-historial {
        height: 600px; 
        width: 100%; 
        
        border-radius: 12px;
    }

    .custom-icon { background: none !important; border: none !important; }
</style>

<style>
    .leaflet-top.leaflet-right {
    margin-top: 20px;
    margin-right: 20px;
}
    .custom-icon { background: none !important; border: none !important; }
</style>

<style>
    .custom-icon { background: none !important; border: none !important; }
    .leaflet-popup-content-wrapper { border-radius: 12px; font-weight: bold; }
</style>




<style>
    /* Estilo para que los iconos div no tengan fondo blanco ni bordes raros */
    .custom-div-icon {
        background: none !important;
        border: none !important;
    }
</style>

@endsection