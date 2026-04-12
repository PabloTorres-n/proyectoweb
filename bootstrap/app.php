<?php
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
    if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // 2. Confiar en Proxies (Para que Railway no de errores de seguridad)
        $middleware->trustProxies(at: '*');
         $middleware->alias([
            'auth.token' => \App\Http\Middleware\CheckSersionToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
