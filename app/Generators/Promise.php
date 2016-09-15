<?php

declare(strict_types=1);

namespace App\Generators;

/**
 * This is the promise class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Promise
{
    /**
     * The generation callback.
     *
     * @var callback
     */
    protected $callback;

    /**
     * Create a new promise instance.
     *
     * @param callable $callback
     *
     * @return void
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Wait for result to become available.
     *
     * @throws \App\Generators\ExceptionInterface
     *
     * @return mixed
     */
    public function wait()
    {
        $fn = $this->callback;

        return $fn();
    }
}
