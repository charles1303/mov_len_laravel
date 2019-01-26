<?php
declare(strict_types=1);
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
    
    public function __construct(ApiUser $apiUser)
    {
        
        $this->apiUser = $apiUser;
    }
    
    public function getOrmApiUser(string $username): ?ApiUser
    {
        $user = ApiUser::where('email', $username)
        ->first();
        
        return $user;
    }
    
    public function getOrmTokenScope(string $name): ?TokenScope
    {
        $user = TokenScope::where('name', $name)
        ->first();
        
        return $user;
    }

}

