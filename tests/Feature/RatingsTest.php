<?php
namespace Tests\Feature;

use App\Auth\Models\ApiUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RatingsTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $headers = [];
    
    
    public function setUp()
    {
        parent::setUp();
        $this->user = factory(ApiUser::class)->create();
    }
    
    public function testWithoutValidTokenShouldReturn401()
    {
        $this->headers['Accept'] = 'application/json';
        $this->get('/api/ratings/paginated', $this->headers)
        ->assertStatus(401)
        ->assertExactJson([
            "message" => "Unauthorized",
            "status" => 401,
            "data" => []
        ]);
    }
    
    public function testWithInvalidTokenScopeShouldReturn403()
    {
        $token = $this->user->createToken('TestToken', ['ages'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/genres/com', $this->headers)
        ->assertStatus(403)
        ->assertExactJson([
            "message" => "Forbidden",
            "status" => 403,
            "data" => []
        ]);
    }
    
    public function testLoadPaginatedChartRecords()
    {
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/paginated', $this->headers)
            ->assertStatus(200)
            ->assertJsonFragment([
            "avg_rating" => "4.61",
            "title" => "Sanjuro (1962)",
            "noOfRatings" => 100
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
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings', $this->headers)
            ->assertStatus(200)
            ->assertJsonFragment([
            "avg_rating" => "4.61",
            "title" => "Sanjuro (1962)",
            "noOfRatings" => 100
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
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/ages/56', $this->headers)
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
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/ages', $this->headers)
            ->assertStatus(404)
            ->assertExactJson([
            "message" => "Not Found",
            "status" => 404,
            "data" => []
        ]);
    }
    
    public function testSearchByAgeWithInvalidAge()
    {
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/ages/xx', $this->headers)
        ->assertStatus(500)
        ->assertExactJson([
            "message" => "Whoops, looks like something went wrong",
            "status" => 500,
            "data" => []
        ]);
    }

    public function testSearchByGenre()
    {
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/genres/Comedy', $this->headers)
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
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/genres', $this->headers)
            ->assertStatus(404)
            ->assertExactJson([
            "message" => "Not Found",
            "status" => 404,
            "data" => []
        ]);
    }
    
    public function testSearchByGenreWithInvalidGenre()
    {
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        $this->get('/api/ratings/genres/com', $this->headers)
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
