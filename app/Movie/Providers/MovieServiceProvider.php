<?php declare(strict_types=1);
namespace Movie\Providers;

use App\Http\Controllers\Movie\MovieController;
use App\Movie\Services\MovieServiceCacheProxy;
use App\Movie\Services\MovieServiceInterface;
use Illuminate\Support\ServiceProvider;
use Movie\Services\MovieService;

/**
 *
 * @author charles
 *
 */
class MovieServiceProvider extends ServiceProvider
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
        $this->app->bind('Movie\Services\MovieService', function ($app) {
            return new MovieService(
                $app->make('Movie\Repositories\MovieRepositoryInterface')
                );
        });
        
        $this->app->when(MovieServiceCacheProxy::class)
            ->needs(MovieServiceInterface::class)
            ->give(MovieService::class);
            
        $this->app->when(MovieController::class)
            ->needs(MovieServiceInterface::class)
            ->give(MovieServiceCacheProxy::class);
    }
}
