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
     * Gets data from cache if key exists else
     * pulls from database and stores in cache
     * for future reference
     *
     * @param object $repository
     * @param string $repositoryMethodCall
     * @param string $cacheKey
     * @return array
     */
    public function get(object $repository, string $repositoryMethodCall, string $cacheKey, $methodCallParams = null) : array;
    
    /**
     * Clears all data from cache
     */
    public function clearCache();
}
