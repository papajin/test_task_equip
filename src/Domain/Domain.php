<?php

namespace App\Domain;

use Equip\Adr\PayloadInterface;
use Equip\Env;

abstract class Domain implements \Equip\Adr\DomainInterface
{

    protected PayloadInterface $payload;

    protected Env $env;


    /**
     * @param PayloadInterface $payload
     * @param Env              $env
     */
    public function __construct( PayloadInterface $payload, Env $env )
    {
        $this->payload = $payload;
        $this->env     = $env;
    }
}