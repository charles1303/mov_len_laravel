<?php declare(strict_types=1);
namespace Rating\Providers;

use Illuminate\Support\ServiceProvider;
use Rating\Services\RatingsService;

/**
 *
 * @author charles
 *
 */
class RatingsServiceProvider extends ServiceProvider
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
        $this->app->bind('Rating\Services\RatingsService', function ($app) {
            return new RatingsService(
                
                $app->make('Rating\Repositories\RatingsRepositoryInterface'),
                $app->make('App\Services\CacheServiceFactory')
                );
        });
    }
}
