<?php

namespace App\Classes\SellingPartner\Api;


use AmazonPHP\SellingPartner\AccessToken;
use AmazonPHP\SellingPartner\Exception\ApiException;
use AmazonPHP\SellingPartner\Exception\InvalidArgumentException;

interface OrdersSDKInterface
{
    public const OPERATION_CONFIRMSHIPMENT = 'confirmShipment';

    public const OPERATION_CONFIRMSHIPMENT_PATH = '/orders/v0/orders/{orderId}/shipmentConfirmation';

    /**
     * Operation confirmShipment.
     *
     * @param string $order_id An Amazon-defined order identifier, in 3-7-7 format. (required)
     * @param \App\Classes\SellingPartner\Model\Orders\ConfirmShipmentRequest $payload Request body of confirmShipment. (required)
     *
     * @throws ApiException on non-2xx response
     * @throws InvalidArgumentException
     */
    public function confirmShipment(AccessToken $accessToken, string $region, string $order_id, \App\Classes\SellingPartner\Model\Orders\ConfirmShipmentRequest $payload);

}