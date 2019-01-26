<?php declare(strict_types=1);
namespace Auth\Repositories;

use App\Auth\Models\ApiUser;
use App\Auth\Models\TokenScope;

/**
 *
 * @author charles
 *        
 */
interface ApiUserRepositoryInterface
{
    public function getOrmApiUser(string $username) : ?ApiUser;
    
    public function getOrmTokenScope(string $name) : ?TokenScope;
}

