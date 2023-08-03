<?php

namespace App\Data;

use App\Contracts\BuyerInterface;
use Equip\Data\Traits\EntityTrait;

class Buyer implements BuyerInterface
{
    use EntityTrait, ArrayAccess;

    private $id;
    private $country_id;
    private $country_code;
    private $country_code3;
    private $shop_username;
    private $email;
    private $phone;
    private $address;
    private $data;

    private function types(): array
    {
        return [
            'id'            => 'int',
            'country_id'    => 'int',
            'country_code'  => 'string',
            'shop_username' => 'string',
            'email'         => 'string',
            'phone'         => 'string',
            'address'       => 'string',
            'data'          => 'array',
        ];
    }
}