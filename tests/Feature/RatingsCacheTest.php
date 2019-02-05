<?php

namespace Tests\Feature;

use App\Auth\Models\ApiUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RatingsCacheTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $headers = [];
    protected $ratingService;
    
    public function testExample()
    {
        $this->assertTrue(true);
    }
    
    public function setUp()
    {
        parent::setUp();
        $this->user = factory(ApiUser::class)->create();
    }
    
    public function testCacheFlushedSuccessfully()
    {
        $token = $this->user->createToken('TestToken', ['ratings'])->accessToken;
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
        
        $this->get('/api/ratings/clear-cache', $this->headers)
        ->assertStatus(200)
        ->assertJsonFragment([
            "status" => 200,
            "message" => "success",
            "data" => "Cache flushed and data refreshed"
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
