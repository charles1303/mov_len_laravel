<?php declare(strict_types=1);
namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 *
 * @author charles
 *
 */
class CacheServiceFactory
{

    /**
     *
     * @var RedisCacheService
     */
    private $redisCacheService;
    
    /**
     *
     * @var FileCacheService
     */
    private $fileCacheService;
    
    /**
     *
     * @var MemCacheService
     */
    private $memCacheService;
   
    public function __construct(RedisCacheService $redisCacheService, FileCacheService $fileCacheService, MemCacheService $memCacheService)
    {
        $this->redisCacheService = $redisCacheService;
        $this->fileCacheService = $fileCacheService;
        $this->memCacheService = $memCacheService;
    }
        
    /**
     * Factory method to return cache implementation
     * @return CacheServiceInterface
     */
    public function getCacheService() : CacheServiceInterface
    {
        $cacheServiceImpl = null;
        if (env('CACHE_DRIVER') == 'redis') {
            $cacheServiceImpl = $this->redisCacheService;
            Log::channel('daily')->info('Using Redis cache ');
        } elseif (env('CACHE_DRIVER') == 'file') {
            Log::channel('daily')->info('Using File cache ');
            $cacheServiceImpl = $this->fileCacheService;
        } elseif (env('CACHE_DRIVER') == 'memcached') {
            Log::channel('daily')->info('Using Memcache cache ');
            $cacheServiceImpl = $this->memCacheService;
        } else {
            Log::channel('daily')->info('Using Default cache ');
            $cacheServiceImpl = $this->fileCacheService;
        }
        return $cacheServiceImpl;
    }
}
