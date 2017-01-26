<?php

declare(strict_types=1);

namespace App;

use App\Generators\CatGenerator;
use App\Generators\DogeGenerator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

/**
 * This is the app service provider.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CatGenerator::class, function (Container $app) {
            return new CatGenerator(
                $app->config->get('services.meme.cat'),
                $app->basePath('resources/img'),
                $app->basePath('public/result')
            );
        });

        $this->app->singleton(DogeGenerator::class, function (Container $app) {
            return new DogeGenerator(
                $app->config->get('services.meme.doge'),
                $app->basePath('public/result')
            );
        });

        $this->app->get('/', 'App\Controllers\MainController@show');

        $this->app->post('cat', 'App\Controllers\MainController@cat');

        $this->app->post('doge', 'App\Controllers\MainController@doge');
    }
}
