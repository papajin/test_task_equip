<?php

namespace App\Commands;

use App\Contracts\BuyerInterface;
use App\Contracts\ShippingServiceInterface;
use App\Data\AbstractOrder;
use Equip\Command\AbstractCommand;

class ShippingServiceCommand extends AbstractCommand implements ShippingServiceInterface
{
    public function __construct()
    {
        //TODO: Implement __construct() method or delete.
    }

    public function requiredOptions()
    {
        return [
            'order',
            'buyer',
        ];
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        return $this->getOrder()
                    ->withGetFulfillmentOrderCommand( $this->getFulfillmentOrderCommand() );
    }

    public function ship(AbstractOrder $order, BuyerInterface $buyer): string
    {
        $result = $this->addOptions([
            'order' => $order,
            'buyer' => $buyer,
        ])
                       ->execute();

        return static::extractTrackingNumber( $result );
    }

    public static function extractTrackingNumber( $result )
    {
        return $result->getTrackingNumber();
    }
}