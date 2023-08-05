<?php

namespace App\Configuration;

use Auryn\InjectionException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestFactoryInterface;

class Psr17FactoryConfiguration implements ConfigurationInterface
{

    /**
     * @throws InjectionException
     */
    public function apply(Injector $injector)
    {
        $injector->alias(
            RequestFactoryInterface::class,
            Psr17Factory::class
        );
    }
}