<?php


use Tests\BaseTest;
use Tests\MakesHttpRequests;

class IndexTest extends BaseTest
{
    use MakesHttpRequests;

    public function test_response()
    {
        $response = $this->get( '/' );

        $this->assertEquals(200, $response->getStatusCode());
    }
}