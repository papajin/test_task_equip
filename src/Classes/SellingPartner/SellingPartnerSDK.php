<?php

declare(strict_types=1);

namespace App\Classes\SellingPartner;

use AmazonPHP\SellingPartner\HttpFactory;
use AmazonPHP\SellingPartner\VendorSDK;
use App\Classes\SellingPartner\Api\OrdersSDK;
use App\Classes\SellingPartner\Api\OrdersSDKInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use AmazonPHP\SellingPartner\Configuration;
use Psr\Log\LoggerInterface;

/**
 * @method \AmazonPHP\SellingPartner\OAuth oAuth()
 */
class SellingPartnerSDK
{
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private Configuration $configuration;
    private LoggerInterface $logger;
    private HttpFactory $httpFactory;
    private array $instances;

    private \AmazonPHP\SellingPartner\SellingPartnerSDK $parentSDK;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        Configuration $configuration,
        LoggerInterface $logger
    ) {
        $this->httpClient     = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory  = $streamFactory;
        $this->configuration  = $configuration;
        $this->logger         = $logger;
        $this->instances      = [];
        $this->httpFactory    = new HttpFactory($requestFactory, $streamFactory);

        $this->parentSDK      = \AmazonPHP\SellingPartner\SellingPartnerSDK::create(
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory,
            $this->configuration,
            $this->logger
        );
    }

    public static function create(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        Configuration $configuration,
        LoggerInterface $logger
    ) : self {
        return new self($httpClient, $requestFactory, $streamFactory, $configuration, $logger);
    }

    public function orders() : OrdersSDKInterface
    {
        return $this->instantiateSDK( OrdersSDK::class );
    }

    public function withConfiguration( Configuration $configuration ) : self
    {
        return new self(
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory,
            $configuration,
            $this->logger
        );
    }

    public function __call($name, $arguments)
    {
        return $this->parentSDK->$name(...$arguments);
    }

    /**
     * @template T
     *
     * @param  string  $sdkClass
     *
     * @return T
     */
    private function instantiateSDK(string $sdkClass)
    {
        if (isset($this->instances[$sdkClass])) {
            return $this->instances[$sdkClass];
        }

        $this->instances[$sdkClass] = ($sdkClass === VendorSDK::class)
            ? VendorSDK::create(
                $this->httpClient,
                $this->requestFactory,
                $this->streamFactory,
                $this->configuration,
                $this->logger
            )
            : new $sdkClass(
                $this->httpClient,
                $this->httpFactory,
                $this->configuration,
                $this->logger
            );

        return $this->instances[$sdkClass];
    }
}