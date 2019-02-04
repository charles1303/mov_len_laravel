<?php declare(strict_types=1);
namespace Movie\Providers;

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
                $app->make('Movie\Repositories\MovieRepository'),
                $app->make('App\Services\CacheServiceFactory')
                );
        });
    }
}
