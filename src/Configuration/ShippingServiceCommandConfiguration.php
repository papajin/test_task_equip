<?php

namespace App\Configuration;

use App\Classes\SellingPartner\SellingPartnerSDK;
use App\Commands\ShippingServiceCommand;
use Auryn\ConfigException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;

class ShippingServiceCommandConfiguration implements ConfigurationInterface
{

    /**
     * @throws ConfigException
     */
    public function apply(Injector $injector)
    {
        $injector->delegate(
            ShippingServiceCommand::class,
            function ( SellingPartnerSDK $sdk ) {
                return new ShippingServiceCommand( $sdk );
            }
        );
    }
}