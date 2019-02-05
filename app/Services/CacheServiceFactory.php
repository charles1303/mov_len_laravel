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
        $cacheDriver = env('CACHE_DRIVER');
        switch ($cacheDriver) {
            case 'redis':
                Log::channel('daily')->info('Using Redis cache ');
                $cacheServiceImpl = $this->redisCacheService;
                break;
            case 'file':
                Log::channel('daily')->info('Using File cache ');
                $cacheServiceImpl = $this->fileCacheService;
                break;
            case 'memcached':
                Log::channel('daily')->info('Using Memcache cache ');
                $cacheServiceImpl = $this->memCacheService;
                break;
            default:
                Log::channel('daily')->info('Using Default cache ');
                $cacheServiceImpl = $this->fileCacheService;
        }
        return $cacheServiceImpl;
    }
}
