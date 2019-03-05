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

    public function put(string $cacheKey, array $value)
    {
        Cache::put($cacheKey, $value, env('CACHE_KEY_EXPIRY_DURATION_IN_MINUTES'));
    }
      
    /**
     * (non-PHPdoc)
     *
     * @see \App\Services\CacheServiceInterface::get()
     */
    public function get(string $cacheKey) : ?array
    {
        return Cache::get($cacheKey);
        
    }
    
    public function clearCache()
    {
        Cache::flush();
    }
}
