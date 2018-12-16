<?php
namespace Tests\Feature;

use Tests\TestCase;


class RatingsTest extends TestCase
{

    public function testLoadPaginatedChartRecords()
    {
        $this->get('/api/ratings/paginated')
            ->assertStatus(200)
            ->assertJsonFragment([
            "avg_rating" => "4.06",
            "title" => "Persuasion (1995)",
            "noOfRatings" => 200
        ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                        '*' =>  [
                            "avg_rating",
                            "title",
                            "noOfRatings"
                        ]
                    ]
        ]);
    }

    public function testLoadMovieRatings()
    {
        $this->get('/api/ratings')
            ->assertStatus(200)
            ->assertJsonFragment([
            "avg_rating" => "4.06",
            "title" => "Persuasion (1995)",
            "noOfRatings" => 200
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' =>  [
                    "avg_rating",
                    "title",
                    "noOfRatings"
                ]
            ]
        ]);
    }

    public function testSearchByAge()
    {
        $this->get('/api/ratings/ages/56')
            ->assertStatus(200)
            ->assertJsonFragment([
            "avg_rating" => "4.62",
            "title" => "Schindler's List (1993)",
            "noOfRatings" => 200
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' =>  [
                    "avg_rating",
                    "title",
                    "noOfRatings"
                ]
            ]
        ]);
    }

    public function testSearchByAgeWithoutAge()
    {
        $this->get('/api/ratings/ages')
            ->assertStatus(404)
            ->assertExactJson([
            "message" => "Not Found",
            "status" => 404,
            "data" => []
        ]);
    }
    
    public function testSearchByAgeWithInvalidAge()
    {
        $this->get('/api/ratings/ages/xx')
        ->assertStatus(404)
        ->assertExactJson([
            "message" => "No records found",
            "status" => 404,
            "data" => []
        ]);
    }

    public function testSearchByGenre()
    {
        $this->get('/api/ratings/genres/Comedy')
            ->assertStatus(200)
            ->assertJsonFragment([
            "avg_rating" => "4.28",
            "title" => "It Happened One Night (1934)",
            "noOfRatings" => 400
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' =>  [
                    "avg_rating",
                    "title",
                    "noOfRatings"
                ]
            ]
        ]);
    }

    public function testSearchByGenreWithoutGenre()
    {
        $this->get('/api/ratings/genres')
            ->assertStatus(404)
            ->assertExactJson([
            "message" => "Not Found",
            "status" => 404,
            "data" => []
        ]);
    }
    
    public function testSearchByGenreWithInvalidGenre()
    {
        $this->get('/api/ratings/genres/com')
        ->assertStatus(404)
        ->assertExactJson([
            "message" => "No records found",
            "status" => 404,
            "data" => []
        ]);
    }

    public function testInvalidUrl()
    {
        $this->get('/api/rating/paginated')
            ->assertStatus(404)
            ->assertExactJson([
            "message" => "Not Found",
            "status" => 404,
            "data" => []
        ]);
    }
}
