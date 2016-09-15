<?php

declare(strict_types=1);

namespace App\Tests;

/**
 * This is the web test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class WebTest extends AbstractTestCase
{
    /**
     * Test the homepage works.
     *
     * @return void
     */
    public function testHome()
    {
        $this->get('/');

        $this->assertResponseOk();
    }
}
