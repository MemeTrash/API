<?php

declare(strict_types=1);

namespace App\Generators;

/**
 * This is the meme generator interface.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
interface GeneratorInterface
{
    /**
     * Start the meme generation.
     *
     * @param string $text
     *
     * @throws \App\Generators\ExceptionInterface
     *
     * @return \App\Generators\Promise
     */
    public function start(string $text);
}
