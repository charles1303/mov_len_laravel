<?php declare(strict_types=1);
namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 *
 * @author charles
 *
 */
class MemCacheService implements CacheServiceInterface
{

    /**
     */
    public function __construct()
    {
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
