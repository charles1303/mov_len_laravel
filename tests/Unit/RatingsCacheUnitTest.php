<?php

/**
 *  test case.
 */
use App\Rating\Services\RatingsServiceCacheProxy;
use Rating\Repositories\RatingsRepositoryInterface;
use Tests\TestCase;

class RatingsCacheUnitTest extends TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @group cache_ratings
     */
    public function testCacheProxyImplementationForRatings()
    {
        $ratingsRepoMock = Mockery::mock(RatingsRepositoryInterface::class);
        $expectedData[] = ["avg_rating" => "4.61","title" => "Sanjuro (1962)","noOfRatings"=> 100];
        $ratingsRepoMock->shouldReceive('getMovieRatings')->once()->andReturn($expectedData);
        $this->app->instance(RatingsRepositoryInterface::class, $ratingsRepoMock);
       
        $ratingsCacheService = $this->app->make(RatingsServiceCacheProxy::class);
       
        $actualData = $ratingsCacheService->getMovieRatings();
        $this->assertNotNull($actualData);
        $this->assertEquals($expectedData, $actualData);
    }
}
