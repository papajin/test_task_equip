<?php

namespace Tests;


use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Request;

trait MakesHttpRequests
{
    protected array $defaultHeaders = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    protected function call( string $method, string $uri, $body = '', array $headers = [] ): ResponseInterface
    {
        $body = is_array( $body ) ? json_encode( $body ) : $body;

        $request = new Request(
            $this->url( $uri ),
            $method,
            fopen('data://text/plain,' . $body,'r'),
            array_merge( $this->defaultHeaders, $headers )
        );

        return $this->resolve( ClientInterface::class )
                    ->sendRequest( $request );
    }

    protected function get( string $uri, $body = '', array $headers = [] ): ResponseInterface
    {
        return $this->call( 'GET', $uri, $body, $headers );
    }

    protected function post( string $uri, $body = '', array $headers = [] ): ResponseInterface
    {
        return $this->call( 'POST', $uri, $body, $headers );
    }

    private function url( string $uri ): string
    {
        return str_starts_with(  $uri, 'http' )
            ? $uri
            : $this->resolve( \Equip\Env::class )->getValue( 'URL' ) . '/' . ltrim(  $uri, '/' );
    }
}