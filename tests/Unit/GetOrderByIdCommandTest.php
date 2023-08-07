<?php


use AmazonPHP\SellingPartner\Configuration;
use App\Classes\SellingPartner\Api\OrdersSDK;
use App\Classes\SellingPartner\SellingPartnerSDK;
use App\Data\Buyer;
use Buzz\Client\Curl;
use Monolog\Logger;
use Nyholm\Psr7\Factory\Psr17Factory;
use Tests\BaseTest;

class GetOrderByIdCommandTest extends BaseTest
{
    public function test_execute()
    {
        $ordersSDK = $this->createStub( OrdersSDK::class );
        $ordersSDK->method( 'getOrders' )
                  ->willReturn( $this->makeOrdersData() );

        $ordersSDK->expects( $this->once() )
                  ->method( 'getOrders' );

        $sdk = $this->createStub( SellingPartnerSDK::class );

        $sdk->method( 'orders' )
            ->willReturn( $ordersSDK );

        $order = (new \App\Commands\GetOrderByIdCommand( $sdk ))
                       ->withOptions( [
            'sellerOrderId' => '16400',
            'marketplaceId' => ['ATVPDKIKX0DER'],
            'region' => 'us-east-1',
            'accessToken' => new \AmazonPHP\SellingPartner\AccessToken('dfg', 'rgae','rgag', 0, 'sfsd'),
        ] )->execute();

        $this->assertInstanceOf( \AmazonPHP\SellingPartner\Model\Orders\Order::class, $order );
    }

    private function makeOrdersData()
    {
        return new \AmazonPHP\SellingPartner\Model\Orders\GetOrdersResponse( [
            'payload' => new \AmazonPHP\SellingPartner\Model\Orders\OrdersList([
                'orders' => [ new \AmazonPHP\SellingPartner\Model\Orders\Order([
                'AmazonOrderId' => '123-1234567-1234567',
                'SellerOrderId' => 16400,
                'PurchaseDate' => '2021-01-01T00:00:00+00:00',
                'LastUpdateDate' => '2021-01-01T00:00:00+00:00',
                'OrderStatus' => 'Unshipped',
                'FulfillmentChannel' => 'MFN',
                'SalesChannel' => 'Amazon.com',
                'OrderChannel' => 'Amazon.com',
                'ShipServiceLevel' => 'Standard',
                'ShippingAddress' => new \AmazonPHP\SellingPartner\Model\Orders\Address([
                    'Name' => 'John Doe',
                    'AddressLine1' => '123 Main St',
                    'City' => 'Seattle',
                    'StateOrRegion' => 'WA',
                    'PostalCode' => '98101-1234',
                    'CountryCode' => 'US',
                    'Phone' => '555-555-5555'
                ]),
                'OrderTotal' => new \AmazonPHP\SellingPartner\Model\Orders\Money([
                    'CurrencyCode' => 'USD',
                    'Amount' => 123.45
                ]),
                'NumberOfItemsShipped' => 0,
                'NumberOfItemsUnshipped' => 1,
                'PaymentExecutionDetail' => new \AmazonPHP\SellingPartner\Model\Orders\PaymentExecutionDetailItem([
                    'Payment' => new \AmazonPHP\SellingPartner\Model\Orders\Money([
                        'CurrencyCode' => 'USD',
                        'Amount' => 123.45
                    ]),
                    'PaymentMethod' => 'Other'
                ]),
                'PaymentMethod' => 'Other',
                'PaymentMethodDetails' => 'Standard',
                'MarketplaceId' => 'ATVPDKIKX0DER',
            ])]]),
            'errors' => [],
        ]);
    }
}