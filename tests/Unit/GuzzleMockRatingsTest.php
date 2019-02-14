<?php

/**
 *  test case.
 */
use Tests\TestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

class GuzzleMockRatingsTest extends TestCase
{

    /**
     *
     * @group ratings
     * Tests the mocked ratings api
     */
    public function testShouldReturnMockResponseInJsonFile()
    {
        $mock = new MockHandler([
            new Response(200, [
                'Content-Type' => 'application/json'
            ], file_get_contents(__DIR__ . '/fixtures/ratings.json'))
        ]);
        $expectedRequestStructure = '{"status": 200,"message": "success","data": [{"avg_rating": "4.61","title": "Sanjuro (1962)","noOfRatings": 100}]}';
        $handlerStack = HandlerStack::create($mock);
        $client = new Client([
            'handler' => $handlerStack
        ]);
        
        $response = $client->request('GET', '/api/ratings');
        $status = $response->getStatusCode();
        
        $this->assertJsonStringEqualsJsonString($expectedRequestStructure, $response->getBody()->__toString(), 'request body JSON');
        $this->assertEquals(200, $status);
        
    }
}

