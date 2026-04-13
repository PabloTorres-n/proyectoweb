<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atja'yaa'la App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { overflow-x: hidden; }
        /* El scrollbar personalizado para que no se vea feo */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Fondo decorativo con opacidad baja --}}
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-no-repeat opacity-[0.05] pointer-events-none">
    </div>

    {{-- Overlay corregido: añadimos pointer-events-none para que los clics pasen a través --}}
    <div class="fixed inset-0 z-1 bg-white/10 pointer-events-none"></div>

    {{-- Contenido Principal --}}
    <main class="relative z-10 p-6 mb-28 max-w-7xl mx-auto"> 
        @yield('content')
    </main>

    {{-- Navegación Inferior --}}
    <div class="fixed bottom-6 left-0 w-full flex justify-center z-[100] px-4">
        <nav class="bg-white/90 backdrop-blur-md shadow-2xl rounded-[30px] w-full max-w-md h-20 flex items-center justify-around px-2 border border-gray-100">
            
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 active:scale-90 
                    {{ request()->is('dashboard') ? 'bg-orange-500 shadow-orange-200 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">
                    <i class="fas fa-home text-2xl"></i>
                </div>
            </a>

            <a href="{{ route('mascotas.index') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 active:scale-90 
                    {{ request()->is('mascotas*') ? 'bg-orange-500 shadow-orange-200 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">
                    <i class="fas fa-paw text-2xl"></i>
                </div>
            </a>

            <a href="{{ route('perfil') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 active:scale-90 
                    {{ request()->is('perfil') ? 'bg-orange-500 shadow-orange-200 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">
                    <i class="fas fa-user text-2xl"></i>
                </div>
            </a>

            <a href="{{ route('configuracion') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 active:scale-90 
                    {{ request()->is('configuracion') ? 'bg-orange-500 shadow-orange-200 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">
                    <i class="fas fa-cog text-2xl"></i>
                </div>
            </a>
        </nav>
    </div>

</body>
</html>