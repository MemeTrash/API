<?php

declare(strict_types=1);

namespace App\Generators;

/**
 * This is the multi generator class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class MultiGenerator implements GeneratorInterface
{
    /**
     * The generator to wrap.
     *
     * @var \App\Generators\GeneratorInterface
     */
    protected $generator;

    /**
     * The number of generations.
     *
     * @var int
     */
    protected $times;

    /**
     * Create a new multi generator instance.
     *
     * @param \App\Generators\GeneratorInterface $generator
     * @param int                                $times
     *
     * @return void
     */
    public function __construct(GeneratorInterface $generator, int $times = 3)
    {
        $this->generator = $generator;
        $this->times = $times;
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
            $results = [];

            for ($i = 0; $i < $this->times; $i++) {
                $results[] = $this->generator->start($text);
            }

            $images = [];

            foreach ($results as $result) {
                $images = array_merge($images, $result->wait());
            }

            return $images;
        });
    }
}
