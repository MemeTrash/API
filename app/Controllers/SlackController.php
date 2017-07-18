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
 * This is the slack controller class.
 *
 * @author Jack Romo <sharrackor@gmail.com>
 */
class SlackController extends Controller
{
    /**
     * Generate a cat meme.
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
     * Generate a fat meme.
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
     * Generate a doge meme.
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
     * Generate a meme.
     *
     * @param \App\Generators\GeneratorInterface $inner
     * @param string                             $text
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function generate(GeneratorInterface $inner, string $text)
    {
        $generator = new ValidatingGenerator($inner);
        $image = $generator->generate($text);
        $imageurl = "https://api.memetrash.co.uk/result/{$image}.jpg";

        return new JsonResponse([
            'text' => $imageurl,
        ]);
    }
}
