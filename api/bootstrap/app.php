<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__ . "/../routes/web.php", api: __DIR__ . "/../routes/api.php", commands: __DIR__ . "/../routes/console.php", health: "/up")
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->api(
            append: [\App\Http\Middleware\CheckDisabled::class, \App\Http\Middleware\TeamsPermission::class, \App\Http\Middleware\ForceJsonReponse::class]
        );
        $middleware->alias([
            "role" => \Spatie\Permission\Middleware\RoleMiddleware::class,
            "permission" => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            "role_or_permission" => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            "isActive" => \App\Http\Middleware\CheckDisabled::class,
            "SPAOnly" => \App\Http\Middleware\SPAOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
