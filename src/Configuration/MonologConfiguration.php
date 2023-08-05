<?php

namespace App\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Env;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonologConfiguration implements ConfigurationInterface
{
	/**
     * @inheritDoc
     */
    public function apply(Injector $injector)
    {
        $injector->alias(
            LoggerInterface::class,
            Logger::class
        );

	    $injector->share(StreamHandler::class);

	    $injector->delegate( StreamHandler::class, function ( Env $env ) {
		    $log_file = $env->getValue('LogPath', ROOT_PATH . 'logs/') . date('Y/m/d') . '.log';

		    return new StreamHandler( (string) $log_file );
	    });

        $injector->delegate(Logger::class, function ( Env $env, StreamHandler $handler ) {
        	return new Logger( $env->getValue('LoggerName', 'equip'), [ $handler ]);
        });
    }
}
