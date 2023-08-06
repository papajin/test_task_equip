<?php

namespace Tests\Feature;


use Tests\BaseTest;
use Tests\MakesHttpRequests;

class ApiTest extends BaseTest
{
    use MakesHttpRequests;

    public function test_400_error()
    {
        $response = $this->post( '/api' );

        $this->assertGreaterThanOrEqual( 400, $response->getStatusCode() );
    }

    public function test_200_response()
    {
        $this->markTestSkipped( 'Provide all required parameters for the API call and comment this line.' );

        $response = $this->post( '/api', [
            //TODO: input here
        ] );

        $this->assertEquals( 200, $response->getStatusCode() );

        $content = json_decode( $response->getBody()->getContents(), true );
        $this->assertArrayHasKey( 'trackingNumber', $content );
    }
}