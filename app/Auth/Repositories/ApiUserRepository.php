<?php
namespace Auth\Repositories;

use App\Auth\Models\ApiUser;
use App\Auth\Models\TokenScope;

/**
 *
 * @author charles
 *        
 */
class ApiUserRepository implements ApiUserRepositoryInterface
{

    protected $apiUser;
    
    /**
     */
    public function __construct(ApiUser $apiUser)
    {
        
        $this->apiUser = $apiUser;
    }
    
    public function loadOrmApiUser(string $username)
    {
        $user = ApiUser::where('email', $username)
        ->first();
        
        return $user;
    }
    
    public function loadOrmTokenScope(string $name)
    {
        $user = TokenScope::where('name', $name)
        ->first();
        
        return $user;
    }

}

