<?php

declare(strict_types=1);

namespace App\Generators;

use Symfony\Component\Process\Process;

/**
 * This is the process runner class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ProcessRunner
{
    /**
     * Start the process.
     *
     * @return App\Generators\Promise
     */
    public function start(string $command)
    {
        $process = new Process($command);

        $process->start();

        return new Promise(function () use ($process) {
            $process->wait();

            if (!$process->isSuccessful()) {
                throw new GenerationException($process->getOutput() ?: $process->getErrorOutput());
            }
        });
    }
}
