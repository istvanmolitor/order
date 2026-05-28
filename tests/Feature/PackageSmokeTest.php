<?php

namespace Molitor\Order\Tests\Feature;

use Molitor\Order\Providers\OrderServiceProvider;
use Tests\TestCase;

class PackageSmokeTest extends TestCase
{
    public function test_service_provider_is_loaded(): void
    {
        $this->assertTrue(class_exists(OrderServiceProvider::class));
        $this->assertTrue($this->app->providerIsLoaded(OrderServiceProvider::class));
    }
}

