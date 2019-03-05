<?php

/**
 *  test case.
 */
use App\Auth\Models\ApiUser;
use App\Auth\Models\ApiUserTokenScope;
use App\Auth\Models\TokenScope;
use Auth\Dto\ApiUserDto;
use Auth\Repositories\ApiUserRepository;
use Auth\Services\ApiUserService;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Passport\PersonalAccessTokenResult;
use Tests\TestCase;

class GuzzleMockRatingsTest extends TestCase
{
    protected $user;
    
    protected $headers = [];
    
    protected $tokenScopeTypes = [];
    
    protected $apiUserService;
    
    protected $personalTokenFactory;
    
    protected $serviceMock;
    
    public function tearDown()
    {
        parent::tearDown();
        
        Mockery::close();
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $this->apiUserMock = Mockery::mock(ApiUser::class);
        $this->repoMock = Mockery::mock(ApiUserRepository::class);
        $this->serviceMock = Mockery::mock(ApiUserService::class);
        $this->personalTokenFactory = Mockery::mock(PersonalAccessTokenFactory::class);
        $this->createApplication();
    }
    
    /**
     *
     * @group ratings
     * Tests the mocked ratings api
     */
    public function testCreate()
    {
        $apiUserDto = new ApiUserDto();
        $apiUserDto->email = 'charles@test.com';
        $apiUserDto->password = 'password';
        $apiUserDto->name = 'charlie';
        
        $apiUser = new ApiUser();
        $apiUser->id = 1;
        $apiUser->fill(['name' => $apiUserDto->name, 'email' => $apiUserDto->email, 'password' => Hash::make($apiUserDto->password)]);
        
        $this->serviceMock
        ->shouldReceive('registerUser')
        ->with($apiUserDto)
        ->once()
        ->andReturn($apiUser);
        
        $user = $this->serviceMock->registerUser($apiUserDto);
        
        
        $tokenScope = new TokenScope();
        $tokenScope->id = 1;
        $tokenScope->fill(['name' => 'ratings']);
        
        
        
        
        $apiUserTokenScope = new ApiUserTokenScope();
        $apiUserTokenScope->api_user_id = $user->id;
        $apiUserTokenScope->token_scope_id = $tokenScope->id;
        
        $user->apiUserTokenScopes = [$apiUserTokenScope];
        
        $passportToken =  new Laravel\Passport\Token();
        $passportToken->scopes = [$tokenScope->name];
        $passportToken->user_id = $user->id;
        $passportToken->created_at = now();
        
        $personalToken = new PersonalAccessTokenResult(bin2hex(random_bytes(16)), $passportToken);
        
        $this->serviceMock
        ->shouldReceive('generateToken')
        ->with($user, 'TestToken', [$tokenScope->name])
        ->once()
        ->andReturn($personalToken);
        
        $token = $this->serviceMock->generateToken($user, 'TestToken', [$tokenScope->name]);
        $this->assertTrue($token->token->scopes == [$tokenScope->name]);
        $this->assertEquals($apiUserTokenScope->api_user_id, $user->id);
        $this->assertEquals($token->token->user_id, $apiUserTokenScope->api_user_id);
    }
    
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
