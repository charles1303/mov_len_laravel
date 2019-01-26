<?php

namespace Tests\Unit;

use Tests\TestCase;

class RatingsTest extends TestCase
{
    protected $ratingService;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->ratingService = $this->app->make('Rating\Services\RatingsService');
    }
    
    public function testSortMovieRatings()
    {
        $expectedValue = '[
    {
        "avg_rating": "4.06",
        "title": "City of Lost Children, The (1995)",
        "noOfRatings": 500
    },
    {
        "avg_rating": "4.06",
        "title": "Persuasion (1995)",
        "noOfRatings": 200
    },
    {
        "avg_rating": "3.65",
        "title": "Leaving Las Vegas (1995)",
        "noOfRatings": 1000
    },
    {
        "avg_rating": "3.65",
        "title": "Shanghai Triad (Yao a yao yao dao waipo qiao) (1995)",
        "noOfRatings": 100
    },
    {
        "avg_rating": "3.62",
        "title": "Get Shorty (1995)",
        "noOfRatings": 1400
    },
    {
        "avg_rating": "3.53",
        "title": "Othello (1995)",
        "noOfRatings": 100
    },
    {
        "avg_rating": "3.35",
        "title": "Copycat (1995)",
        "noOfRatings": 400
    },
    {
        "avg_rating": "3.18",
        "title": "Powder (1995)",
        "noOfRatings": 700
    },
    {
        "avg_rating": "2.93",
        "title": "Now and Then (1995)",
        "noOfRatings": 100
    },
    {
        "avg_rating": "2.86",
        "title": "Assassins (1995)",
        "noOfRatings": 200
    }
]';
        
        $testValue = '[
    {
        "avg_rating": "3.65",
        "title": "Leaving Las Vegas (1995)",
        "noOfRatings": 1000
    },
    {
        "avg_rating": "3.65",
        "title": "Shanghai Triad (Yao a yao yao dao waipo qiao) (1995)",
        "noOfRatings": 100
    },
    {
        "avg_rating": "4.06",
        "title": "Persuasion (1995)",
        "noOfRatings": 200
    },
    {
        "avg_rating": "4.06",
        "title": "City of Lost Children, The (1995)",
        "noOfRatings": 500
    }, 
    {
        "avg_rating": "2.93",
        "title": "Now and Then (1995)",
        "noOfRatings": 100
    },
    {
        "avg_rating": "2.86",
        "title": "Assassins (1995)",
        "noOfRatings": 200
    },
    {
        "avg_rating": "3.62",
        "title": "Get Shorty (1995)",
        "noOfRatings": 1400
    },
    {
        "avg_rating": "3.53",
        "title": "Othello (1995)",
        "noOfRatings": 100
    },
    {
        "avg_rating": "3.35",
        "title": "Copycat (1995)",
        "noOfRatings": 400
    },
    {
        "avg_rating": "3.18",
        "title": "Powder (1995)",
        "noOfRatings": 700
    }
]';
        
        $expectedValue = json_decode($expectedValue);
        $testValue = json_decode($testValue);
        
        $actualValue = $this->ratingService->sortMovieRatings($testValue);
        
        $this->assertEquals($actualValue, $expectedValue);
        $this->assertNotEquals($actualValue, $testValue);
    }
}
