<?php

namespace App\Configuration;

use Auryn\InjectionException;
use Auryn\Injector;
use Buzz\Client\Curl;
use Equip\Configuration\ConfigurationInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;

class CurlConfiguration implements ConfigurationInterface
{

    /**
     * @throws InjectionException
     */
    public function apply(Injector $injector)
    {
        $injector->alias(
            ClientInterface::class,
            Curl::class
        );

        $injector->define(
            Curl::class,
            [ $injector->make( Psr17Factory::class ) ]
        );
    }
}