<?php

namespace Tests\Unit;


use App\Contracts\BuyerInterface;
use PHPUnit\Framework\TestCase;
use Tests\MocksBuyer;

class BuyerTest extends TestCase
{
    use MocksBuyer;

    /**
     * A basic test example.
     */
    public function test_buyer_implements_interface(): void
    {
        $this->assertInstanceOf( BuyerInterface::class, $this->getBuyerMock() );
    }

    public function test_buyer_has_id(): void
    {
        $this->assertEquals( $this->buyerId, $this->getBuyerMock()->id );
    }
}
