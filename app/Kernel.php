<?php

declare(strict_types=1);

namespace App;

use Bugsnag\BugsnagLaravel\Commands\DeployCommand;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

/**
 * This is the app console kernel.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Kernel extends ConsoleKernel
{
    /**
     * The commands to register.
     *
     * @var string[]
     */
    protected $commands = [DeployCommand::class];
}
