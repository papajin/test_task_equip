<?php

namespace App\Domain;

use Equip\Adr\PayloadInterface;
use Equip\Env;
use Psr\Log\LoggerInterface;

abstract class Domain implements \Equip\Adr\DomainInterface
{

    protected PayloadInterface $payload;

    protected Env $env;

    protected LoggerInterface $logger;


    /**
     * @param PayloadInterface $payload
     * @param Env              $env
     */
    public function __construct( PayloadInterface $payload, Env $env, LoggerInterface $logger )
    {
        $this->payload = $payload;
        $this->env     = $env;
        $this->logger  = $logger;
    }
}