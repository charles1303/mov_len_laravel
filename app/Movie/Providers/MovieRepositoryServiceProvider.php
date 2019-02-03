<?php declare(strict_types=1);
namespace Movie\Providers;

use Illuminate\Support\ServiceProvider;
use Movie\Repositories\MovieRepository;
use Movie\Models\Movie;

/**
 *
 * @author charles
 *
 */
class MovieRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('Movie\Repositories\MovieRepositoryInterface', function ($app) {
            return new MovieRepository(new Movie());
        });
    }
}
