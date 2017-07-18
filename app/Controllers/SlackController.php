<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Generators\CatGenerator;
use App\Generators\DogeGenerator;
use App\Generators\FatGenerator;
use App\Generators\GeneratorInterface;
use App\Generators\ValidatingGenerator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

/**
 * This is the controller class for slack.
 *
 * @author Jack Romo <sharrackor@gmail.com>
 */
class MainController extends Controller
{
    /**
     * Show the welcome message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $response = new JsonResponse([
            'meta' => ['message' => 'Very image. Much server.'],
        ]);

        return $response;
    }

    /**
     * Generate cat memes.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Http\Request                  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cat(Container $container, Request $request)
    {
        $inner = $container->make(CatGenerator::class);
        $text = $request->get('text');

        return $this->generate($inner, (string) $text);
    }

    /**
     * Generate fat memes.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Http\Request                  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fat(Container $container, Request $request)
    {
        $inner = $container->make(FatGenerator::class);
        $text = $request->get('text');

        return $this->generate($inner, (string) $text);
    }

    /**
     * Generate doge memes.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Http\Request                  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function doge(Container $container, Request $request)
    {
        $inner = $container->make(DogeGenerator::class);
        $text = $request->get('text');

        return $this->generate($inner, (string) $text);
    }

    /**
     * Generate the memes.
     *
     * @param \App\Generators\GeneratorInterface $inner
     * @param string                             $text
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generate(GeneratorInterface $inner, string $text)
    {
        $generator = new ValidatingGenerator($inner);

        $response = new JsonResponse([
            'text' => $generator->generate($text),
        ]);

        return $response;
    }
}
