<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TeamsPermission;

use App\Http\Middleware\CheckDisabled;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__ . "/../routes/web.php", api: __DIR__ . "/../routes/api.php", commands: __DIR__ . "/../routes/console.php", health: "/up")
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->append(CheckDisabled::class);
        $middleware->append(TeamsPermission::class);
        $middleware->alias([
            "teams" => \App\Http\Middleware\TeamsPermission::class,
            "isActive" => \App\Http\Middleware\CheckDisabled::class,
            "SPAOnly" => \App\Http\Middleware\SPAOnly::class,

            "role" => \Spatie\Permission\Middleware\RoleMiddleware::class,
            "permission" => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            "role_or_permission" => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
