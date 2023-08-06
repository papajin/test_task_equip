<?php

namespace App\Domain;


use AmazonPHP\SellingPartner\Configuration;
use AmazonPHP\SellingPartner\Exception\ApiException;
use AmazonPHP\SellingPartner\Marketplace;
use AmazonPHP\SellingPartner\Regions;
use App\Classes\SellingPartner\Model\Orders\ConfirmShipmentOrderItem;
use App\Classes\SellingPartner\Model\Orders\ConfirmShipmentRequest;
use App\Classes\SellingPartner\Model\Orders\PackageDetail;
use App\Classes\SellingPartner\SellingPartnerSDK;
use App\Commands\GetOrderByIdCommand;
use App\Commands\ShippingServiceCommand;
use App\Data\AmazonOrder;
use App\Data\Buyer;
use App\Data\Credential;
use App\Data\Order;
use App\Data\Product;
use Equip\Adr\PayloadInterface;
use Equip\Adr\Status;
use Equip\Env;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Log\LoggerInterface;
use function Equip\Arr\get;
use function Equip\Arr\exists;
use function Equip\Arr\some;

class Api extends Domain
{
    private GetOrderByIdCommand $getOrderByIdCommand;

    private ShippingServiceCommand $shippingServiceCommand;

    private SellingPartnerSDK $sellingPartnerSDK;

    public function __construct(
        PayloadInterface $payload,
        Env $env,
        LoggerInterface $logger,
        GetOrderByIdCommand $getOrderByIdCommand,
        ShippingServiceCommand $shippingServiceCommand,
        SellingPartnerSDK $sellingPartnerSDK
    )
    {
        parent::__construct( $payload, $env, $logger );

        $this->getOrderByIdCommand    = $getOrderByIdCommand;
        $this->shippingServiceCommand = $shippingServiceCommand;
        $this->sellingPartnerSDK      = $sellingPartnerSDK;
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function __invoke(array $input)
    {
        try {
            $this->setCredentials( $input );

            $order = $this->buildOrder( $input );

            $amazonOrder = $this->buildAmazonOrder( $input, $order );

            $this->shippingServiceCommand = $this->shippingServiceCommand->withOptions([
                'accessToken' => $this->getAccessToken($input['refreshToken']),
                'region'      => $this->getRegion( $input ),
                'payload'     => $this->getPayload( $input )
            ]);

            $status = Status::STATUS_OK;
            $output = [
                'trackingNumber' => $this->shippingServiceCommand->ship(
                    $amazonOrder,
                    $this->getBuyer( $input )
                ),
            ];
        } catch (\Throwable $e) {
            $status = Status::STATUS_BAD_REQUEST;
            $output = [
                'message' => $e->getMessage(),
            ];
        }

        return $this->payload
            ->withStatus( $status )
            ->withOutput( $output );
    }

    private function setCredentials( array $input )
    {
        $credentials = new Credential( $input );

        $configuration = Configuration::forIAMUser( ... $credentials->asConfigurationArgsForIAMUser() );

        if( strcasecmp('production', $this->env->getValue( 'ENVIRONMENT', 'development' ) ) )
            $configuration->setSandbox();

        $this->sellingPartnerSDK->withConfiguration( $configuration );
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    private function getAccessToken( string $refreshToken ): \AmazonPHP\SellingPartner\AccessToken
    {
        return $this->sellingPartnerSDK->oAuth()->exchangeRefreshToken( $refreshToken );
    }

    /**
     * Obtaining the buyer from DB or other source to be implemented if needed.
     * We use POSTed data for demo’s sake.
     */
    private function getBuyer( array $input ): Buyer
    {
        return new Buyer( $input );
    }

    /**
     * Obtaining the order from DB or other source to be implemented if needed.
     * We use POSTed data for demo’s sake.
     */
    private function buildOrder( $input ): Order
    {
        $products = [];

        if( exists( $input, 'products' ) )
        {
            foreach( get( $input, 'products' ) as $product )
            {
                $products[] = new Product( $product );
            }
        }

        return new Order( array_merge( $input, [ 'products' => $products ] ) );
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    private function buildAmazonOrder( array $input, Order $order ): AmazonOrder
    {
        $amazonOrder = new AmazonOrder( $order->order_id );

        return $amazonOrder->withRetrieveOrderCommand(
            $this->getOrderByIdCommand->withOptions([
                'accessToken'   => $this->getAccessToken($input['refreshToken']),
                'region'        => $this->getRegion( $input ),
                'marketplaceId' => $this->getMarketPlaceIds( $input ),
                'sellerOrderId' => $order->order_id,
            ])
        );
    }

    private function getRegion( $input )
    {
        return get( $input, 'region', Regions::NORTH_AMERICA );
    }

    private function getMarketPlaceIds( array $input ): array
    {
        $inputVal = get( $input, 'marketplaceIds', [ Marketplace::US()->id() ] );

        return is_array($inputVal )
            ? $inputVal
            : explode( ',', $inputVal );
    }

    private function getPayload(array $input): ConfirmShipmentRequest
    {
        if( get( $input, 'no_payload' ) )
            return new ConfirmShipmentRequest([]);

        $args = some(
            $input,
            [
                'package_reference_id', 'carrier_code', 'carrier_name', 'shipping_method',
                'tracking_number', 'ship_date', 'ship_from_supply_source_id'
            ]
        );

        $items = get( $input, 'order_items', [] );

        if( count( $items ) ) {
            $args['order_items'] = [];

             foreach ( $items as $item )
                 $args['order_items'][] = new ConfirmShipmentOrderItem( $item );
        }

        return new ConfirmShipmentRequest([
                'package_detail'        => new PackageDetail( $args ),
                'marketplace_id'        => $this->getMarketPlaceIds($input)[0],
                'cod_collection_method' => get($input, 'codCollectionMethod'),
            ]);
    }
}