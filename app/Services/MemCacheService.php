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
    public function clearCache()
    {
        Cache::flush();
    }
    
    public function get(string $cacheKey) : array
    {
        return Cache::get($cacheKey);
    }
    
    public function put(string $cacheKey, array $value)
    {
        Cache::put($cacheKey, $value, env('CACHE_KEY_EXPIRY_DURATION_IN_MINUTES'));
    }
}
