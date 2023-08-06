<?php

namespace Tests;

use App\Data\Buyer;

trait MocksBuyer
{
    private int $buyerId = 29664;

    private function getBuyerMock()
    {
        static $buyer;

        if( is_null( $buyer ) ) {
            $buyer = new Buyer( array_merge(
                    ['id' => $this->buyerId ],
                    json_decode( file_get_contents( ROOT_PATH . 'mock/buyer.29664.json' ), true ) )
            );
        }

        return $buyer;
    }
}