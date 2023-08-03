<?php
/**
 * Created by PhpStorm.
 * User: Ihor
 * Date: 07.03.2018
 * Time: 10:50
 */

namespace App\Configuration;

use App\Data\Helper;
use Auryn\ConfigException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Env;
use League\Plates\Engine;

class PlatesConfiguration implements ConfigurationInterface {

    /**
     * @throws ConfigException
     */
    public function apply(Injector $injector)
	{
		$injector->delegate(Engine::class, function( Env $env ) {
            $v = $env->getValue( 'VIEWS' );
            $vPath = Helper::absPath( $env->getValue( 'VIEWS' ) );
			return ( new Engine( Helper::absPath( $env->getValue( 'VIEWS' ) ) ) )
				->loadExtension(new \League\Plates\Extension\Asset(ROOT_PATH . 'public' . DIRECTORY_SEPARATOR ));
		});
	}
}
