<?php

namespace App\Configuration;

use Auryn\InjectionException;
use Auryn\Injector;
use Buzz\Client\Curl;
use Equip\Configuration\ConfigurationInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

class CurlConfiguration implements ConfigurationInterface
{

    /**
     * @throws InjectionException
     */
    public function apply(Injector $injector)
    {
        $injector->define(
            Curl::class,
            [ $injector->make( Psr17Factory::class ) ]
        );
    }
}