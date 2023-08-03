<?php

namespace App\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;
use Equip\Env;

class Api implements DomainInterface
{

    protected PayloadInterface $payload;

    protected Env $env;
    public function __invoke(array $input)
    {
        // TODO: Implement __invoke() method.
    }
}