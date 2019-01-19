<?php
namespace Auth\Repositories;

/**
 *
 * @author charles
 *        
 */
interface ApiUserRepositoryInterface
{
    public function loadOrmApiUser(string $username);
    
    public function loadOrmTokenScope(string $name);
}

