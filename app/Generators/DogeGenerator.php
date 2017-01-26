<?php

declare(strict_types=1);

namespace App\Generators;

use Symfony\Component\Process\Process;

/**
 * This is the doge meme generator class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DogeGenerator implements GeneratorInterface
{
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
     * @param string $generator
     * @param string $output
     *
     * @return void
     */
    public function __construct(string $generator, string $output)
    {
        $this->generator = $generator;
        $this->output = $output;
    }

    /**
     * Generate the image.
     *
     * @param string $text
     *
     * @throws \App\Generators\ExceptionInterface
     *
     * @return string
     */
    public function generate(string $text)
    {
        $name = str_random(16);

        $this->execute("python {$this->generator}/run.py \"{$text}\" \"{$this->output}/{$name}.jpg\" \"{$this->generator}/resources\" 6");

        return $name;
    }

    /**
     * Execute the given command.
     *
     * @param string $command
     *
     * @throws \App\Generators\GenerationException
     *
     * @return void
     */
    protected function execute(string $command)
    {
        $process = new Process($command);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new GenerationException($process->getOutput() ?: $process->getErrorOutput());
        }
    }
}
