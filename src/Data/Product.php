<?php

namespace App\Data;

use Equip\Data\EntityInterface;
use Equip\Data\Traits\EntityTrait;

class Product implements EntityInterface
{
    use EntityTrait;

    private $order_product_id;
    private $site_client_id;
    private $order_id;
    private $product_id;
    private $external;
    private $title;
    private $payment_id;
    private $product_code;
    private $buying_price;
    private $original_price;
    private $ammount;
    private $comment;
    private $listing_id;
    private $stock_action_status;
    private $stock_action_code;
    private $lang_id;
    private $update_date;
    private $sku;

    private function types(): array
    {
        return [
            'order_product_id'    => 'int',
            'site_client_id'      => 'int',
            'order_id'            => 'int',
            'product_id'          => 'int',
            'external'            => 'string',
            'title'               => 'string',
            'payment_id'          => 'string',
            'product_code'        => 'string',
            'buying_price'        => 'string',
            'original_price'      => 'string',
            'ammount'             => 'float',
            'comment'             => 'string',
            'listing_id'          => 'int',
            'stock_action_status' => 'int',
            'stock_action_code'   => 'string',
            'lang_id'             => 'int',
            'update_date'         => 'string',
            'sku'                 => 'string',
        ];
    }
}