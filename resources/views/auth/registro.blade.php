<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - PetTracker GPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: radial-gradient(circle at top right, #eef2ff, #ffffff);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="flex justify-center mb-6">
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center">
                <img src="{{ asset('imagenes/splash.png') }}" alt="PetTracker Logo" class="h-16 w-auto">
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-md p-8 rounded-3xl shadow-2xl border-2 border-[#e65100] w-full relative">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase"></h2>
                <p class="text-slate-500 text-sm mt-1">Crea tu cuenta para cuidar a tu mascota</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-3 mb-6 rounded-r-lg">
                    <p class="text-red-700 text-xs font-medium">{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('registro.post') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 ml-1">Nombre Completo</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 group-focus-within:text-[#e65100] transition-colors">
                            <i class="fas fa-user text-sm"></i>
                        </span>
                        <input type="text" name="name" required 
                            class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#e65100]/20 focus:border-[#e65100] outline-none transition-all text-slate-700"
                            placeholder="Ej. Alex Marín">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 ml-1">Correo Electrónico</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 group-focus-within:text-[#e65100] transition-colors">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" required 
                            class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#e65100]/20 focus:border-[#e65100] outline-none transition-all text-slate-700"
                            placeholder="correo@ejemplo.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 ml-1">Contraseña</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 group-focus-within:text-[#e65100] transition-colors">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password" required 
                            class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#e65100]/20 focus:border-[#e65100] outline-none transition-all text-slate-700"
                            placeholder="Mínimo 8 caracteres">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-[#0a112c] hover:bg-[#e65100] text-white font-extrabold py-4 rounded-xl shadow-xl transition-all transform active:scale-[0.97] flex items-center justify-center uppercase tracking-wider text-sm">
                        REGISTRARSE - EMPIEZA A RASTREAR
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-600 font-medium uppercase">
                    ¿Ya tienes una cuenta? 
                    <a href="#" class="text-[#0a112c] font-bold hover:text-[#e65100] transition-colors">INICIA SESIÓN</a>
                </p>
            </div>
        </div>
        
        <p class="text-center text-slate-400 text-xs mt-8">
            &copy; 2026 PetTracker Systems. Todos los derechos reservados.
        </p>
    </div>

</body>
</html>