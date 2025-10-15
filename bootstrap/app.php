<?php

use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Http;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(AuthAdmin::class);
        $middleware->alias([
            'Role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (Throwable $e) {
            try {
                $message = "🚨 *Gatherly Error Alert*\n"
                    . "*Message:* " . $e->getMessage() . "\n"
                    . "*File:* `" . $e->getFile() . "`\n"
                    . "*Line:* `" . $e->getLine() . "`\n\n"
                    . "*Stack Trace:*\n"
                    . "```\n" . substr($e->getTraceAsString(), 0, 3500) . "\n```";


                Http::withoutVerifying()->post(
                    'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage',
                    [
                        'chat_id' => env('TELEGRAM_CHAT_ID'),
                        'text' => $message,
                        'parse_mode' => 'Markdown',
                    ]
                );
            } catch (\Exception $ex) {
                error_log('Telegram error notifier failed: ' . $ex->getMessage());
            }
        });
    })->create();
