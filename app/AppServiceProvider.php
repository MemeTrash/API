<?php

declare(strict_types=1);

namespace App;

use App\Generators\CatGenerator;
use App\Generators\DogeGenerator;
use App\Generators\FatGenerator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
            $path = $app->config->get('services.meme.cat');

            return new CatGenerator($path, $app->basePath('resources/img'), $app->basePath('public/result'));
        });

        $this->app->singleton(FatGenerator::class, function (Container $app) {
            $path = $app->config->get('services.meme.fat');

            return new FatGenerator($path, $app->basePath('resources/img'), $app->basePath('public/result'));
        });

        $this->app->singleton(DogeGenerator::class, function (Container $app) {
            $base = $app->config->get('services.meme.doge');

            $stack = HandlerStack::create();

            $stack->push(Middleware::retry(function ($retries, RequestInterface $request, ResponseInterface $response = null, TransferException $exception = null) {
                return $retries < 3 && ($exception instanceof ConnectException || ($response && $response->getStatusCode() >= 500));
            }, function ($retries) {
                return (int) pow(2, $retries) * 1000;
            }));

            $client = new Client(['base_uri' => $base, 'handler' => $stack, 'connect_timeout' => 10, 'timeout' => 15]);

            return new DogeGenerator($client, $app->basePath('public/result'));
        });

        $this->app->get('/', 'App\Controllers\MainController@show');

        $this->app->post('cat', 'App\Controllers\MainController@cat');

        $this->app->post('fat', 'App\Controllers\MainController@fat');

        $this->app->post('doge', 'App\Controllers\MainController@doge');
    }
}
