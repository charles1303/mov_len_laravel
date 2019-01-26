<?php declare(strict_types=1);
namespace Auth\Services;

use App\Auth\Models\ApiUser;
use App\Auth\Models\TokenScope;
use Auth\Repositories\ApiUserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Auth\Pojos\ApiUserPojo;
use Exceptions\NoRecordFoundException;
use App\Auth\Models\ApiUserTokenScope;
use function GuzzleHttp\json_encode;

/**
 *
 * @author charles
 *        
 */
class ApiUserService
{
    /*
     * @var ApiUserRepositoryInterface
     */
    protected $apiUserRepo;
    
    public function __construct(ApiUserRepositoryInterface $apiUserRepo)
    {
        
        $this->apiUserRepo = $apiUserRepo;
    }
    
    public function registerUser(ApiUserPojo $apiUserPojo) : ?ApiUser{
        $apiUser = ApiUser::create([
            'name' => $apiUserPojo->name,
            'email' => $apiUserPojo->email,
            'password' => Hash::make($apiUserPojo->password)
        ]);
        
        return $apiUser;
    }
    
    public function assignTokenScope(string $email, array $tokenScopeNames) : ?ApiUser{
        $user = $this->apiUserRepo->getOrmApiUser($email);
        if(!$user){
            throw new NoRecordFoundException("User does not exist!");
        }
        $userTokenScopeArr = $user->apiUserTokenScopes;
        
        $existingTokenScopeIds = $this->getExistingUserTokenScopeIds(json_encode($userTokenScopeArr));
        
        $scopeArray = array();
        $incomingScopeIds = array();
        foreach ($tokenScopeNames as $scopeName){
            $tokenScope = $this->apiUserRepo->getOrmTokenScope($scopeName);
            $incomingScopeIds[] = $tokenScope->id;
            if (in_array($tokenScope->id, $existingTokenScopeIds)) {
                continue;
            }
            elseif (!in_array($tokenScope->id, $existingTokenScopeIds)) {
                $apiUserTokenScope = new ApiUserTokenScope();
                $apiUserTokenScope->token_scope_id = $tokenScope->id;
                $scopeArray[] = $apiUserTokenScope;
            }
            
        }
        $user->apiUserTokenScopes()->saveMany($scopeArray);
        
        $this->removeUserTokenScopes($user->id, array_diff($existingTokenScopeIds,$incomingScopeIds));
        $user::with(['apiUserTokenScopes' => function ($query) use ($user) {
            $query->where('api_user_id', '=', $user->id);
        }])->get();
        return $user;
    }
    
    private function removeUserTokenScopes(int $userId, array $tokenScopeToRemove){
        ApiUserTokenScope::where('api_user_id', '=', $userId)
        ->whereIn('token_scope_id', $tokenScopeToRemove)
        ->delete();
    }
    
    private function getOrmApiUser(string $username, string $password) : ?ApiUser
    {
        $user = $this->apiUserRepo->getOrmApiUser($username);
        
        if( Hash::check( $password, $user['password']) == false) {
            $user = null;
        }
        
        return $user;
    }
    
    public function getAccessToken(string $email, string $password) : object
    {
        $user = $this->getOrmApiUser($email, $password);
        
        if($user){
            $scopes = array();
            $userTokenScopes = $user->apiUserTokenScopes;
            
            $existingTokenScopeIds = $this->getExistingUserTokenScopeIds(json_encode($userTokenScopes));
            
            $scopes = $this->getScopeNames($existingTokenScopeIds);
            $token = $this->generateToken($user,'movieLens',$scopes);
            return $token;
        }else{
            throw new \Illuminate\Auth\AuthenticationException();
        }
    }
    
    public function generateToken(ApiUser $apiUser, string $tokenName, array $scopes) : object
    {
        return $apiUser->createToken($tokenName,$scopes);
    }
    /**
     * @param scopes
     * @param existingTokenScopeIds
     * @param scopes
     */private function getScopeNames(array $existingTokenScopeIds) : array
    {
        $tokenScopes = TokenScope::whereIn('id', $existingTokenScopeIds)
        ->get();
        $scopes = array();
        foreach($tokenScopes as $scope){
            $scopes[] = $scope->name;
        }
        
        return $scopes;
    }

    
    private function getExistingUserTokenScopeIds(string $userTokenScopeArr) : array{
        $existingTokenScopes = json_decode($userTokenScopeArr, true);
        
        return array_map(function($existingTokenScopes) {
            return $existingTokenScopes['token_scope_id'];
        }, $existingTokenScopes);
    }
}

