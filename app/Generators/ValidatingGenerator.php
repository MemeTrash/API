<?php

declare(strict_types=1);

namespace App\Generators;

/**
 * This is the validating generator class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ValidatingGenerator implements GeneratorInterface
{
    /**
     * The generator to wrap.
     *
     * @var \App\Generators\GeneratorInterface
     */
    protected $generator;

    /**
     * Create a new validating generator instance.
     *
     * @param \App\Generators\GeneratorInterface $generator
     *
     * @return void
     */
    public function __construct(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Start the meme generation.
     *
     * @param string $text
     *
     * @throws \App\Generators\ExceptionInterface
     *
     * @return \App\Generators\Promise
     */
    public function start(string $text)
    {
        return new Promise(function () use ($text) {
            if (!$text) {
                throw new ValidationException('No meme text provided!');
            }

            if (preg_match('/^[a-z0-9 .\-]+$/i', $text) !== 1) {
                throw new ValidationException('Invalid meme text provided!');
            }

            if (strlen($text) > 128) {
                throw new ValidationException('Meme text too long!');
            }

            return $this->generator->start($text)->wait();
        });
    }
}
