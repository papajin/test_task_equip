<?php

namespace App\Data;

use Equip\Data\EntityInterface;
use Equip\Data\Traits\EntityTrait;

class Order implements EntityInterface
{
    use EntityTrait;

    private $id;
    private $order_id;
    private $order_unique;
    private $site_client_id;
    private $account_id;
    private $client_id;
    private $currency;
    private $store_name;
    private $tracking_number;
    private $shipping_adress;
    private $shipping_city;
    private $shipping_state;
    private $shipping_zip;
    private $shipping_country;
    private $shipping_street;
    private $lang_id;
    private $order_date;
    private $due_date;
    private $discount_rate;
    private $discount_sum;
    private $shipping_type_id;
    private $shipping_price;
    private $shiping_name;
    private $final_price;
    private $status;
    private $hide_recieved;
    private $comments;
    private $recipients;
    private $update_date;
    private $archived;
    private $data;
    private $buyer_name;
    private $shop_username;
    private $calculated_price;
    private $products;

    private function types(): array
    {
        return [
            'id'                => 'int',
            'order_id'          => 'int',
            'order_unique'      => 'string',
            'site_client_id'    => 'int',
            'account_id'        => 'int',
            'client_id'         => 'int',
            'currency'          => 'string',
            'store_name'        => 'string',
            'tracking_number'   => 'string',
            'shipping_adress'   => 'string',
            'shipping_city'     => 'string',
            'shipping_state'    => 'string',
            'shipping_zip'      => 'string',
            'shipping_country'  => 'string',
            'shipping_street'   => 'string',
            'lang_id'           => 'int',
            'order_date'        => 'string',
            'due_date'          => 'string',
            'discount_rate'     => 'float',
            'discount_sum'      => 'float',
            'shipping_type_id'  => 'int',
            'shipping_price'    => 'float',
            'shiping_name'      => 'string',
            'final_price'       => 'float',
            'status'            => 'int',
            'hide_recieved'     => 'int',
            'comments'          => 'string',
            'recipients'        => 'string',
            'update_date'       => 'string',
            'archived'          => 'int',
            'data'              => 'array',
            'buyer_name'        => 'string',
            'shop_username'     => 'string',
            'calculated_price'  => 'float',
            'products'          => 'array',
        ];
    }
}