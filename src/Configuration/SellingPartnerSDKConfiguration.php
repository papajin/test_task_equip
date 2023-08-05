<?php

namespace App\Configuration;

use AmazonPHP\SellingPartner\Configuration;
use App\Classes\SellingPartner\SellingPartnerSDK;
use Auryn\ConfigException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

class SellingPartnerSDKConfiguration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     * @throws ConfigException
     */
    public function apply(Injector $injector)
    {
        $injector->share(SellingPartnerSDK::class);

        $injector->delegate(
            SellingPartnerSDK::class,
            function ( ClientInterface $client, Psr17Factory $factory, LoggerInterface $logger ) {
                $configuration = new Configuration( '', '', '', '' );
                return SellingPartnerSDK::create( $client, $factory, $factory, $configuration, $logger );
            }
        );
    }
}