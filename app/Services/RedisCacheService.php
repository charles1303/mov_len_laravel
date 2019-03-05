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
    
    public function get(string $cacheKey) : ?array
    {
        $data = Redis::get($cacheKey);
        if ($data) {
            $data = json_decode($data);
        }
        return $data;
    }
    
    public function clearCache()
    {
        Redis::flushDB();
    }
    
    public function put(string $cacheKey, array $value)
    {
        Redis::set($cacheKey, json_encode($value), 'EX', (env('CACHE_KEY_EXPIRY_DURATION_IN_MINUTES') * self::SECONDS_PER_MINUTE));
    }
}
