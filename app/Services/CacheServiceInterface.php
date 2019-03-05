<?php declare(strict_types=1);
namespace App\Services;

/**
 *
 * @author charles
 *
 */
interface CacheServiceInterface
{
    /**
     * Clears all data from cache
     */
    public function clearCache();
    
    /**
     * Gets data from cache 
     * 
     * @param string $cacheKey
     * @return array
     */
    public function get(string $cacheKey) : ?array;
    
    /**
     * Adds data to cache
     * 
     * @param string $cacheKey
     * @param object $value
     */
    public function put(string $cacheKey, array $value);
}
