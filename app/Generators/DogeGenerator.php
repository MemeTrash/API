<?php

declare(strict_types=1);

namespace App\Generators;

/**
 * This is the doge meme generator class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DogeGenerator implements GeneratorInterface
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
     * The output path.
     *
     * @var string
     */
    protected $output;

    /**
     * Create a new doge meme generator instance.
     *
     * @param \App\Generator\ProcessRunner $runner
     * @param string                       $generator
     * @param string                       $output
     *
     * @return void
     */
    public function __construct(ProcessRunner $runner, string $generator, string $output)
    {
        $this->runner = $runner;
        $this->generator = $generator;
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

        $command = "python {$this->generator}/run.py \"{$text}\" \"{$this->output}/{$name}.jpg\" \"{$this->generator}/resources\" 6";

        $process = $this->runner->start($command);

        return new Promise(function () use ($process, $name) {
            $process->wait();

            return [$name];
        });
    }
}
