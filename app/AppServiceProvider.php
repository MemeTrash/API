<?php

declare(strict_types=1);

namespace App;

use App\Generators\CatGenerator;
use App\Generators\DogeGenerator;
use App\Generators\FatGenerator;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

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
        $this->app->alias('bugsnag.logger', Log::class);
        $this->app->alias('bugsnag.logger', LoggerInterface::class);

        $this->registerGenerators();
        $this->registerRoutes();
    }

    /**
     * Register the generators.
     *
     * @return void
     */
    public function registerGenerators()
    {
        $this->app->singleton(CatGenerator::class, function (Container $app) {
            $path = $app->config->get('services.meme.cat');

            return new CatGenerator($path, $app->basePath('resources/img'), $app->basePath('public/result'));
        });

        $this->app->singleton(DogeGenerator::class, function (Container $app) {
            $client = GuzzleFactory::make(['base_uri' => $app->config->get('services.meme.doge')]);

            return new DogeGenerator($client, $app->basePath('public/result'));
        });

        $this->app->singleton(FatGenerator::class, function (Container $app) {
            $path = $app->config->get('services.meme.fat');

            return new FatGenerator($path, $app->basePath('resources/img'), $app->basePath('public/result'));
        });
    }

    /**
     * Register the routes.
     *
     * @return void
     */
    public function registerRoutes()
    {
        $this->app->get('/', 'App\Controllers\MainController@show');

        $this->app->post('cat', 'App\Controllers\MainController@cat');

        $this->app->post('fat', 'App\Controllers\MainController@fat');

        $this->app->post('doge', 'App\Controllers\MainController@doge');
    }
}
