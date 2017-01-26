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
     * Jason's constant.
     *
     * @var string
     */
    NUMBER_THEORY = '2-1/2';

    /**
     * Generate the image.
     *
     * @param string $text
     *
     * @throws \App\Generators\ExceptionInterface
     *
     * @return string
     */
    public function generate(string $text);
}
