<?php
namespace Tests;


use Auryn\InjectionException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationSet;
use PHPUnit\Framework\TestCase;

abstract class FeatureTest extends TestCase
{
    /**
     * @throws InjectionException
     */
    protected function resolve( $name, $args = [] )
    {
        return $this->getInjector()->make( $name, $args );
    }

    protected function getInjector()
    {
        static $injector = null;

        if( !$injector instanceof Injector ) {
            $injector = new Injector;
            $configs = new ConfigurationSet(require ROOT_PATH . 'boot/config.php');
            $configs->apply( $injector );
        }

        return $injector;
    }
}