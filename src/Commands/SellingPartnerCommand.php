<?php

namespace App\Commands;

use AmazonPHP\SellingPartner\AccessToken;
use App\Classes\SellingPartner\SellingPartnerSDK;
use Equip\Command\AbstractCommand;

abstract class SellingPartnerCommand extends AbstractCommand
{
    use RetrievesOption;
    protected SellingPartnerSDK $sellingPartnerSDK;

    public function requiredOptions()
    {
        return [
            'accessToken',
        ];
    }

    public function __construct( SellingPartnerSDK $sellingPartnerSDK )
    {
        $this->sellingPartnerSDK = $sellingPartnerSDK;
    }

    protected function getAccessToken(): AccessToken
    {
        if( $this->options()['accessToken'] instanceof AccessToken )
            return  $this->options()['accessToken'];

        throw new \InvalidArgumentException( 'Invalid access token' );
    }
}