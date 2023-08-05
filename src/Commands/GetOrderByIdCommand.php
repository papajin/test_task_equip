<?php

namespace App\Commands;


class GetOrderByIdCommand extends SellingPartnerCommand
{

    public function requiredOptions()
    {
        return [
            'region',
            'marketplaceId',
            'sellerOrderId'
        ];
    }

    /**
     * @return \AmazonPHP\SellingPartner\Model\Orders\Order
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $response = $this->sellingPartnerSDK->orders()->getOrders(
                $this->getAccessToken(),
                $this->options()[ 'region' ],
                $this->options()[ 'marketplaceId' ],
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $this->getOption( 'buyerEmail' ),
                $this->options()[ 'sellerOrderId' ]
            );
        } catch( \Exception $e ) {
            throw $e instanceof \RuntimeException
                ? $e
                : new \RuntimeException( $e->getMessage() );
        }

        if( empty( $response->getErrors() ) )
            return $response->getPayload()->getOrders()[0];

        // Handle errors (log might be good here)
        throw new \RuntimeException( $response->getErrors()[0]->getMessage() );
    }
}