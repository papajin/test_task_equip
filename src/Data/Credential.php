<?php

namespace App\Data;

use Equip\Data\EntityInterface;
use Equip\Data\Traits\EntityTrait;

class Credential implements EntityInterface
{
    use EntityTrait;

    private $clientId;
    private $clientSecret;
    private $refreshToken;
    private $accessKey;
    private $secretKey;


    private function types(): array
    {
        return [
            'clientId'     => 'string',
            'clientSecret' => 'string',
            'refreshToken' => 'string',
            'accessKey'    => 'string',
            'secretKey'    => 'string'
        ];
    }

    private function validate(): void
    {
        if( $this->clientId === null ) {
            throw new \DomainException( 'clientId is required' );
        }

        if( $this->clientSecret === null ) {
            throw new \DomainException( 'clientSecret is required' );
        }

        if( $this->refreshToken === null ) {
            throw new \DomainException( 'refreshToken is required' );
        }

        if( $this->accessKey === null ) {
            throw new \DomainException( 'accessKey is required' );
        }

        if( $this->secretKey === null ) {
            throw new \DomainException( 'secretKey is required' );
        }
    }

    public function asConfigurationArgsForIAMUser(): array
    {
        return [
            $this->clientId,
            $this->clientSecret,
            $this->accessKey,
            $this->secretKey
        ];
    }
}