<?php

declare(strict_types=1);

namespace App\Generators;

/**
 * This is the cat meme generator class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CatGenerator implements GeneratorInterface
{
    /**
     * The runner instance.
     *
     * @var \App\Generator\ProcessRunner
     */
    protected $runner;

    /**
     * The generator path.
     *
     * @var string
     */
    protected $generator;

    /**
     * The resources path.
     *
     * @var string
     */
    protected $resources;

    /**
     * The output path.
     *
     * @var string
     */
    protected $output;

    /**
     * Create a new cat meme generator instance.
     *
     * @param \App\Generator\ProcessRunner $runner
     * @param string                       $generator
     * @param string                       $resources
     * @param string                       $output
     *
     * @return void
     */
    public function __construct(ProcessRunner $runner, string $generator, string $resources, string $output)
    {
        $this->runner = $runner;
        $this->generator = $generator;
        $this->resources = $resources;
        $this->output = $output;
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
        $name = str_random(16);
        $image = random_int(1, 70);

        $command = "python {$this->generator}/run.py \"{$this->resources}/{$image}.jpg\" \"{$this->output}/{$name}.jpg\" \"{$this->generator}/resources\" \"{$text}\"";

        $process = $this->runner->start($command);

        return new Promise(function () use ($process, $name) {
            $process->wait();

            return [$name];
        });
    }
}
