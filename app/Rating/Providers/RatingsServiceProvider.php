<?php declare(strict_types=1);
namespace Rating\Providers;

use Illuminate\Support\ServiceProvider;
use Rating\Services\RatingsService;
use App\Rating\Services\RatingsServiceCacheProxy;
use App\Rating\Services\RatingsServiceInterface;
use App\Http\Controllers\Rating\RatingController;

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
                $app->make('Rating\Repositories\RatingsRepositoryInterface')
                );
        });
        
        $this->app->when(RatingsServiceCacheProxy::class)
        ->needs(RatingsServiceInterface::class)
        ->give(RatingsService::class);
        
        $this->app->when(RatingController::class)
        ->needs(RatingsServiceInterface::class)
        ->give(RatingsServiceCacheProxy::class);
    }
}
