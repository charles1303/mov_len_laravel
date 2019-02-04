<?php declare(strict_types=1);
namespace App\Providers;

use App\Services\CacheServiceFactory;
use App\Services\FileCacheService;
use App\Services\MemCacheService;
use App\Services\RedisCacheService;
use Illuminate\Support\ServiceProvider;

/**
 *
 * @author charles
 *        
 */
class CustomCacheServiceProvider extends ServiceProvider
{

    /**
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);
    }
    
    public function register()
    {
        $this->app->bind('App\Services\CacheServiceFactory', function ($app) {
            return new CacheServiceFactory( new RedisCacheService(), new FileCacheService(), new MemCacheService());
        });
    }
}

