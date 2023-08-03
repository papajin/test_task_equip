<?php

namespace Tests\Unit;


use App\Contracts\BuyerInterface;
use App\Data\Buyer;
use PHPUnit\Framework\TestCase;

class BuyerTest extends TestCase
{
    const BUYER_ID = 29664;

    /**
     * A basic test example.
     */
    public function test_buyer_implements_interface(): void
    {
        $this->assertInstanceOf( BuyerInterface::class, $this->getBuyerMock() );
    }

    public function test_buyer_has_id(): void
    {
        $this->assertEquals( self::BUYER_ID, $this->getBuyerMock()->id );
    }

    private function getBuyerMock()
    {
        static $buyer;

        if( is_null( $buyer ) ) {
            $buyer = new Buyer( array_merge(
                    ['id' => self::BUYER_ID ],
                    json_decode( file_get_contents( ROOT_PATH . 'mock/buyer.29664.json' ), true ) )
            );
        }

        return $buyer;
    }
}
