<?php
/**
 * Created by PhpStorm.
 * User: Ihor
 * Date: 24.03.2018
 * Time: 10:39
 */

namespace App\Configuration;

use Auryn\ConfigException;
use Auryn\InjectionException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use App\Data\Env;
use josegonzalez\Dotenv\Loader;

class EnvConfiguration implements ConfigurationInterface
{
	/**
	 * @inheritDoc
     * @throws ConfigException|InjectionException
     */
	public function apply(Injector $injector)
	{
		$injector->share( Env::class );

		$injector->prepare(Env::class, function ( Env $env ) {
			$values = Loader::load([
//				'filepath' => ROOT_PATH . '.env',
				'filters'  => [ 'josegonzalez\Dotenv\Filter\UnderscoreArrayFilter' ]
			])->toArray();

			return $env->withValues( $values );
		});
	}
}