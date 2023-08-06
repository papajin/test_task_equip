<?php

namespace App\Commands;


use AmazonPHP\SellingPartner\Exception\ApiException;
use AmazonPHP\SellingPartner\Exception\InvalidArgumentException;
use App\Classes\SellingPartner\Model\Orders\ConfirmShipmentRequest;
use App\Contracts\BuyerInterface;
use App\Contracts\ShippingServiceInterface;
use App\Data\AbstractOrder;
use function Equip\Arr\get;

class ShippingServiceCommand extends SellingPartnerCommand implements ShippingServiceInterface
{
    public function requiredOptions()
    {
        return array_merge(
            [ 'payload', 'order', 'buyer' ],
            parent::requiredOptions()
        );
    }

    /**
     * @throws ApiException
     * @throws InvalidArgumentException
     */
    public function execute()
    {
        return $this->sellingPartnerSDK->orders()
                                       ->confirmShipment(
                                           $this->getAccessToken(),
                                           $this->options()[ 'region' ],
                                           $this->getAmazonOrderId(),
                                           $this->options()[ 'payload' ]
                                       );
    }

    /**
     * @throws \RuntimeException
     */
    public function ship(AbstractOrder $order, BuyerInterface $buyer): string
    {
        /**
         * This is to comply with the interface contract.
         * Remove try-catching if you don't mean to convert all exceptions to RuntimeException.
         */
        try {
            $this->addOptions([
                'order' => $order,
                'buyer' => $buyer,
            ])
                 ->execute();
        } catch( \Exception $e ) {
            throw $e instanceof \RuntimeException
                ? $e
                : new \RuntimeException( $e->getMessage() );
        }

        return $this->extractTrackingNumberFromPayload();
    }

    private function getAmazonOrderId(): string
    {
        if(
            $this->options()['order'] instanceof AbstractOrder
            AND $id = get( (array) $this->options()[ 'order' ]->data, 'amazon_order_id' )
        ) {
            return $id;
        }

        throw new \InvalidArgumentException( 'Amazon Order Id is missing.' );
    }

    private function getPayload(): ConfirmShipmentRequest
    {
        if( $this->options()['payload'] instanceof ConfirmShipmentRequest )
            return $this->options()['payload'];

        throw new \InvalidArgumentException( 'Payload is required and must be an instance of ConfirmShipmentRequest' );
    }

    private function extractTrackingNumberFromPayload()
    {
        return $this->options()[ 'payload' ]->getPackageDetails()[ 'trackingNumber' ] ?? '';
    }
}