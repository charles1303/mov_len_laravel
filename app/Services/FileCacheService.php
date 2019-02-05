<?php declare(strict_types=1);
namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 *
 * @author charles
 *
 */
class FileCacheService implements CacheServiceInterface
{

    /**
     */
    public function __construct()
    {
    }
    
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
    public function getPut(object $repository, string $repositoryMethodCall, string $cacheKey, $methodCallParams = null) : array
    {
        $key = $methodCallParams == null ? $cacheKey : $cacheKey . ':' . $methodCallParams;
        $data = Cache::get($key, function () use ($repository, $repositoryMethodCall, $methodCallParams, $key) {
            $resultSet = call_user_func(array($repository, $repositoryMethodCall), $methodCallParams);
            Cache::put($key, $resultSet, env('CACHE_KEY_EXPIRY_DURATION_IN_MINUTES'));
            return $resultSet;
        });
        return $data;
    }
      
    /**
     * (non-PHPdoc)
     *
     * @see \App\Services\CacheServiceInterface::get()
     */
    public function get(object $repository, string $repositoryMethodCall, string $cacheKey, $methodCallParams = null) : array
    {
        $key = $methodCallParams == null ? $cacheKey : $cacheKey .':'. $methodCallParams;
        $data = Cache::remember($key, env('CACHE_KEY_EXPIRY_DURATION_IN_MINUTES'), function () use ($repository, $repositoryMethodCall, $methodCallParams, $key) {
            $resultSet = call_user_func(array($repository, $repositoryMethodCall), $methodCallParams);
            return $resultSet;
        });
        return $data;
    }
    public function clearCache()
    {
        Cache::flush();
    }
}
