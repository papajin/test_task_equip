<?php

namespace App\Data;


use AmazonPHP\SellingPartner\ObjectSerializer;
use App\Commands\GetOrderByIdCommand;

class AmazonOrder extends AbstractOrder
{
    private ?GetOrderByIdCommand $retrieveOrderCommand;

    /**
     * @throws \Exception
     */
    protected function loadOrderData(int $id): array
    {
        /**
         * Not sure why this method is here. The class should not be responsible for retrieving the data.
         * I leave it just to comply with the interface.
         */
        ! empty( $this->data )
        OR ( $this->retrieveOrderCommand
             AND $this->data = ObjectSerializer::sanitizeForSerialization( $this->retrieveOrderCommand->execute() ) );

        return $this->data;
    }

    public function withData( array $data ): AmazonOrder
    {
        $copy = clone $this;
        $copy->data = $data;

        return $copy;
    }

    public function withRetrieveOrderCommand( GetOrderByIdCommand $retrieveOrderCommand ): AmazonOrder
    {
        $copy = clone $this;
        $copy->retrieveOrderCommand = $retrieveOrderCommand;

        return $copy;
    }

    public function __get( $name )
    {
        return $this->data[ $name ] ?? null;
    }

}