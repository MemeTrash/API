<?php

declare(strict_types=1);

namespace App\Tests;

use App\AppServiceProvider;
use App\Generators\CatGenerator;
use App\Generators\DogeGenerator;
use App\Generators\FatGenerator;
use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use LaravelTrait, ServiceProviderTrait;

    protected function getServiceProviderClass($app)
    {
        return AppServiceProvider::class;
    }

    public function testFatGeneratorIsInjectable()
    {
        $this->assertIsInjectable(FatGenerator::class);
    }

    public function testDogeGeneratorIsInjectable()
    {
        $this->assertIsInjectable(DogeGenerator::class);
    }
}
