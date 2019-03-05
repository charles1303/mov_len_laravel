<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Auth\Models\ApiUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Auth\Models\TokenScope;
use function GuzzleHttp\json_encode;
use App\Auth\Models\ApiUserTokenScope;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth\Services\ApiUserService;
use Auth\Repositories\ApiUserRepository;

class TokenScopeTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $headers = [];
    protected $tokenScopeTypes = [];
    protected $apiUserService;
    public function setUp()
    {
        parent::setUp();
        $this->user = factory(ApiUser::class)->create();
        $this->apiUserService = new ApiUserService(new ApiUserRepository($this->user));
        
        $tokenScopeTypes = ["ratings","movies","ages"];
        
        $this->tokenScopeTypes = factory(TokenScope::class, count($tokenScopeTypes))->make()->each(function ($ts) {
            return $ts->save();
        });
    }
    
    public function testTokenScopeGeneratedIsSameAsAssignedToUser()
    {
        $apiUserTokenScope = new ApiUserTokenScope();
        
        $tokenScope = TokenScope::whereIn('name', $this->tokenScopeTypes)->first();
        
        $apiUserTokenScope->api_user_id = $this->user->id;
        $apiUserTokenScope->token_scope_id = $tokenScope->id;
        
        $this->user->apiUserTokenScopes = [$apiUserTokenScope];
        
        $token = $this->apiUserService->generateToken($this->user, 'TestToken', [$tokenScope->name]);
        
        $this->assertTrue($token->token->scopes == [$tokenScope->name]);
    }
    
    private function arrays_are_similar($firstArray, $secondArray)
    {
        sort($firstArray);
        sort($secondArray);
        if (count(array_diff_assoc($firstArray, $secondArray))) {
            return false;
        }
        foreach ($firstArray as $key => $val) {
            if ($val !== $secondArray[$key]) {
                return false;
            }
        }
        return true;
    }
}
