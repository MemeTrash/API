<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Laravel\Lumen\Application(realpath(__DIR__.'/../'));

$app->configure('database');
$app->configure('services');

$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, GrahamCampbell\Exceptions\LumenExceptionHandler::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, App\Kernel::class);

$app->register(Bugsnag\BugsnagLaravel\BugsnagServiceProvider::class);
$app->register(GrahamCampbell\Exceptions\ExceptionsServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);
$app->register(Laravel\Tinker\TinkerServiceProvider::class);

$app->register(App\AppServiceProvider::class);

$app->middleware([App\Middleware\GlobalRateLimiter::class]);

return $app;
