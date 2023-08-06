<?php

namespace App\Configuration;

use App\Classes\SellingPartner\SellingPartnerSDK;
use App\Commands\GetOrderByIdCommand;
use Auryn\ConfigException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;

class GetOrderByIdCommandConfiguration implements ConfigurationInterface
{

    /**
     * @throws ConfigException
     */
    public function apply(Injector $injector)
    {
        $injector->delegate(
            GetOrderByIdCommand::class,
            function ( SellingPartnerSDK $sdk ) {
                return new GetOrderByIdCommand( $sdk );
            }
        );
    }
}