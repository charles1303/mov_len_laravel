<?php declare(strict_types=1);
namespace App\Services;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Redis;

/**
 *
 * @author charles
 *
 */
class RedisCacheService implements CacheServiceInterface
{
    private const SECONDS_PER_MINUTE = 60;
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
        $key = $methodCallParams == null ? $cacheKey : $cacheKey . ':' . $methodCallParams;
        $data = Redis::get($key);
        if ($data) {
            return json_decode($data);
        } else {
            $data = call_user_func(array($repository, $repositoryMethodCall), $methodCallParams);
            Redis::set($key, json_encode($data), 'EX', (env('CACHE_KEY_EXPIRY_DURATION_IN_MINUTES') * self::SECONDS_PER_MINUTE));
        }
        return $data;
    }
    public function clearCache()
    {
        Redis::flushDB();
    }
}
