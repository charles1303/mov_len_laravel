<?php
namespace Tests\Feature;

use App\Auth\Models\ApiUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Auth\Models\TokenScope;
use function GuzzleHttp\json_encode;
use App\Auth\Models\ApiUserTokenScope;

/**
 *
 * @author charles
 *
 */
class RatingsPassportTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $headers = [];
    public function setUp()
    {
        parent::setUp();
       
        $this->user = factory(ApiUser::class)->create();
    }
    
    public function testRatingsReturns200()
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
}
