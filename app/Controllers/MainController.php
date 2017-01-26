<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Generators\CatGenerator;
use App\Generators\DogeGenerator;
use App\Generators\GeneratorInterface;
use App\Generators\ValidatingGenerator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

/**
 * This is the main controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
        $quantity = $request->get('quantity', 1);

        return $this->generate($inner, (string) $text, (int) $quantity);
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
        $quantity = $request->get('quantity', 1);

        return $this->generate($inner, (string) $text, (int) $quantity);
    }

    /**
     * Generate the memes.
     *
     * @param \App\Generators\GeneratorInterface $inner
     * @param string                             $text
     * @param int                                $quantity
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generate(GeneratorInterface $inner, string $text, int $quantity = 1)
    {
        $generator = new ValidatingGenerator($inner);

        $images = [];

        for ($i = 0; $i < $quantity; $i++) {
            $image = $generator->generate($text);
            $images[] = "https://api.memetrash.co.uk/result/{$image}.jpg";
        }

        $response = new JsonResponse([
            'success' => ['message' => 'Here are your memes!'],
            'data'    => ['images' => $images],
        ]);

        return $response;
    }
}
